<?php

namespace App\Controllers;

use App\Models\User;
use core\FileUpload;
use core\Request;
use core\Session;

class UserController
{
    public function index(): void
    {
        $users = User::all()->getAll();

        view('user/index', ['users' => $users]);
    }
    public function show(): void
    {
        $user = User::where('id', '=', Session::get('user')['ID'])->get();
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

    public function image(Request $request): void
    {
        if (!is_dir(BASE_PATH . "/public/storage/users/")) {
            mkdir(BASE_PATH . "/public/storage/"); // Make storage dir
            mkdir(BASE_PATH . "/public/storage/users/"); // Make users dir
        }

        if (request('image') && request('image')['error'] !== UPLOAD_ERR_NO_FILE) {
            $request->validate([
                'image' => 'required|image'
            ]);

            $file = request('image');

            $to = BASE_PATH . '/public/storage/users/' . $file['name'];
            $from = $file['tmp_name'];

            if (!move_uploaded_file($from, $to)) {
                dd('nuh uh');
            }
            User::update(Session::get('user')['ID'], ['image' => '/storage/users/' . $file['name']]);
        } elseif (request('url')) {
            $request->validate([
                'url' => 'required|url'
            ]);
            User::update(Session::get('user')['ID'], ['image' => request('url')]);
        }

        redirect('/profile');
    }
}