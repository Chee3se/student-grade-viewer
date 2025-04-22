<?php

namespace core;

use Exception;
use Student;
use Teacher;

class Middleware
{
    public const MAP = [
        'student' => Student::class,
        'teacher' => Teacher::class,
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

        $middleware = static::MAP[$key] ?? false;

        if (!$middleware) {
            throw new Exception("No matching middleware found for key '{$key}'.");
        }

        (new $middleware)->handle();
    }
}
