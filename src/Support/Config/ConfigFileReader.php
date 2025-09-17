<?php
declare(strict_types=1);

namespace EssentialMVC\Support\Config;

use EssentialMVC\Support\Config\Exception\ConfigException;
use EssentialMVC\Support\Env\Env;

class ConfigFileReader
{

    public function __construct() {}

    /**
     * @return array<string, string>
     */
    public function read(string $filePath, Env $env): array
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
     * @throws ConfigException
     */
    private function ensureFileIsArrayAndLoad(string $filePath, Env $env): array
    {
        /** @var mixed $data */
        $data = include $filePath;

        if (!is_array($data)) {
            throw new ConfigException("Config file must return an array: {$filePath}");
        }

        /** @var array<string,string> $data */
        return $data;
    }
}
