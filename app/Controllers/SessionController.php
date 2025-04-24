<?php

namespace App\Controllers;

use App\Models\User;
use Core\Request;
use Core\Session;

class SessionController
{
    public function create(): void
    {
        view('user/login');
    }

    public function store(Request $request): void
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', '=', request('email'))->first();

        if (!$user || !password_verify(request('password'), $user->password)) {
            redirect('/login');
            return;
        }

        Session::put('user', $user);
        redirect('/');
    }
}