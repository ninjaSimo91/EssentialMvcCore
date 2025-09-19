<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Providers;

use EssentialMVC\Core\Contracts\ServiceProvider;
use EssentialMVC\Core\Kernel;
use EssentialMVC\Core\Router\Router;
use EssentialMVC\Core\ServiceContainer;
use EssentialMVC\Support\Config\ConfigLoaderByFiles;

class KernelProvider implements ServiceProvider
{
  public function __construct() {}

  public function register(ServiceContainer $container): void
  {
    $container->setTransient('kernel', function (ServiceContainer $c): Kernel {
      /** @var ConfigLoaderByFiles $configLoader */
      $configLoader = $c->get('config');
      /** @var array <string,array<string,string>> $config */
      $config = $configLoader->get();

      /** @var Router $router */
      $router = $c->get('router');

      return new Kernel($config, $router);
    });
  }
}
