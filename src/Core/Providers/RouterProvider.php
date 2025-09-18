<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Providers;

use EssentialMVC\Core\Router;
use EssentialMVC\Core\Contracts\ServiceProvider;
use EssentialMVC\Core\Http\Request\RequestByHttpUrl;
use EssentialMVC\Core\ServiceContainer;

class RouterProvider implements ServiceProvider
{
  public function __construct() {}

  public function register(ServiceContainer $container): void
  {
    $container->setTransient('router', function (ServiceContainer $c): Router {

      /** @var RequestByHttpUrl $request */
      $request = $c->get('request');

      $router = new Router($request);

      return $router;
    });
  }
}
