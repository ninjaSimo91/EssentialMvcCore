<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Router\Contracts;

interface RouterLoader
{
    public function load(): void;
}
