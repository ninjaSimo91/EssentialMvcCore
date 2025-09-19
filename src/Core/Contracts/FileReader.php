<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Contracts;

interface FileReader
{
  /**
   * @return array<string, string>
   */
  public function read(string $filePath): array;
}
