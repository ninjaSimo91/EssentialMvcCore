<?php

namespace EssentialMVC\Core\Factory;

use EssentialMVC\Core\Kernel;
use EssentialMVC\Support\Env\Env;
use EssentialMVC\Support\Env\EnvLoaderByFile;

class KernelFactory
{

  public static function create(string $basePath): Kernel
  {
    $envLoader = new EnvLoaderByFile("{$basePath}/.env");
    $env = new Env($envLoader);

    return new Kernel(
      $basePath,
      $env,
      // $request,
      // $response,
      // $router,
      // $middleware
    );
  }
}
