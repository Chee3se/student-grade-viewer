<?php

namespace App\Controllers;

use App\Models\Subject;
use App\Models\User;
use core\Request;

class SubjectController
{
    public function index(): void
    {
        $subjects = Subject::all()->getAll();

        foreach ($subjects as &$subject) {
            $user = (new User())->find($subject['user_id'])->get();
            $subject['user'] = $user;
            unset($subject['user_id']); // Optionally remove user_id
        }

        view('subject/index', compact('subjects'));
    }

    public function create(): void
    {
        view('subject/create');
    }

    public function store(Request $request): void
    {
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
        redirect('/dashboard')->withSuccess('Priekšmets veiksmīgi pievienots!');
    }

    public function edit(Request $request, int $id): void
    {
        $subject = Subject::find($id)->get();

        if (!$subject) {
            redirect('/dashboard')->withError('form', 'Priekšmets nav atrasts');
            return;
        }

        view('subject/edit', compact('subject'));
    }

    public function update(Request $request, int $id): void
    {
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

        Subject::update($data, $id);
        redirect('/dashboard')->withSuccess('Priekšmets veiksmīgi atjaunināts!');
    }

    public function destroy(Request $request, int $id): void
    {
        // Check if subject exists
        $subject = Subject::find($id)->get();
        if (!$subject) {
            redirect('/dashboard')->withError('form', 'Priekšmets nav atrasts');
            return;
        }

        Subject::delete($id);
        redirect('/dashboard')->withSuccess('Priekšmets veiksmīgi dzēsts!');
    }
}