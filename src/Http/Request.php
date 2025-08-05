<?php

namespace SWD\Core\Http;

class Request
{
    private string $path;
    private string $method;
    private array $post = [];

    public function __construct()
    {
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);

        $uri = $_SERVER['REQUEST_URI'];
        if (strpos($uri, "?")) {
            $uri = explode("?", $uri);
            $this->path = $uri[0];
            if ($this->method == "post") $this->post = $_POST;
        } else {
            $this->path = $uri;
        }
    }

    // public function getPost()
    // {
    //     return $_POST ?? [];
    // }

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
