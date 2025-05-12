<?php

namespace core;

use JetBrains\PhpStorm\NoReturn;

class Request
{
    protected array $data;
    protected array $server;

    public function __construct($data, $server)
    {
        $this->data = $data;
        $this->server = $server;
    }
    
    /**
     * Get the client IP address.
     *
     * @return string The client IP address
     */
    public function ip(): string
    {
        return $this->server['REMOTE_ADDR'] ?? '127.0.0.1';
    }

    public function all(): array
    {
        return $this->data;
    }

    public function input($key)
    {
        return $this->data[$key] ?? null;
    }

    public function validate($data): void
    {
        Validator::set_data($this->data);
        $errors = [];
        foreach ($data as $key => $value) {
            try {
                $field = isset($this->data[$key]) ? $this->data[$key] : null;
                if (is_string($field)) {
                    $field = trim($field);
                }
            } catch (\Exception $e) {
                $field = null;
            }

            is_array($value) ?: $value = explode('|', $value);
            $rules = $value;

            foreach ($rules as $rule) {
                $rule = explode(':', $rule);
                $rule_name = $rule[0];
                $rule_value = $rule[1] ?? null;
                if (!empty($rule_value)) {
                    $rule_value = strpos($rule_value, ',') ? explode(',', $rule_value) : $rule_value;
                }
                try {
                    $result = Validator::$rule_name($field, $rule_value);
                } catch (\Exception $e) {
                    $result = $e->getMessage();
                }

                if ($result) {
                    $errors[$key] = "{$result}";
                }
            }
        }

        if (!empty($errors)) {
            Session::flash('errors', $errors);
            Session::flash('old', $this->data);
            redirect((new Router)->previousUrl());
        }
        return;
    }

    #[NoReturn] public function error($field, $error): void
    {
        $errors[$field] = $error;
        Session::flash('errors', $errors);
        Session::flash('old', $this->data);
        redirect((new Router)->previousUrl());
    }
}