<?php

use App\Controllers\PageController;

global $router;

$router->get('/', [PageController::class, 'index']);