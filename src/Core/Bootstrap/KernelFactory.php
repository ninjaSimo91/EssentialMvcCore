<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Bootstrap;

use EssentialMVC\Core\Kernel;
use EssentialMVC\Core\ServiceContainer;
use EssentialMVC\Support\Config\ConfigLoaderByFiles;
use EssentialMVC\Support\Env\Env;

class KernelFactory
{
  public static function set(ServiceContainer $container): void
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
