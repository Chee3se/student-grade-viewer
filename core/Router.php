<?php
namespace core;

use Exception;

class Router
{
    protected array $routes = [];
    /**
     * Add a route to the router.
     *
     * @param string $method
     * @param string $url
     * @param mixed $controller
     * @return Router
     */
    protected function add(string $method, string $url, mixed $controller): Router
    {
        $this->routes[] = [
            'method' => $method,
            'url' => $url,
            'controller' => $controller,
            'middleware' => null
        ];
        return $this;
    }
    /**
     * Define a GET route.
     *
     * @param string $url
     * @param mixed $controller
     * @return Router
     */
    public function get(string $url, mixed $controller): Router
    {
        return $this->add('GET', $url, $controller);
    }
    /**
     * Define a POST route.
     *
     * @param string $url
     * @param mixed $controller
     * @return Router
     */
    public function post(string $url, mixed $controller): Router
    {
        return $this->add('POST', $url, $controller);
    }
    /**
     * Define a PUT route.
     *
     * @param string $url
     * @param mixed $controller
     * @return Router
     */
    public function put(string $url, mixed $controller): Router
    {
        return $this->add('PUT', $url, $controller);
    }
    /**
     * Define a PATCH route.
     *
     * @param string $url
     * @param mixed $controller
     * @return Router
     */
    public function patch(string $url, mixed $controller): Router
    {
        return $this->add('PATCH', $url, $controller);
    }
    /**
     * Define a DELETE route.
     *
     * @param string $url
     * @param mixed $controller
     * @return Router
     */
    public function delete(string $url, mixed $controller): Router
    {
        return $this->add('DELETE', $url, $controller);
    }
    /**
     * Attach a middleware to the last added route.
     *
     * @param mixed $key
     * @return Router
     */
    public function only(mixed $key): Router
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;
        return $this;
    }
    
    /**
     * Apply rate limiting to the last added route.
     *
     * @param int $maxAttempts Maximum number of attempts allowed per minute
     * @return Router
     */
    public function rateLimit(int $maxAttempts = 60): Router
    {
        $lastIndex = array_key_last($this->routes);
        $this->routes[$lastIndex]['rate_limit'] = $maxAttempts;
        return $this;
    }
    /**
     * Dispatch the router and call the corresponding controller.
     *
     * @param mixed $uri
     * @param string $method
     * @return mixed
     * @throws Exception
     */
    public function route(mixed $uri, string $method): mixed
    {
        foreach ($this->routes as $route) {
            if ($route['method'] !== strtoupper($method)) {
                continue;
            }

            $pattern = str_replace('/', '\/', $route['url']);
            $pattern = preg_replace('#:([a-zA-Z0-9_]+)#', '(?<$1>[^/]+)', $pattern);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                $parameters = [];
                foreach ($matches as $key => $value) {
                    if (!is_int($key)) {
                        $parameters[$key] = $value;
                    }
                }

                Middleware::resolve($route['middleware'] ?? null);
                
                // Apply rate limiting if configured
                if (isset($route['rate_limit'])) {
                    (new \core\RateLimit())->handle($route['rate_limit']);
                }
                
                [$class, $method] = $route['controller'];
                $request = new Request($_POST + $_FILES + $_GET, $_SERVER);
                $instance = new $class();
                return $instance->$method($request,$parameters);
            }
        }
        $this->abort(404, 'Lapa netika atrasta');
        return null;
    }
    /**
     * Get the previous URL.
     *
     * @return string
     */
    public static function previousUrl(): string
    {
        return $_SERVER['HTTP_REFERER'] ?? '';
    }
    /**
     * Abort the request with a specific HTTP status code.
     *
     * @param int $code
     * @param string $message
     * @param string $description
     * @return void
     */
    public function abort(int $code = 404, string $message = 'Lapa netika atrasta', string $description = 'Lapa, ko cenšaties meklēt netika atrasta.'): void
    {
        http_response_code($code);
        view('error', [
            'code' => $code,
            'message' => $message,
            'description' => $description
        ]);
        exit;
    }
}
