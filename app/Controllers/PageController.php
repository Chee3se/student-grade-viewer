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

                if (is_array($grades)) {
                    foreach ($grades as &$grade) {
                        if (isset($grade['grade'])) {
                            $grade['grade'] = (float) $grade['grade'];
                        }
                    }
                    unset($grade);
                }

                view("dashboard/teacher", [
                    'students' => $students,
                    'subjects' => $subjects,
                    'grades' => $grades
                ]);
                break;
            case 'student':
                $currentUserId = Session::get('user')['id'];

                $allStudentGrades = Grade::where('user_id', '=', $currentUserId)->getAll();

                $subjects = Subject::all()->getAll();
                $users = User::all()->getAll();

                $subjectMap = [];
                foreach ($subjects as $subject) {
                    $subjectMap[$subject['id']] = $subject;
                }

                $userMap = [];
                foreach ($users as $user) {
                    $userMap[$user['id']] = $user;
                }

                $enrichedGrades = [];
                foreach ($allStudentGrades as $grade) {
                    $subject = $subjectMap[$grade['subject_id']] ?? null;
                    $teacher = null;

                    if ($subject && isset($subject['user_id'])) {
                        $teacher = $userMap[$subject['user_id']] ?? null;
                    }

                    $enrichedGrades[] = [
                        'id' => $grade['id'],
                        'grade' => (float) $grade['grade'],
                        'subject_id' => $grade['subject_id'],
                        'subject_name' => $subject ? $subject['name'] : 'Unknown Subject',
                        'teacher_name' => $teacher ? $teacher['first_name'] . ' ' . $teacher['last_name'] : 'No Teacher',
                        'created_at' => $grade['created_at'] ?? null,
                        'updated_at' => $grade['updated_at'] ?? null
                    ];
                }

                usort($enrichedGrades, function($a, $b) {
                    return strtotime($b['created_at'] ?? '1970-01-01') - strtotime($a['created_at'] ?? '1970-01-01');
                });

                $newestGrades = array_slice($enrichedGrades, 0, 5);

                $subjectAverages = [];
                $subjectGradeCounts = [];

                foreach ($enrichedGrades as $grade) {
                    $subjectId = $grade['subject_id'];
                    $subjectName = $grade['subject_name'];

                    if (!isset($subjectAverages[$subjectId])) {
                        $subjectAverages[$subjectId] = [
                            'subject_name' => $subjectName,
                            'total' => 0,
                            'count' => 0,
                            'average' => 0
                        ];
                    }

                    $subjectAverages[$subjectId]['total'] += $grade['grade'];
                    $subjectAverages[$subjectId]['count']++;
                }

                foreach ($subjectAverages as &$subjectAvg) {
                    if ($subjectAvg['count'] > 0) {
                        $subjectAvg['average'] = $subjectAvg['total'] / $subjectAvg['count'];
                    }
                }
                unset($subjectAvg);

                view("dashboard/student", [
                    'allGrades' => $enrichedGrades,
                    'newestGrades' => $newestGrades,
                    'subjects' => $subjects,
                    'subjectAverages' => $subjectAverages
                ]);
                break;
        }
    }
}