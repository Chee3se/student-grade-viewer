<?php

namespace core;

use Exception;
use core\Middleware\Auth;
use core\Middleware\Guest;
use core\Middleware\Student;
use core\Middleware\Teacher;

class Middleware
{
    public const MAP = [
        'student' => Student::class,
        'teacher' => Teacher::class,
        'guest' => Guest::class,
        'auth' => Auth::class,
    ];

    /**
     * @param mixed $key
     * @return void
     * @throws Exception
     */
    public static function resolve(mixed $key): void
    {
        if (!$key) {
            return;
        }

        $key = strtolower($key);
        $middleware = static::MAP[$key] ?? false;

        if (!$middleware) {
            throw new Exception("No matching middleware found for key '{$key}'.");
        }

        (new $middleware)->handle();
    }
}
