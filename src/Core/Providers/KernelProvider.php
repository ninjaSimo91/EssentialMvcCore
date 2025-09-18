<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Providers;

use EssentialMVC\Core\Contracts\ServiceProvider;
use EssentialMVC\Core\Kernel;
use EssentialMVC\Core\ServiceContainer;
use EssentialMVC\Support\Config\ConfigLoaderByFiles;
use EssentialMVC\Support\Env\Env;

class KernelProvider implements ServiceProvider
{
  public function __construct() {}

  public function register(ServiceContainer $container): void
  {
    $container->setTransient('kernel', function (ServiceContainer $c): Kernel {
      /** @var Env $env */
      $env = $c->get('env');

      /** @var ConfigLoaderByFiles $config */
      $config = $c->get('config');

      return new Kernel($env, $config);
    });
  }
}
