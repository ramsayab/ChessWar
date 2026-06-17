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

    return view('dashboard', compact('tab', 'winrate', 'powerCounts', 'avgMinutes', 'totalMatches', 'wonMatches', 'matches'));
})->middleware('auth')->name('dashboard');

Route::get('/game', function () {
    return view('game');
})->middleware('auth')->name('game');

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

Route::middleware('auth')->prefix('api')->group(function () {
    // 1. Leaderboard API
    Route::get('/leaderboard', function () {
        $leaderboard = \App\Models\User::select('users.id', 'users.name')
            ->selectRaw('count(matches.id) as total_matches')
            ->selectRaw('sum(case when matches.is_win = 1 then 1 else 0 end) as won_matches')
            ->join('matches', 'users.id', '=', 'matches.user_id')
            ->groupBy('users.id', 'users.name')
            ->orderByRaw('sum(case when matches.is_win = 1 then 1 else 0 end) desc')
            ->take(10)
            ->get()
            ->map(function ($player, $index) {
                $total = (int)$player->total_matches;
                $won = (int)$player->won_matches;
                return [
                    'rank' => $index + 1,
                    'name' => $player->name,
                    'total_matches' => $total,
                    'won_matches' => $won,
                    'winrate' => $total > 0 ? round(($won / $total) * 100) . '%' : '0%',
                ];
            });

        return response()->json([
            'success' => true,
            'leaderboard' => $leaderboard,
        ]);
    });

    // 2. Personal Stats API
    Route::get('/user/stats', function () {
        $user = auth()->user();
        $total = $user->matches()->count();
        $won = $user->matches()->where('is_win', true)->count();
        $avgSeconds = $user->matches()->avg('total_time') ?? 0;

        return response()->json([
            'success' => true,
            'stats' => [
                'name' => $user->name,
                'total_matches' => $total,
                'won_matches' => $won,
                'winrate' => $total > 0 ? round(($won / $total) * 100) : 0,
                'avg_duration_minutes' => round($avgSeconds / 60, 1),
            ]
        ]);
    });

    // 3. Powers API
    Route::get('/powers', function () {
        return response()->json([
            'success' => true,
            'powers' => [
                [
                    'value' => 'blink_knight',
                    'name' => 'Blink Knight',
                    'description' => 'Knight jumps with a longer reach, doubling the usual movement patterns.'
                ],
                [
                    'value' => 'super_rook',
                    'name' => 'Super Rook',
                    'description' => 'Rook keeps straight lines and gains one-step forward diagonals.'
                ],
                [
                    'value' => 'confused_pawn',
                    'name' => 'Confused Pawn',
                    'description' => 'Pawn can move backward too, making file control much more chaotic.'
                ]
            ]
        ]);
    });

    // 4. Save Game API
    Route::post('/game/save', function (Illuminate\Http\Request $request) {
        $request->validate([
            'fen' => 'required|string',
            'power_type' => 'nullable|string',
        ]);

        $savedGame = \App\Models\SavedGame::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'fen' => $request->fen,
                'power_type' => $request->power_type,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Game state saved successfully.',
            'saved_game' => $savedGame,
        ]);
    });

    // 5. Resume Game API
    Route::get('/game/resume', function () {
        $savedGame = auth()->user()->savedGame;

        if (!$savedGame) {
            return response()->json([
                'success' => false,
                'message' => 'No saved game found for this user.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'saved_game' => $savedGame,
        ]);
    });
});