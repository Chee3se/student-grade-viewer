<?php

use App\Controllers\PageController;
use App\Controllers\SessionController;
use App\Controllers\UserController;

global $router;

$router->get('/', [PageController::class, 'index']);

$router->get('/users', [UserController::class, 'index'])->only('teacher');
$router->get('/profile', [UserController::class, 'show']);
$router->post('/users', [UserController::class, 'store'])->only('teacher');

$router->get('/login', [SessionController::class, 'create']);

