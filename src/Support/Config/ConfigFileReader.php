<?php

namespace EssentialMVC\Support\Config;

use EssentialMVC\Facades\EnvFacade;
use EssentialMVC\Support\Config\Exception\ConfigException;

class ConfigFileReader
{

    public function __construct() {}

    /**
     * @return array<string, string>
     */
    public function read(string $filePath, EnvFacade $env): array
    {
        $this->ensureFileExists($filePath);
        $this->ensureFileIsReadable($filePath);

        return $this->ensureFileIsArrayAndLoad($filePath, $env);
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
    private function ensureFileIsArrayAndLoad(string $filePath, EnvFacade $env): array
    {
        /** @var callable $data */
        $data = include $filePath;

        $result = $data($env);

        if (!is_array($result)) {
            throw new ConfigException("Config callable must return an array: {$filePath}");
        }

        /** @var array<string,string> $result */
        return $result;
    }
}
