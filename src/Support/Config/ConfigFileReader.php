<?php

namespace EssentialMVC\Core\Config;

use EssentialMVC\Core\Exception\ConfigException;

class ConfigFileReader
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }
    /**
     * @return array<string, string>
     */
    public function read(): array
    {
        $this->ensureFileExists();
        $this->ensureFileIsReadable();

        return $this->ensureFileIsArrayAndLoad();
    }

    /**
     * @throws ConfigException
     */
    private function ensureFileExists(): void
    {
        if (!is_file($this->filePath)) {
            throw new ConfigException("Not is file: {$this->filePath}");
        }
    }

    /**
     * @throws ConfigException
     */
    private function ensureFileIsReadable(): void
    {
        if (!is_readable($this->filePath)) {
            throw new ConfigException("Cannot read config file: {$this->filePath}");
        }
    }

    /**
     * @return array<string,string>
     * @throws ConfigException
     */
    private function ensureFileIsArrayAndLoad(): array
    {
        /** @var mixed $data */
        $data = include $this->filePath;

        if (!is_array($data)) {
            throw new ConfigException("Config file must return an array: {$this->filePath}");
        }

        /** @var array<string,string> $data */
        return $data;
    }
}
