<?php

use core\Session;
use JetBrains\PhpStorm\NoReturn;

#[NoReturn] function dd($value): void
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

#[NoReturn] function abort($code = 404): void
{
    http_response_code($code);
    require base_path("views/{$code}.php");

    die();
}

function base_path($path): string
{
    return BASE_PATH . $path;
}

function view($path, $attributes = [])
{
    ob_start();
    extract($attributes);
    include base_path('views/' . $path . '.view.php');
    return ob_end_flush();
}

function redirect($path): void
{
    header("location: {$path}");
    exit();
}

function component($component, $attributes = []): void
{
    extract($attributes);
    require base_path('views/components/' . $component . '.php');
}

function session(string $key, string $value)
{
    return $_SESSION[$key][$value];
}

function auth(): array
{
    return $_SESSION['user'];
}

function old($key): string
{
    return Session::get('old')[$key] ?? '';
}

function error($key): string
{
    $errors = Session::get('errors');
    if ($errors) {
        if (array_key_exists($key, $errors)) {
            return "<p class='text-red-500 font-light text-sm pb-1' >{$errors[$key]}</p>";
        }
    }
    return '';
}

function hash_make($password): string
{
    return password_hash($password, PASSWORD_DEFAULT);
}

function hash_check($one, $two): bool
{
    if (password_verify($one, $two)) {
        return true;
    } else if ($one === $two) {
        return true;
    } else {
        return false;
    }
}

function request(string $field)
{
    if (isset($_FILES[$field])) {
        return $_FILES[$field];
    } else if (isset($_POST[$field])) {
        return $_POST[$field];
    } else if (isset($_GET[$field])) {
        return $_GET[$field];
    } else {
        return '';
    }
}
