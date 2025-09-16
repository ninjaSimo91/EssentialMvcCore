<?php

namespace EssentialMVC\Core\Bootstrap;

use EssentialMVC\Core\Kernel;
use EssentialMVC\Core\ServiceContainer;
use EssentialMVC\Support\Config\ConfigFileReader;
use EssentialMVC\Support\Config\ConfigLoaderByFiles;
use EssentialMVC\Support\Env\Env;
use EssentialMVC\Support\Env\EnvLoaderByFile;

class KernelFactory
{
  public static function create(string $basePath): Kernel
  {
    $basePath = rtrim($basePath, '/');

    $container = new ServiceContainer();

    // Env condiviso
    $container->setShared(
      'env',
      function () use ($basePath): Env {
        $loader = new EnvLoaderByFile($basePath . DIRECTORY_SEPARATOR . '.env');
        return new Env($loader);
      }
    );

    // Config Loader condiviso
    $container->setShared(
      'config',
      function () use ($basePath): ConfigLoaderByFiles {
        $configPath = $basePath . DIRECTORY_SEPARATOR . 'config';
        $loader = new ConfigLoaderByFiles($configPath, new ConfigFileReader());
        $loader->load();
        return $loader;
      }
    );

    // Kernel transiente
    $container->setTransient('kernel', function (ServiceContainer $c): Kernel {
      /** @var ConfigLoaderByFiles $config */
      $config = $c->get('config');
      /** @var Env $env */
      $env = $c->get('env');

      return new Kernel($env, $config);
    });

    /** @var Kernel $kernel */
    $kernel = $container->get('kernel');
    return $kernel;
  }
}
