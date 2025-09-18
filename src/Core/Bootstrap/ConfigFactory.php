<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Bootstrap;

use EssentialMVC\Core\ServiceContainer;
use EssentialMVC\Support\Config\ConfigFileReader;
use EssentialMVC\Support\Config\ConfigLoaderByFiles;
use EssentialMVC\Support\Env\Env;

class ConfigFactory
{
  public static function set(ServiceContainer $container, string $basePath): void
  {
    $container->setShared('config', function (ServiceContainer $c) use ($basePath): ConfigLoaderByFiles {
      /** @var Env $env */
      $env = $c->get('env');
      $configPath = $basePath . DIRECTORY_SEPARATOR . 'config';
      $loader = new ConfigLoaderByFiles($configPath, new ConfigFileReader(), $env->getFacade());
      $loader->load();
      return $loader;
    });
  }
}
