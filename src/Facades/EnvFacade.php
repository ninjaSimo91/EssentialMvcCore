<?php

declare(strict_types=1);

namespace EssentialMVC\Facades;

use EssentialMVC\Support\Env\Env;

class EnvFacade
{
  private Env $env;

  public function __construct(Env $env)
  {
    $this->env = $env;
  }

  public function get(string $key, string $default = ''): string
  {
    return $this->env->get($key, $default);
  }
}
