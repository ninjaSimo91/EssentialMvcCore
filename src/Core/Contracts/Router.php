<?php

namespace EssentialMVC\Core\Contracts;

interface Router
{
  public function resolve(): array;
}
