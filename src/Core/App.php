<?php

declare(strict_types=1);

namespace EssentialMVC\Core;

use EssentialMVC\Core\Bootstrap\AppFactory;
use EssentialMVC\Core\ServiceContainer;
use EssentialMVC\Core\Kernel;
use EssentialMVC\Support\Env\Env;
use EssentialMVC\Support\Config\ConfigLoaderByFiles;

class App
{
  private string $basePath;
  private ServiceContainer $container;

  public function __construct(string $basePath)
  {
    $this->basePath = $basePath;
    $this->container = new ServiceContainer();
    AppFactory::create($this->container, $this->basePath);
  }


  public function kernel(): Kernel
  {
    /** @var Kernel $kernel */
    $kernel = $this->container->get('kernel');
    return $kernel;
  }

  public function env(): Env
  {
    /** @var Env $env */
    $env = $this->container->get('env');
    return $env;
  }

  public function config(): ConfigLoaderByFiles
  {
    /** @var ConfigLoaderByFiles $config */
    $config = $this->container->get('config');
    return $config;
  }

  public function run(): void
  {
    $this->kernel()->run();
  }

  public function get(string $id): mixed
  {
    return $this->container->get($id);
  }
}
