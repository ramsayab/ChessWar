<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use App\Http\Controllers\AuthController;

/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/

Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/*
/ END
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return auth()->check() ? redirect('/dashboard') : app(AuthController::class)->showLogin();
})->name('login');

Route::get('/register', function () {
    return auth()->check() ? redirect('/dashboard') : app(AuthController::class)->showRegister();
});

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::get('/auth/google/mock', function () {
    return view('auth.google_mock');
})->name('auth.google.mock');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/dashboard', function (Illuminate\Http\Request $request) {
    $user = auth()->user();
    $tab = $request->query('tab', 'overview');

    // Fetch stats
    $totalMatches = $user->matches()->count();
    $wonMatches = $user->matches()->where('is_win', true)->count();
    $winrate = $totalMatches > 0 ? round(($wonMatches / $totalMatches) * 100) : 0;

    $powerCounts = $user->matches()
        ->select('power_type', \DB::raw('count(*) as count'))
        ->groupBy('power_type')
        ->pluck('count', 'power_type')
        ->toArray();

    $avgSeconds = $user->matches()->avg('total_time') ?? 0;
    $avgMinutes = round($avgSeconds / 60, 1);

    // Fetch history
    $matches = $user->matches()->orderBy('created_at', 'desc')->get();

    // Fetch saved game
    $savedGame = $user->savedGame;

    // Fetch leaderboard data
    $leaderboard = \App\Models\User::select('users.id', 'users.name')
        ->selectRaw('count(matches.id) as total_matches')
        ->selectRaw('sum(case when matches.is_win = 1 then 1 else 0 end) as won_matches')
        ->leftJoin('matches', 'users.id', '=', 'matches.user_id')
        ->where(function($query) {
            $query->where('users.is_admin', '!=', 1)
                  ->orWhereNull('users.is_admin');
        })
        ->whereDoesntHave('roles', function($q) {
            $q->whereIn('name', ['admin', 'super_admin']);
        })
        ->groupBy('users.id', 'users.name')
        ->orderByRaw('sum(case when matches.is_win = 1 then 1 else 0 end) desc')
        ->orderByRaw('count(matches.id) desc')
        ->take(20)
        ->get()
        ->map(function ($player, $index) {
            $total = (int)$player->total_matches;
            $won = (int)$player->won_matches;
            return (object)[
                'rank' => $index + 1,
                'id' => $player->id,
                'name' => $player->name,
                'total_matches' => $total,
                'won_matches' => $won,
                'winrate' => $total > 0 ? round(($won / $total) * 100) : 0,
            ];
        });

    // Fetch puzzle progress
    $puzzlesSolved = $user->puzzleAttempts()->where('solved', true)->count();
    $puzzlesTotal = 10; // Total hardcoded puzzles

    return view('dashboard', compact(
        'tab', 'winrate', 'powerCounts', 'avgMinutes',
        'totalMatches', 'wonMatches', 'matches', 'savedGame',
        'leaderboard', 'puzzlesSolved', 'puzzlesTotal'
    ));
})->middleware('auth')->name('dashboard');

Route::get('/game', function () {
    return view('game');
})->middleware('auth')->name('game');

Route::get('/puzzle', function () {
    return view('puzzle');
})->middleware('auth')->name('puzzle');

Route::post('/matches', function (Illuminate\Http\Request $request) {
    $request->validate([
        'is_win' => 'required|boolean',
        'total_time' => 'required|integer',
        'power_type' => 'nullable|string',
    ]);

    $match = \App\Models\ChessMatch::create([
        'user_id' => auth()->id(),
        'is_win' => $request->is_win,
        'total_time' => $request->total_time,
        'power_type' => $request->power_type,
    ]);

    return response()->json([
        'success' => true,
        'match' => $match,
    ]);
})->middleware('auth');
