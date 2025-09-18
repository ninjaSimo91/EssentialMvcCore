<?php

namespace EssentialMVC\Core\Contracts;

use EssentialMVC\Core\ServiceContainer;

interface ServiceProvider
{
  public function register(ServiceContainer $container): void;
}
