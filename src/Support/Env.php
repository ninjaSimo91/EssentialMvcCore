<?php

namespace EssentialMVC\Support;

use Exception;

class Env
{

    public function __construct(string $envFileDir)
    {
        $this->loadEnvFile($envFileDir);
    }

    private function loadEnvFile(string $envFileDir): void
    {
        try {
            $this->putEnvVars($envFileDir);
        } catch (Exception $e) {
            $this->logError($e->getMessage());
        }
    }

    private function putEnvVars(string $envFileDir): void
    {
        $this->fileExist($envFileDir);
        $this->fileIsReadable($envFileDir);

        /** @var string[]|false*/
        $envVars = $this->getEnvVarsByFileDir($envFileDir);
        foreach ($envVars as $envVar) {
            putenv($envVar);
        }
    }

    private function fileExist(string $envFileDir): void
    {
        if (!file_exists($envFileDir)) {
            throw new \Exception("File not found: $envFileDir");
        }
    }

    private function fileIsReadable(string $envFileDir): void
    {
        if (!is_readable($envFileDir)) {
            throw new \Exception("File not readable: $envFileDir");
        }
    }

    /** @return string[] */
    private function getEnvVarsByFileDir(string $envFileDir): array
    {
        /** @var string[]|false*/
        $envVars = file($envFileDir, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($envVars === false) {
            throw new \Exception("Unable to read env file: $envFileDir");
        } else {
            return $envVars;
        }
    }

    private function logError(string $e): void
    {
        echo $e;
    }

    public function get(string $key, string $default = ''): string
    {
        $value = getenv($key);

        return ($value !== false)
            ? $value
            : $default;
    }
}
