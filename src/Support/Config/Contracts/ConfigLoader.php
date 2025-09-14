<?php

namespace EssentialMVC\Core\Contract;

interface ConfigLoader
{
  /**
   * @throws ConfigException
   */
  public function load(): void;
  public function get(): array;
}
