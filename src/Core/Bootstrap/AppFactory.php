<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Bootstrap;

use EssentialMVC\Core\ServiceContainer;
use EssentialMVC\Core\Providers\EnvProvider;
use EssentialMVC\Core\Providers\ConfigProvider;
use EssentialMVC\Core\Providers\KernelProvider;
use EssentialMVC\Core\Providers\RequestProvider;
use EssentialMVC\Core\Providers\RouterProvider;

class AppFactory
{
  /**
   * @param array<string,mixed> $server
   */
  public static function create(ServiceContainer $container, string $basePath, array $server): void
  {
    $providers = [
      new EnvProvider($basePath),
      new ConfigProvider($basePath),
      new RequestProvider($server),
      new RouterProvider($basePath),
      new KernelProvider()
    ];

    foreach ($providers as $provider) {
      $provider->register($container);
    }
  }
}
