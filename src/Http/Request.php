<?php

namespace EssentialMVC\Http;

use EssentialMVC\App;

class Request
{
    private App $app;
    private string $path;
    private string $method;
    private array $post = [];

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->method = $this->getMethod();
        $this->path = $this->getPath();

        if ($this->method == "post") $this->post = $_POST;
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getPath(): string
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $basePath = rtrim(parse_url($this->app->config['app']['APP_ROOT'], PHP_URL_PATH), '/');
        $path = explode('?', $requestUri)[0];

        if (str_starts_with($path, $basePath)) $path = substr($path, strlen($basePath));
        return $path === '' ? '/' : $path;
    }

    public function getPost()
    {
        return $_POST ?? [];
    }

    public function getRequestPath(): string
    {
        return $this->path;
    }

    public function getRequestMethod(): string
    {
        return $this->method;
    }

    public function getRequestAttributes(): array
    {
        return $this->post;
    }
}
