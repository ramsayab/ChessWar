<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserChessController extends Controller
{
    public function register(Request $request) {
        $incomingFields = $request->validate([
            'firstname' => ['required', 'min:3', 'max:10'],
            'lastname' => ['required', 'min:3', 'max:10'],
            'username' => ['required', 'min:2', 'max:20'],
            'email' => ['required', 'email'],
            'password' => 'required',
            'confirm' => 'required',
            'level' => 'required',
        ]);

        $incomingFIelds['password'] = bcrypt($incomingFields['password']);
        User::create($incomingFIelds);

        return 'Hello from our controller';
    }
}
