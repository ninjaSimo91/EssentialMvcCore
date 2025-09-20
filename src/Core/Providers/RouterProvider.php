<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Providers;

use EssentialMVC\Core\Contracts\ServiceProvider;
use EssentialMVC\Core\Router\Router;
use EssentialMVC\Core\Router\RouterFileReader;
use EssentialMVC\Core\Router\RouterLoaderByFiles;
use EssentialMVC\Core\ServiceContainer;
use EssentialMVC\Support\Config\ConfigLoaderByFiles;
use EssentialMVC\Core\Router\Exception\RouteException;

class RouterProvider implements ServiceProvider
{
  private string $basePath;

  public function __construct(string $basePath)
  {
    $this->basePath = $basePath;
  }

  public function register(ServiceContainer $container): void
  {
    $container->setShared('router', function (ServiceContainer $c): RouterLoaderByFiles {

      /** @var Router $router */
       $router = new Router();

      /** @var ConfigLoaderByFiles $configLoader */
      $configLoader = $c->get('config');
      /** @var array <string,array<string,string>> $config */
      $config = $configLoader->get();

      $this->ensureConfigRoutes($config);
      /** @var array <string,string> $gateRoutes */
      $gateRoutes = $config['routes'];

      $routerLoader = new RouterLoaderByFiles($this->basePath, $gateRoutes, new RouterFileReader($router->getFacade()));
      $routerLoader->load();



      // $request = $c->get('request');
      // $router = new Router($request);

      return $routerLoader;
    });
  }

  /** 
   * @param array <string,array<string,string>> $config 
   * @throws RouteException
   */
  private function ensureConfigRoutes($config): void
  {
    if (!isset($config['routes'])) {
      throw new RouteException("Route config does not exist");
    }
  }
}
