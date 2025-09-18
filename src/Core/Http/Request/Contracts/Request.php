<?php

namespace EssentialMVC\Core\Http\Request\Contracts;

interface Request
{
  public function uri(): string;
  public function method(): string;
}
