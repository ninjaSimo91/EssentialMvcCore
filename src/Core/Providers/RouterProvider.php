<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Providers;

use EssentialMVC\Core\Contracts\ServiceProvider;
use EssentialMVC\Core\Http\Request\RequestByHttpUrl;
use EssentialMVC\Core\Router\Router;
use EssentialMVC\Core\RouterLoaderByFiles;
use EssentialMVC\Core\ServiceContainer;

class RouterProvider implements ServiceProvider
{
  private string $basePath;

  public function __construct(string $basePath)
  {
    $this->basePath = $basePath;
  }

  public function register(ServiceContainer $container): void
  {
    $container->setShared('router', function (ServiceContainer $c): Router {

      /** @var string $routerPath */
      $routerPath = $this->basePath . DIRECTORY_SEPARATOR . 'routes';

      $routerLoader = new RouterLoaderByFiles($routerPath, new RouterFileReader());
      $routerLoader->load();



      /** @var RequestByHttpUrl $request */
      // $request = $c->get('request');
      // $request = $c->get('request');
      $router = new Router($request);

      return $router;
    });
  }
}
