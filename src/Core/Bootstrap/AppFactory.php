<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Bootstrap;

use EssentialMVC\Core\Kernel;
use EssentialMVC\Core\ServiceContainer;

class AppFactory
{
  public static function create(ServiceContainer $container, string $basePath): Kernel
  {
    $basePath = rtrim($basePath, '/');

    EnvFactory::set($container, $basePath);
    ConfigFactory::set($container, $basePath);
    KernelFactory::set($container);

    /** @var Kernel $kernel */
    $kernel = $container->get('kernel');
    return $kernel;
  }
}
