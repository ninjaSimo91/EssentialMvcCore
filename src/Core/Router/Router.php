<?php

declare(strict_types=1);

namespace EssentialMVC\Core;

use EssentialMVC\Core\Contracts\Request;
use EssentialMVC\Core\Exception\NotFoundException;

class Router
{
    private Request $request;

    /**
     * @var array<string, array<string, callable|array>> $routes
     */
    private array $routes;

    public function __construct(Request $request)
    {
        $this->request = $request;
        dd($this->request->uri());
    }

    // public function add(string $method, string $path, callable|array $handler): void
    // {
    //     $method = strtoupper($method);
    //     $this->routes[$method][$path] = $handler;
    // }

    // public function get(string $path, callable|array $handler): void
    // {
    //     $this->add('GET', $path, $handler);
    // }

    // public function post(string $path, callable|array $handler): void
    // {
    //     $this->add('POST', $path, $handler);
    // }

    public function resolve(): void
    {
        /** @var string $method */
        $method = $this->request->method();

        /** @var string $uri */
        $uri = $this->request->uri();

        // /** @var callable|array $handler */
        // $handler = $this->routes[$method][$uri];

        // if (empty($handler)) {
        //     throw new NotFoundException("Route [$method $uri] not found.");
        // }

        // if (empty($handler)) {
        //     $handler = $this->matchParameterized($method, $uri);
        // }

        // if (is_array($handler) && is_string($handler[0])) {
        //     $controller = new $handler[0]();
        //     $action = $handler[1];
        //     $controller->$action(...$this->extractParams($method, $uri));
        //     return;
        // }

        // // callable diretto
        // if (is_callable($handler)) {
        //     $handler(...$this->extractParams($method, $uri));
        // }
    }

    // private function matchParameterized(string $method, string $uri): callable|array|null
    // {
    //     foreach ($this->routes[$method] ?? [] as $route => $handler) {
    //         if (strpos($route, '{') !== false) {
    //             $pattern = preg_replace('#\{([\w]+)\}#', '([^/]+)', $route);
    //             $regex = "#^" . $pattern . "$#";

    //             if (preg_match($regex, $uri, $matches)) {
    //                 return $handler;
    //             }
    //         }
    //     }
    //     return null;
    // }

    /**
     * Estraggo i valori dai parametri della route
     */
    // private function extractParams(string $method, string $uri): array
    // {
    //     foreach ($this->routes[$method] ?? [] as $route => $handler) {
    //         if (strpos($route, '{') !== false) {
    //             $pattern = preg_replace('#\{([\w]+)\}#', '([^/]+)', $route);
    //             $regex = "#^" . $pattern . "$#";

    //             if (preg_match($regex, $uri, $matches)) {
    //                 array_shift($matches); // tolgo il match completo
    //                 return $matches;
    //             }
    //         }
    //     }
    //     return [];
    // }
}
