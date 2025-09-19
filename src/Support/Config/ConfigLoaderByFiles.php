<?php

declare(strict_types=1);

namespace EssentialMVC\Support\Config;

use EssentialMVC\Support\Config\ConfigFileReader;
use EssentialMVC\Support\Config\Exception\ConfigException;
use EssentialMVC\Support\Contracts\Loader;

class ConfigLoaderByFiles implements Loader
{
    private string $configDir;
    private ConfigFileReader $fileReader;

    /** 
     * @var array<string,array<string,string>> $config
     */
    private array $config;

    public function __construct(string $configDir, ConfigFileReader $fileReader)
    {
        $this->configDir = $configDir;
        $this->fileReader = $fileReader;
    }

    public function load(): void
    {
        $this->checkExistDir();
        $this->scanConfigDirectory();
    }

    /**
     * @throws ConfigException
     */
    private function checkExistDir(): void
    {
        if (!is_dir($this->configDir)) {
            throw new ConfigException("Config path does not exist: {$this->configDir}");
        }
    }

    private function scanConfigDirectory(): void
    {
        $files = scandir($this->configDir);

        foreach ($files as $file) {
            if ($this->isNavigationDir($file)) {
                continue;
            }

            $path = $this->configDir . DIRECTORY_SEPARATOR . $file;
            $filename = pathinfo($file, PATHINFO_FILENAME);

            $data = $this->fileReader->read($path);
            $this->config[$filename] = $data;
        }
    }

    private function isNavigationDir(string $file): bool
    {
        return ($file === '.' || $file === '..');
    }

    /** 
     * @return array<string,array<string,string>> 
     */
    public function get(): array
    {
        return $this->config;
    }
}
