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
                
                // Ensure grades have numeric values
                if (is_array($grades)) {
                    foreach ($grades as &$grade) {
                        if (isset($grade['grade'])) {
                            // Convert to float to ensure it's numeric
                            $grade['grade'] = (float) $grade['grade'];
                        }
                    }
                    unset($grade); // Break the reference
                }
                
                // Log data counts for debugging
                error_log("Students: " . (is_array($students) ? count($students) : "not an array"));
                error_log("Subjects: " . (is_array($subjects) ? count($subjects) : "not an array"));
                error_log("Grades: " . (is_array($grades) ? count($grades) : "not an array"));
                
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