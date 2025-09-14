<?php

namespace EssentialMVC\Core\Config;

use EssentialMVC\Core\Config\Exception\ConfigException;

class FileReader
{
    /**
     * @return array<string, string>
     * @throws ConfigException
     */
    public function read(string $filePath): array
    {
        if (!is_file($filePath) || !is_readable($filePath)) {
            throw new ConfigException("Cannot read config file: {$filePath}");
        }

        $data = include $filePath;

        if (!is_array($data)) {
            throw new ConfigException("Config file must return an array: {$filePath}");
        }

        return $data;
    }
}
