<?php

namespace App\Controllers;

use App\Models\User;
use core\Request;
use core\Session;

class UserController
{
    public function create(): void
    {
        view('user/create');
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
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'password' => 'required|string|min:6',
            'role' => 'required|string'
        ]);

        // Check if email already exists
        $existingUser = User::where('email', '=', request('email'))->get();
        if ($existingUser) {
            redirect('/users/create')->withError('email', 'Ši e-pasta adrese jau tiek izmantota');
            return;
        }

        $data = [
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
            'password' => password_hash(request('password'), PASSWORD_DEFAULT),
            'role' => request('role')
        ];

        User::create($data);
        redirect('/dashboard')->withSuccess('Skolēns veiksmīgi pievienots!');
    }

    public function edit(Request $request, int $id): void
    {
        $user = User::find($id)->get();

        if (!$user) {
            redirect('/dashboard')->withError('form', 'Skolēns nav atrasts');
            return;
        }

        view('user/edit', compact('user'));
    }

    public function update(Request $request, int $id): void
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|max:100'
        ]);

        // Check if email already exists for other users
        $existingUser = User::where('email', '=', request('email'))->get();
        if ($existingUser && $existingUser['id'] != $id) {
            redirect('/users/' . $id . '/edit')->withError('email', 'Šis e-pasta adrese jau tiek izmantota');
            return;
        }

        $data = [
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email')
        ];

        // Only update password if provided
        if (request('password') && !empty(trim(request('password')))) {
            $data['password'] = password_hash(request('password'), PASSWORD_DEFAULT);
        }

        User::update($data, $id);
        redirect('/dashboard')->withSuccess('Skolēns veiksmīgi atjaunināts!');
    }

    public function destroy(Request $request, int $id): void
    {
        // Check if user exists
        $user = User::find($id)->get();
        if (!$user) {
            redirect('/dashboard')->withError('form', 'Skolēns nav atrasts');
            return;
        }

        // Don't allow deletion of current user
        if ($_SESSION['user']['id'] == $id) {
            redirect('/dashboard')->withError('form', 'Nevar dzēst savu kontu');
            return;
        }

        User::delete($id);
        redirect('/dashboard')->withSuccess('Skolēns veiksmīgi dzēsts!');
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
        if (Session::get('user')['image'] !== '/images/default.png') {
            unlink(BASE_PATH . "/public" . Session::get('user')['image']);
        }

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