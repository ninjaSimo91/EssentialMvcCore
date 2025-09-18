<?php

declare(strict_types=1);

namespace EssentialMVC\Http\Request;

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
        dd('asd');
    }

    public function uri(): string
    {
        return $this->server['REQUEST_URI'] ?? '/';
    }

    public function method(): string
    {
        return $this->server['REQUEST_METHOD'] ?? 'GET';
    }
}
