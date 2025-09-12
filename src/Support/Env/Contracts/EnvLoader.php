<?php

namespace EssentialMVC\Support\Env\Contracts;

use EssentialMVC\Support\Env\Exception\EnvException;

interface EnvLoader
{
    /**
     * @throws EnvException
     */
    public function load(): void;
}
