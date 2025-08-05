<?php

namespace SWD\Core;

use SWD\Core\App;
use SWD\Core\Exception\NotFoundException;

class Router
{
    public App $app;
    public array $routes = [];


    public function __construct(App $app)
    {
        $this->app = $app;
    }


    public function group(\Closure $callback): array
    {
        return $callback($this);
    }

    public function get(string $route, array $controller, array $middlewares = [], string $name = ""): void
    {
        $this->addRoute($route, $controller, $middlewares, $name, 'get');
    }

    public function post(string $route, array $controller, array $middlewares = [], string $name = ""): void
    {
        $this->addRoute($route, $controller, $middlewares, $name, 'post');
    }

    private function addRoute(string $route, array $controller, array $middlewares = [], string $name = "", string $method): void
    {
        if (!isset($this->routes[$method])) $this->routes[$method] = [];
        if (!isset($this->routes[$method][$route])) {
            $this->routes[$method][$route] = $controller;
            $this->routes[$method][$route]['alias'] = $name;
            $this->app->middleware->register($route, $middlewares);
        }
    }

    public function resolve(): void
    {
        $response = $this->getRoute();
        if (empty($response)) throw new NotFoundException();
        $this->dispatch($response);
    }

    public function dispatch($response): void
    {
        $controller = $response[0];
        $action = $response[1];
        $attributes = $response['attributes'] ?? [];
        $instance = new $controller($this->app);
        $this->app->middleware->execute();
        call_user_func_array([$instance, $action], $attributes);
    }

    public function getRoute(): array
    {
        
        $method = $this->app->request->getRequestMethod();
        $path = $this->app->request->getRequestPath();
        if ($method == 'post') $post = $this->app->request->getRequestAttributes();

        return $this->app->config['routes'][$method][$path] ?? $this->parseRoute($this->app->config['routes'][$method], $path);
    }

    private function parseRoute($routes, $path)
    {
        $path = explode("/", $path);
        foreach ($routes as $route => $attributes) {
            if (strpos($route, "{")) {
                $attributes = $this->compareRoute($path, $route);
                if (!empty($attributes)) {
                    $routes[$route]['attributes'] = $attributes;
                    return $routes[$route];
                }
            }
        }
        return [];
    }

    private function compareRoute(array $path, string $route): array
    {
        $attributes = [];

        $route = explode("/", $route);
        $countPath = count($path);
        if ($countPath != count($route)) {
            return [];
        } else {
            for ($i = 0; $i < $countPath; $i++) {
                if (strpos($route[$i], "{") && $path[$i] != $route[$i]) {
                    return [];
                } else if ($path[$i] != $route[$i]) {
                    array_push($attributes, $path[$i]);
                }
            }
        }
        return $attributes;
    }
}
