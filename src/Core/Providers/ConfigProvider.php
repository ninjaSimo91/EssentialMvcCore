<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Providers;

use EssentialMVC\Core\ServiceContainer;
use EssentialMVC\Support\Config\ConfigFileReader;
use EssentialMVC\Support\Config\ConfigLoaderByFiles;
use EssentialMVC\Support\Env\Env;
use EssentialMVC\Core\Contracts\ServiceProvider;

class ConfigProvider implements ServiceProvider
{
  private string $basePath;

  public function __construct(string $basePath)
  {
    $this->basePath = $basePath;
  }

  public function register(ServiceContainer $container): void
  {
    $container->setShared('config', function (ServiceContainer $c): ConfigLoaderByFiles {
      /** @var Env $env */
      $env = $c->get('env');

      /** @var non-falsy-string $configPath */
      $configPath = $this->basePath . DIRECTORY_SEPARATOR . 'config';

      $configLoader = new ConfigLoaderByFiles($configPath, new ConfigFileReader($env->getFacade()));
      $configLoader->load();

      return $configLoader;
    });
  }
}
