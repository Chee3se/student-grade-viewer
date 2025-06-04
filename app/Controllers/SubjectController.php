<?php

namespace App\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\User;
use core\Database;
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
        // Get all teachers for the dropdown
        $teachers = (new User())->where('role', '=', 'teacher')->getAll();
        view('subject/create', compact('teachers'));
    }

    public function store(Request $request): void
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'user_id' => 'required|integer'
        ]);

        // Validate that the user_id corresponds to a legitimate teacher
        $teacher = (new User())->where('id', '=', request('user_id'))
            ->where('role', '=', 'teacher')
            ->first();

        if (!$teacher) {
            redirect('/subjects/create')->withError('form', 'Izvēlētais skolotājs nav derīgs!');
            return;
        }

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

        // Get all teachers for the dropdown
        $teachers = (new User())->where('role', '=', 'teacher')->getAll();
        view('subject/edit', compact('subject', 'teachers'));
    }

    public function update(Request $request, int $id): void
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'user_id' => 'required|integer'
        ]);

        // Validate that the user_id corresponds to a legitimate teacher
        $teacher = (new User())->where('id', '=', request('user_id'))
            ->where('role', '=', 'teacher')
            ->first();

        if (!$teacher) {
            redirect('/subjects/' . $id . '/edit')->withError('form', 'Izvēlētais skolotājs nav derīgs!');
            return;
        }

        $data = [
            'name' => request('name'),
            'description' => request('description'),
            'user_id' => request('user_id')
        ];

        Subject::update($id, $data);
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

        Grade::execute('DELETE FROM grades WHERE subject_id = :subject_id', ['subject_id' => $id]);

        Subject::delete($id);

        redirect('/dashboard')->withSuccess('Priekšmets veiksmīgi dzēsts!');
    }
}