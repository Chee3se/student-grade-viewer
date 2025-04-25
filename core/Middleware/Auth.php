<?php

namespace core\Middleware;

class Auth
{
    public function handle(): void
    {
        if (!isset($_SESSION['user'])) {
            redirect('/login');
            die();
        }
    }
}