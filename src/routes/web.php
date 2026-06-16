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

Route::get('/dashboard', function () {
    return view('dashboard');
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