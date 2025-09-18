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

  /** 
   * @param array<string,mixed> $server 
   */
  public function __construct(string $basePath, array $server)
  {
    $this->basePath = $basePath;
    $this->container = new ServiceContainer();
    AppFactory::create($this->container, $this->basePath, $server);
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

  public function run(): void
  {
    $this->kernel()->run();
  }

  /**
   * @template T
   * @param class-string<T> $id
   * @return T
   */
  public function get(string $id): mixed
  {
    return $this->container->get($id);
  }
}
