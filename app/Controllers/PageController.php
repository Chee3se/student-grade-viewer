<?php

namespace App\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\User;
use core\Session;

class PageController
{
    public function index(): void
    {
        //$users = User::all()->getAll();
        view('index');
    }

    public function dashboard(): void
    {
        $role = Session::get('user')['role'];
        switch ($role) {
            case 'teacher':
                $students = User::where('role', '=', 'student')->getAll();
                $subjects = Subject::all()->getAll();
                $grades = Grade::all()->getAll();
                view("dashboard/teacher", [
                    'students' => $students,
                    'subjects' => $subjects,
                    'grades' => $grades
                ]);
                break;
            case 'student':
                view("dashboard/student");
                break;
        }
    }
}