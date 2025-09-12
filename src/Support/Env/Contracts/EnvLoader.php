<?php

namespace EssentialMVC\Support\Env\Contracts;

use EssentialMVC\Exception\EnvException;

interface EnvLoader
{
    /**
     * @throws EnvException
     */
    public function load(): void;
}
