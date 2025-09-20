<?php

namespace EssentialMVC\Core\Router;

use EssentialMVC\Support\Config\Exception\ConfigException;
use EssentialMVC\Core\Contracts\FileReader;
use EssentialMVC\Facades\RouterFacade;

class RouterFileReader implements FileReader
{
    private RouterFacade $route;

    public function __construct(RouterFacade $route)
    {
        $this->route = $route;
    }

    /**
     * @return array<string, string>
     */
    public function read(string $filePath): array
    {
        $this->ensureFileExists($filePath);
        $this->ensureFileIsReadable($filePath);

        return $this->load($filePath);
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
    private function load(string $filePath): array
    {
        /** @var callable $data */
        $data = include $filePath;

        $result = $data($this->route);

        if (!is_array($result)) {
            throw new ConfigException("Config callable must return an array: {$filePath}");
        }

        /** @var array<string,string> $result */
        return $result;
    }
}
