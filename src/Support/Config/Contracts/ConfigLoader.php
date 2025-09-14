<?php

namespace EssentialMVC\Core\Contract;

interface ConfigLoader
{
  public function load(): void;
  
  /** 
   * @return array<string,array<string,string>> 
   */
  public function get(): array;
}
