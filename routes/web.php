<?php

use App\Controllers\PageController;
use App\Controllers\SessionController;
use App\Controllers\SubjectController;
use App\Controllers\UserController;

global $router;

$router->get('/', [PageController::class, 'index']);

// User shii

// Show all users
$router->get('/users', [UserController::class, 'index'])->only('teacher');
// Create a user
$router->post('/users', [UserController::class, 'store'])->only('teacher');

// Profile page
$router->get('/profile', [UserController::class, 'show'])->only('auth');
// Logout
$router->delete('/logout', [SessionController::class, 'destroy'])->only('auth');
// Update profile picture
$router->post('/user/image', [UserController::class, 'image'])->only('auth');
$router->post('/user/password', [UserController::class, 'password'])->only('auth');

// Login page
$router->get('/login', [SessionController::class, 'create'])->only('guest');
// Login logic
$router->post('/login', [SessionController::class, 'store'])->only('guest')->rateLimit(5);

// Dashboard page
$router->get('/dashboard', [PageController::class, 'dashboard'])->only('auth');


$router->get('/test', [SubjectController::class, 'index']);