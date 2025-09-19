<?php

namespace EssentialMVC\Support\Config;

use EssentialMVC\Facades\EnvFacade;
use EssentialMVC\Support\Config\Exception\ConfigException;
use EssentialMVC\Core\Contracts\FileReader;

class ConfigFileReader implements FileReader
{
    private EnvFacade $env;

    public function __construct(EnvFacade $env)
    {
        $this->env = $env;
    }

    /**
     * @return array<string, string>
     */
    public function read(string $filePath): array
    {
        $this->ensureFileExists($filePath);
        $this->ensureFileIsReadable($filePath);

        return $this->ensureFileIsArrayAndLoad($filePath);
    }

    /**
     * @throws ConfigException
     */
    private function ensureFileExists(string $filePath): void
    {
        if (!is_file($filePath)) {
            throw new ConfigException("Not is file: {$filePath}");
        }
    }

    /**
     * @throws ConfigException
     */
    private function ensureFileIsReadable(string $filePath): void
    {
        if (!is_readable($filePath)) {
            throw new ConfigException("Cannot read config file: {$filePath}");
        }
    }

    /**
     * @return array<string,string>
     */
    private function ensureFileIsArrayAndLoad(string $filePath): array
    {
        /** @var callable $data */
        $data = include $filePath;

        $result = $data($this->env);

        if (!is_array($result)) {
            throw new ConfigException("Config callable must return an array: {$filePath}");
        }

        /** @var array<string,string> $result */
        return $result;
    }
}
