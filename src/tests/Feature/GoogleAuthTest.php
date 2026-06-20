<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('google login route redirects to mock screen if client id is dummy', function () {
    $response = $this->get(route('auth.google'));
    
    $response->assertRedirect(route('auth.google.mock'));
});

test('google mock callback logs in a user and redirects to dashboard', function () {
    $email = 'testuser@gmail.com';
    $name = 'Test User';
    
    $response = $this->get(route('auth.google.callback', [
        'mock' => 'true',
        'name' => $name,
        'email' => $email,
        'avatar_url' => 'https://example.com/avatar.png'
    ]));
    
    $response->assertRedirect('/dashboard');
    $this->assertDatabaseHas('users', [
        'email' => $email,
        'name' => $name,
    ]);
    
    $user = User::where('email', $email)->first();
    expect($user->google_id)->toBe('mock_' . md5($email));
    expect(auth()->check())->toBeTrue();
    expect(auth()->user()->id)->toBe($user->id);
});
