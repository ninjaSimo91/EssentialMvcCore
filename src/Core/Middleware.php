<?php

namespace EssentialMVC;

use EssentialMVC\App;

class Middleware
{
    public App $app;
    public array $queueRoute = [];

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function register(string $route, array $middlewares): void
    {
        if (!empty($middlewares)) {
            if (!isset($this->queueRoute[$route])) $this->queueRoute[$route] = [];
            foreach ($middlewares as $middleware) {
                if (!in_array($middleware, $this->queueRoute[$route])) array_push($this->queueRoute[$route], $middleware);
            }
        }
    }

    public function execute(array $middlewares): void
    {
        foreach ($middlewares as $middleware) {
            $this->executeMiddleware($this->app->config['middlewares'][$middleware]);
        }
    }

    private function executeMiddleware(string $middleware): void
    {
        (new $middleware)->exec($this->app);
    }
}
