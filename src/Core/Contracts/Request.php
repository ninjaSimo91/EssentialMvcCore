<?php

namespace EssentialMVC\Core\Contracts;

interface Request
{
  public function uri(): string;
  public function method(): string;
}
