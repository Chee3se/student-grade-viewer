<?php

namespace App\Controllers;

use App\Models\User;

class PageController
{
    public function index(): void
    {
        //$users = User::all()->getAll();
        view('index');
    }
}