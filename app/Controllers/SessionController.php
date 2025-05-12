<?php

namespace App\Controllers;

use App\Models\User;
use core\Request;
use core\Session;

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
            'password' => 'required|min:6'
        ]);

        $user = User::where('email', '=', request('email'))->get();
        if (!isset($user) || !hash_check(request('password'), $user['password'])) {
            $request->error('password', 'Nepareizs e-pasts vai parole');
        }

        Session::put('user', $user);
        redirect('/dashboard');
    }

    public function destroy(): void
    {
        Session::flush();
        redirect('/');
    }
}