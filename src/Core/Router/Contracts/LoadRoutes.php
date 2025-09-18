<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Router\Contracts;

interface LoadRoutes
{
    public function load(): void;
}
