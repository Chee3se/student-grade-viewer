<?php

use App\Controllers\GradeController;
use App\Controllers\PageController;
use App\Controllers\SessionController;
use App\Controllers\SubjectController;
use App\Controllers\UserController;

global $router;

$router->get('/', [PageController::class, 'index']);

// User shii

// Show all users
$router->get('/users', [UserController::class, 'index'])->only('teacher');
$router->get('/users/create', [UserController::class, 'create'])->only('teacher');
$router->post('/users', [UserController::class, 'store'])->only('teacher');
$router->get('/users/{id}/edit', [UserController::class, 'edit'])->only('teacher');
$router->put('/users/{id}', [UserController::class, 'update'])->only('teacher');
$router->delete('/users/{id}', [UserController::class, 'destroy'])->only('teacher');

// Profile page
$router->get('/profile', [UserController::class, 'show'])->only('auth');
$router->delete('/logout', [SessionController::class, 'destroy'])->only('auth');
$router->post('/user/image', [UserController::class, 'image'])->only('auth');
$router->post('/user/password', [UserController::class, 'password'])->only('auth');

$router->get('/login', [SessionController::class, 'create'])->only('guest');
$router->post('/login', [SessionController::class, 'store'])->only('guest')->rateLimit(5);

$router->get('/dashboard', [PageController::class, 'dashboard'])->only('auth');

// Subject shii
$router->get('/subjects', [SubjectController::class, 'index'])->only('teacher');
$router->get('/subject/create', [SubjectController::class, 'create'])->only('teacher');
$router->post('/subjects', [SubjectController::class, 'store'])->only('teacher');
$router->get('/subjects/{id}/edit', [SubjectController::class, 'edit'])->only('teacher');
$router->put('/subjects/{id}', [SubjectController::class, 'update'])->only('teacher');
$router->delete('/subjects/{id}', [SubjectController::class, 'destroy'])->only('teacher');

// Grade shii
$router->get('/grades', [GradeController::class, 'index'])->only('teacher');
$router->get('/grades/create', [GradeController::class, 'create'])->only('teacher');
$router->post('/grades', [GradeController::class, 'store'])->only('teacher');
$router->get('/grades/{id}/edit', [GradeController::class, 'edit'])->only('teacher');
$router->put('/grades/{id}', [GradeController::class, 'update'])->only('teacher');
$router->delete('/grades/{id}', [GradeController::class, 'destroy'])->only('teacher');
