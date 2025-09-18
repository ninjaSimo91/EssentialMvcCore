<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Http\Request;

use EssentialMVC\Core\Contracts\Request;

class RequestByHttpUrl implements Request
{
    /**
     * @var array<string,mixed> $server
     */
    private array $server;

    /**
     * @param array<string,mixed> $server
     */
    public function __construct(array $server)
    {
        $this->server = $server;
    }

    public function uri(): string
    {
        /** @var string $uri */
        $uri = $this->server['REQUEST_URI'] ?? '/';
        /** @var string $parsed */
        $parsed = parse_url($uri, PHP_URL_PATH) ?? '/';

        return $parsed;
    }

    public function method(): string
    {
        /** @var string $method */
        $method = $this->server['REQUEST_METHOD'] ?? 'GET';
        return strtoupper($method);
    }
}
