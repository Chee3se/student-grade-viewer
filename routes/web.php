<?php

use App\Controllers\PageController;
use App\Controllers\SessionController;
use App\Controllers\UserController;

global $router;

$router->get('/', [PageController::class, 'index']);

// User shii
$router->get('/users', [UserController::class, 'index'])->only('teacher');
$router->post('/users', [UserController::class, 'store'])->only('teacher');

$router->get('/profile', [UserController::class, 'show'])->only('auth');
$router->delete('/logout', [SessionController::class, 'destroy'])->only('auth');
$router->post('/user/image', [UserController::class, 'image'])->only('auth');

$router->get('/login', [SessionController::class, 'create'])->only('guest');
$router->post('/login', [SessionController::class, 'store'])->only('guest')->rateLimit(5);

// Da rest
$router->get('/dashboard', [PageController::class, 'dashboard'])->only('auth');