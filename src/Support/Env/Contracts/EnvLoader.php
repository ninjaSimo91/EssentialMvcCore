<?php
declare(strict_types=1);

namespace EssentialMVC\Support\Env\Contracts;

use EssentialMVC\Support\Env\Exception\EnvException;

interface EnvLoader
{
    /**
     * @throws EnvException
     */
    public function load(): void;
}
