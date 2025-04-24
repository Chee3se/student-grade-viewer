<?php

namespace core\Middleware;

class Teacher
{
    public function handle(): void
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'teacher') {
            redirect('/');
            die();
        }
    }
}