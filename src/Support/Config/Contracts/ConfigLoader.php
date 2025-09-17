<?php
declare(strict_types=1);

namespace EssentialMVC\Support\Config\Contracts;

interface ConfigLoader
{
  public function load(): void;
  
  /** 
   * @return array<string,array<string,string>> 
   */
  public function get(): array;
}
