<?php

namespace App\Controllers;

use App\Models\User;
use Core\Session;

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
        view("dashboard/{$role}");
    }
}