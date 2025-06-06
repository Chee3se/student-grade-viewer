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
        $users = User::where('role', '=', 'student')->getAll();
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
            'user_id' => (int) request('user_id'),
            'subject_id' => (int) request('subject_id'),
            'grade' => (float) number_format(request('grade'), 2, '.', '')
        ];

        Grade::create($data);
        redirect('/dashboard?subject=' . $data['subject_id'])->withSuccess('Atzīme veiksmīgi pievienota!');
    }

    public function edit(Request $request, int $id): void
    {
        $grade = Grade::find($id)->get();
        $users = User::where('role', '=', 'student')->getAll();
        $subjects = Subject::all()->getAll();

        if (!$grade) {
            redirect('/dashboard')->withError('form', 'Atzīme nav atrasta');
            return;
        }

        view('grade/edit', compact('grade', 'users', 'subjects'));
    }

    public function update(Request $request, int $id): void
    {
        $request->validate([
            'user_id' => 'required|numeric',
            'subject_id' => 'required|numeric',
            'grade' => 'required|numeric'
        ]);

        if (request('grade') > 10 || request('grade') < 1) {
            redirect('/dashboard')->withError('Grade has not been updated');
            return;
        }

        $data = [
            'user_id' => (int) request('user_id'),
            'subject_id' => (int) request('subject_id'),
            'grade' => (float) number_format(request('grade'), 2, '.', '')
        ];

        Grade::update($id, $data);
        redirect('/dashboard')->withSuccess('Atzīme veiksmīgi atjaunināta!');
    }

    public function destroy(Request $request, int $id): void
    {
        // Check if grade exists
        $grade = Grade::find($id)->get();
        if (!$grade) {
            redirect('/dashboard')->withError('form', 'Atzīme nav atrasta');
            return;
        }

        Grade::delete($id);
        redirect('/dashboard')->withSuccess('Atzīme veiksmīgi dzēsta!');
    }
}