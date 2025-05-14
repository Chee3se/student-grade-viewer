<?php

namespace App\Controllers;

use App\Models\User;
use core\Request;
use core\Session;

class UserController
{
    public function index(): void
    {
        $users = User::all()->getAll();
        view('user/index', compact('users'));
    }
    public function show(): void
    {
        $user = User::where('id', '=', Session::get('user')['id'])->get();
        Session::put('user', $user);
        view('user/show', compact('user'));
    }
    public function store(Request $request): void
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);

        $data['password'] = hash_make(request('password'));
        $data['name'] = request('name');
        $data['email'] = request('email');

        User::create($data);

        redirect('/users');
    }
    public function image(Request $request): void
    {
        $request->validate([
            'image' => 'required|image'
        ]);
        if (request('image')['error'] === UPLOAD_ERR_NO_FILE) {
            $request->error('image', 'No file uploaded');
        }

        if (!is_dir(BASE_PATH . "/public/storage/users/")) {
            mkdir(BASE_PATH . "/public/storage/"); // Make storage dir
            mkdir(BASE_PATH . "/public/storage/users/"); // Make users dir
        }

        unlink(BASE_PATH . "/public" . Session::get('user')['image']);

        $file = request('image');
        $random = generateRandomString() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $to = BASE_PATH . '/public/storage/users/' . $random;
        $from = $file['tmp_name'];
        if (!move_uploaded_file($from, $to)) {
            dd('nuh uh');
        }
        User::update(Session::get('user')['id'], ['image' => '/storage/users/' . $random]);
        redirect('/profile');
    }
    public function password(Request $request): void
    {
        $request->validate([
            'password' => 'required',
            'new_password' => 'required|min:8',
        ]);

        $user = User::where('id', '=', Session::get('user')['id'])->get();

        if (!hash_check(request('password'), $user['password'])) {
            $request->error('password', 'Nepareiza parole');
        }

        if (request('new_password') == request('password')) {
            $request->error('new_password', 'Jaunā parole nedrīkst būt tāda pati kā vecā');
        }

        User::update(Session::get('user')['id'], ['password' => hash_make(request('new_password'))]);
        Session::flush();
        redirect('/profile');
    }
}