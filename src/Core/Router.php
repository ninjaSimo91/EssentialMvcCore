<?php

declare(strict_types=1);

namespace EssentialMVC\Core;

use EssentialMVC\Core\Contracts\Request;

class Router
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        dd($this->request->uri());
        dd($this->request->method());
    }
}
