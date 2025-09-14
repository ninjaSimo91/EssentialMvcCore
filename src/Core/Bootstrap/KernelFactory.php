<?php

namespace EssentialMVC\Core\Bootstrap;

use EssentialMVC\Core\Kernel;

class KernelFactory
{

  public static function create(string $basePath): Kernel
  {
    return new Kernel(
      $basePath,
      // $request,
      // $response,
      // $router,
      // $middleware
    );
  }
}
