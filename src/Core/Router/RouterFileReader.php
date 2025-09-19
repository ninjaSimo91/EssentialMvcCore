<?php

namespace EssentialMVC\Core\Router;

use EssentialMVC\Support\Config\Exception\ConfigException;
use EssentialMVC\Core\Contracts\FileReader;

class RouterFileReader implements FileReader
{
    public function __construct() {}

    /**
     * @return array<string, string>
     */
    public function read(string $filePath): array
    {
        // $this->ensureFileExists($filePath);
        // $this->ensureFileIsReadable($filePath);

        // return $this->ensureFileIsArrayAndLoad($filePath);
    }

    /**
     * @throws ConfigException
     */
    public function ensureFileExists(string $filePath): void
    {
        if (!is_file($filePath)) {
            throw new ConfigException("Not is file: {$filePath}");
        }
    }

    /**
     * @throws ConfigException
     */
    public function ensureFileIsReadable(string $filePath): void
    {
        if (!is_readable($filePath)) {
            throw new ConfigException("Cannot read config file: {$filePath}");
        }
    }

    // /**
    //  * @return array<string,string>
    //  */
    // private function ensureFileIsArrayAndLoad(string $filePath): array
    // {
    //     /** @var callable $data */
    //     $data = include $filePath;

    //     $result = $data($this->env);

    //     if (!is_array($result)) {
    //         throw new ConfigException("Config callable must return an array: {$filePath}");
    //     }

    //     /** @var array<string,string> $result */
    //     return $result;
    // }
}
