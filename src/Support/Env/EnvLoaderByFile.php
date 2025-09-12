<?php

namespace EssentialMVC\Support\Env;

use EssentialMVC\Env\Contracts\EnvLoader;
use EssentialMVC\Env\Exception\EnvException;

class EnvLoaderByFile implements EnvLoader
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function load(): void
    {
        $this->validateFilePath();
        $this->putEnvVars();
    }

    /**
     * @throws EnvException
     */
    private function validateFilePath(): void
    {
        if (!file_exists($this->filePath)) {
            throw new EnvException("File not found: {$this->filePath}");
        }

        if (!is_readable($this->filePath)) {
            throw new EnvException("File not readable: {$this->filePath}");
        }
    }

    /**
     * @return string[]
     * @throws EnvException
     */
    private function getEnvVars(): array
    {
        $envVars = file($this->filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($envVars === false) {
            throw new EnvException("Unable to read env file: {$this->filePath}");
        }

        return $envVars;
    }

    /**
     * @throws EnvException
     */
    private function putEnvVars(): void
    {
        /** @var string[] $envVars */
        $envVars = $this->getEnvVars();

        foreach ($envVars as $envVar) {
            if ($this->isMalformedEnvLine($envVar)) {
                throw new EnvException("Malformed env line: $envVar");
            }
            putenv($envVar);
        }
    }

    private function isMalformedEnvLine(string $envVar): bool
    {
        return strpos($envVar, '=') === false;
    }
}
