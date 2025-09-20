<?php

declare(strict_types=1);

namespace EssentialMVC\Facades;

use EssentialMVC\Core\Router\Router;

class RouterFacade
{
  private Router $router;

  public function __construct(Router $router)
  {
    $this->router = $router;
  }

}
