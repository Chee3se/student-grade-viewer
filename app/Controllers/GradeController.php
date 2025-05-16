<?php

namespace App\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\User;
use core\Request;

class GradeController
{
    public function create(): void
    {
        $users = User::all()->getAll();
        $subjects = Subject::all()->getAll();
        view('grade/create', compact('users', 'subjects'));
    }
    public function store(Request $request): void
    {
        $request->validate([
            'user_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'grade' => 'required|numeric'
        ]);

        $data = [
            'user_id' => request('user_id'),
            'subject_id' => request('subject_id'),
            'grade' => request('grade')
        ];

        Grade::create($data);
        redirect('/grades');
    }
    public function edit(int $id): void
    {
        $grade = Grade::find($id)->get();
        $users = User::all()->getAll();
        $subjects = Subject::all()->getAll();

        if (!$grade) {
            redirect('/grades');
        }

        view('grade/edit', compact('grade', 'users', 'subjects'));
    }
    public function update(Request $request, int $id): void
    {
        $request->validate([
            'user_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'grade' => 'required|numeric'
        ]);

        $data = [
            'user_id' => request('user_id'),
            'subject_id' => request('subject_id'),
            'grade' => request('grade')
        ];

        Grade::update($data, $id);
        redirect('/grades');
    }
    public function destroy(int $id): void
    {
        Grade::delete($id);
        redirect('/grades');
    }
}