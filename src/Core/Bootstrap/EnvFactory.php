<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Bootstrap;

use EssentialMVC\Core\ServiceContainer;
use EssentialMVC\Support\Env\Env;
use EssentialMVC\Support\Env\EnvLoaderByFile;

class EnvFactory
{
  public static function set(ServiceContainer $container, string $basePath): void
  {
    $container->setShared('env', function () use ($basePath): Env {
      $loader = new EnvLoaderByFile($basePath . DIRECTORY_SEPARATOR . '.env');
      return new Env($loader);
    });
  }
}
