<?php

namespace EssentialMVC\Support;

class Env
{
    public static function addVarsByFile(string $envFileDir): void
    {
        try {
            $envVars = file($envFileDir);
            foreach ($envVars as $envVar) {
                if (!empty(trim($envVar))) putenv(trim($envVar));
            }
        } catch (InvalidFileException $e) {
            $this->writeErrorAndDie([
                'The environment file is invalid!',
                $e->getMessage(),
            ]);
        }
    }

    public static function add(string $key, string $value = null): void
    {
        putenv("{trim($key)}={trim($value)}");
    }

    public static function get(string $key, string $default = null): ?string
    {
        if (getenv($key)) return getenv($key);
        return $default;
    }
}
