<?php
declare(strict_types=1);

namespace EssentialMVC\Support\Env;

use EssentialMVC\Facades\EnvFacade;
use EssentialMVC\Support\Env\Contracts\EnvLoader;
use EssentialMVC\Support\Env\Exception\EnvException;

class Env
{
  private EnvLoader $loader;

  public function __construct(EnvLoader $loader)
  {
    $this->loader = $loader;
    $this->loader->load();
  }

  public function get(string $key, string $default = ''): string
  {
    $value = getenv($key);
    return ($value !== false)
      ? $value
      : $default;
  }

  /**
   * @throws EnvException
   */
  public function set(string $key, string $value): void
  {
    if (strpos($key, '=') !== false) {
      throw new EnvException("Invalid environment key: $key");
    }

    putenv("$key=$value");
  }

  public function getFacade(): EnvFacade {
        return new EnvFacade($this);
    }
}
