<?php

namespace App\Controllers;

use App\Models\User;
use Core\Request;
use Core\Session;

class UserController
{
    public function index(): void
    {
        $users = User::all()->getAll();

        view('user/index', ['users' => $users]);
    }
    public function show(): void
    {
        $user = User::find(Session::get('user')['id']);

        view('user/show', ['user' => $user]);
    }

    public function store(Request $request): void
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $data['password'] = hash_make(request('password'));
        $data['name'] = request('name');
        $data['email'] = request('email');

        User::create($data);

        redirect('/users');
    }
}