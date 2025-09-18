<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Providers;

use EssentialMVC\Core\ServiceContainer;
use EssentialMVC\Core\Contracts\ServiceProvider;
use EssentialMVC\Http\Request\RequestByHttpUrl;

class RequestProvider implements ServiceProvider
{
  /** 
   * @var array<string,mixed> $server
   */
  private array $server;

  /** 
   * @param array<string,mixed> $server
   */
  public function __construct(array $server)
  {
    $this->$server = $server;
  }

  public function register(ServiceContainer $container): void
  {
    $container->setShared('request', function () {
      $request = new RequestByHttpUrl($this->server);
    });
  }
}
