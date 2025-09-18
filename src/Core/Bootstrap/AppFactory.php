<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Bootstrap;

use EssentialMVC\Core\ServiceContainer;
use EssentialMVC\Core\Providers\EnvProvider;
use EssentialMVC\Core\Providers\ConfigProvider;
use EssentialMVC\Core\Providers\KernelProvider;
use EssentialMVC\Core\Providers\RequestProvider;

class AppFactory
{
  /**
   * @param array<string,mixed> $server
   */
  public static function create(ServiceContainer $container, string $basePath, array $server): ServiceContainer
  {
    dd('ciao');
    $providers = [
      new EnvProvider($basePath),
      new ConfigProvider($basePath),
      new RequestProvider($server),
      new KernelProvider()
    ];

    foreach ($providers as $provider) {
      $provider->register($container);
    }

    return $container;
  }
}
