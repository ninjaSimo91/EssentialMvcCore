<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Providers;

use EssentialMVC\Core\ServiceContainer;
use EssentialMVC\Support\Config\ConfigFileReader;
use EssentialMVC\Support\Config\ConfigLoaderByFiles;
use EssentialMVC\Core\Contracts\ServiceProvider;

class RouteProvider implements ServiceProvider
{

  private string $basePath;

  public function __construct()
  {
  }

  public function register(ServiceContainer $container): void
  {
    $container->setShared('route', function (ServiceContainer $c): Route {
      /** @var Route $route */
      $env = $c->get('route');
      $configPath = $this->basePath . DIRECTORY_SEPARATOR . 'config';

      $loader = new ConfigLoaderByFiles($configPath, new ConfigFileReader(), $env->getFacade());
      $loader->load();

      return $loader;
    });
  }
}
