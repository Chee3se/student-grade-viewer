<?php

namespace core;

class RateLimit
{
    /**
     * Handle rate limiting for a route.
     *
     * @param int $maxAttempts Maximum number of requests allowed per minute
     * @param int $decayMinutes Time in minutes to track attempts for
     * @return void
     */
    public function handle(int $maxAttempts = 60, int $decayMinutes = 1): void
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $uri = $_SERVER['REQUEST_URI'];
        $key = "rate_limit_" . md5($ip . $uri);

        $attempts = Session::get($key, []);

        $now = time();
        $attempts = array_filter($attempts, function ($timestamp) use ($now, $decayMinutes) {
            return $timestamp > ($now - ($decayMinutes * 60));
        });

        if (count($attempts) >= $maxAttempts) {
            header('HTTP/1.1 429 Too Many Requests');
            header('Retry-After: ' . $decayMinutes * 60);

            Session::flash('error', 'Too many requests. Please try again in ' . $decayMinutes . ' minute(s).');

            view('error', [
                'code' => 429,
                'message' => 'Rate Limit Exceeded',
                'description' => 'Too many requests. Please try again in ' . $decayMinutes . ' minute(s).'
            ]);
            exit;
        }

        $attempts[] = $now;
        Session::put($key, $attempts);
    }
}
