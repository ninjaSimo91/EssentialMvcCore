<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Bootstrap;

use EssentialMVC\Core\ServiceContainer;
use EssentialMVC\Core\Providers\EnvProvider;
use EssentialMVC\Core\Providers\ConfigProvider;
use EssentialMVC\Core\Providers\KernelProvider;

class AppFactory
{
  public static function create(ServiceContainer $container, string $basePath): ServiceContainer
  {
    $providers = [
      new EnvProvider($basePath),
      new ConfigProvider($basePath),
      new KernelProvider()
    ];

    foreach ($providers as $provider) {
      $provider->register($container);
    }

    return $container;
  }
}
