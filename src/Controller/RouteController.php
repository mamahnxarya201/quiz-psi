<?php
declare(strict_types=1);

namespace Controller;

use Exception;

class RouteController
{
    private $routes = [];

    public function add($method, $path, $callback)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'callback' => $callback,
        ];
        return $this;
    }

    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            $path = parse_url($uri, PHP_URL_PATH);
            if ($route['method'] === $method && preg_match("#^{$route['path']}$#", $path)) {
                if (is_callable($route['callback'])) {
                    call_user_func($route['callback']);
                } elseif (is_array($route['callback'])) {
                    [$controllerName, $methodName] = $route['callback'];
                    if (class_exists($controllerName) && method_exists($controllerName, $methodName)) {
                        $controller = new $controllerName();
                        $controller->$methodName();
                    } else {
                        throw new Exception("Controller or method not found.");
                    }
                } elseif (is_string($route['callback'])) {
                    $parts = explode('@', $route['callback']);
                    $controllerName = $parts[0];
                    $methodName = $parts[1];
                    if (class_exists($controllerName) && method_exists($controllerName, $methodName)) {
                        $controller = new $controllerName();
                        $controller->$methodName();
                    } else {
                        throw new Exception("Controller or method not found.");
                    }
                }
                return;
            }
        }

        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }
}
