<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Providers;

use EssentialMVC\Core\Contracts\ServiceProvider;
use EssentialMVC\Core\ServiceContainer;
use EssentialMVC\Support\Env\Env;
use EssentialMVC\Support\Env\EnvLoaderByFile;

class EnvProvider implements ServiceProvider
{
    private string $basePath;

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    public function register(ServiceContainer $container): void
    {
        $container->setShared('env', function () {
            $loader = new EnvLoaderByFile($this->basePath . DIRECTORY_SEPARATOR . '.env');
            return new Env($loader);
        });
    }
}
