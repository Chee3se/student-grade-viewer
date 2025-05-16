<?php

namespace App\Controllers;

use App\Models\Subject;
use App\Models\User;
use core\Request;

class SubjectController
{
    public function index(): void {
        $subjects = Subject::all()->getAll();

        foreach ($subjects as &$subject) {
            $user = (new User())->find($subject['user_id'])->get();
            $subject['user'] = $user;
            unset($subject['user_id']); // Optionally remove user_id
        }

        view('subject/index', compact('subjects'));
    }
    public function create(): void {
        $users = User::all()->getAll();
        view('subject/create', compact('users'));
    }
    public function store(Request $request): void {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'user_id' => 'required|integer'
        ]);

        $data = [
            'name' => request('name'),
            'description' => request('description'),
            'user_id' => request('user_id')
        ];

        Subject::create($data);
        redirect('/subjects');
    }
    public function edit(int $id): void {
        $subject = Subject::find($id)->get();
        $users = User::all()->getAll();

        if (!$subject) {
            redirect('/subjects');
        }

        view('subject/edit', compact('subject', 'users'));
    }
    public function update(Request $request, int $id): void {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'user_id' => 'required|integer'
        ]);

        $data = [
            'name' => request('name'),
            'description' => request('description'),
            'user_id' => request('user_id')
        ];

        Subject::update($id, $data);
        redirect('/subjects');
    }
    public function destroy(int $id): void {
        Subject::delete($id);
        redirect('/subjects');
    }
}