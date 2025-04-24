<?php

namespace core\Middleware;

class Guest
{
    public function handle(): void
    {
        if (isset($_SESSION['user'])) {
            redirect('/');
            die();
        }
    }
}