<?php

use App\Http\Controllers\UserChessController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

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


Route::get('/register', function () {
    return view('register');
});


Route::get('/login', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});


Route::post('/mantap', [UserChessController::class, 'register']);