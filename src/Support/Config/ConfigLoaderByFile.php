<?php

namespace EssentialMVC\Core;

use EssentialMVC\Core\Config\ConfigFileReader;
use EssentialMVC\Core\Contract\ConfigLoader;
use EssentialMVC\Core\Exception\ConfigException;

class ConfigLoaderByFiles implements ConfigLoader
{
  private string $configDir;
  private ConfigFileReader $fileReader;

  /** 
   * @var array<string,array<string,string>>
   */
  private array $config = [];

  public function __construct(string $configDir, ConfigFileReader $fileReader)
  {
    $this->configDir = $configDir;
    $this->fileReader = $fileReader;
  }

  public function load(): void
  {
    $this->checkExistConfigDir();
    $this->scanConfigDirectory();
  }

  /**
   * @throws ConfigException
   */
  private function checkExistConfigDir(): void
  {
    if (!is_dir($this->configDir)) {
      throw new ConfigException("Config path does not exist: {$this->configDir}");
    }
  }

  private function scanConfigDirectory(): void
  {
    $files = scandir($this->configDir);

    foreach ($files as $file) {
      if ($this->isNavigationDir($file)) {
        continue;
      }

      $path = $this->configDir . DIRECTORY_SEPARATOR . $file;
      $filename = pathinfo($file, PATHINFO_FILENAME);

      $data = $this->fileReader->read($path);
      $this->config[$filename] = $data;
    }
  }

  private function isNavigationDir(string $file): bool
  {
    return ($file === '.' || $file === '..');
  }


  // private function getFiles(array $f)

  /** 
   * @return array<string,array<string,string>> 
   */
  public function get(): array
  {
    return $this->config;
  }
}
