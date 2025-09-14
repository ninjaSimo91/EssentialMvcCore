<?php

namespace EssentialMVC\Core\Bootstrap;

use EssentialMVC\Core\Config\ConfigFileReader;
use EssentialMVC\Core\ConfigLoaderByFiles;
use EssentialMVC\Core\Contract\ConfigLoader;
use EssentialMVC\Core\Kernel;

class KernelFactory
{

  public static function create(string $basePath): Kernel
  {
    $basePath = rtrim($basePath, '/');
    $config = self::createConfigLoader($basePath);

    return new Kernel(
      // $basePath,
      $config,
      // $request,
      // $response,
      // $router,
      // $middleware
    );
  }
  private static function createConfigLoader(string $basePath): ConfigLoader
  {
    $configPath = $basePath . DIRECTORY_SEPARATOR . "config";
    $configFileReader = new ConfigFileReader();

    $config = new ConfigLoaderByFiles($configPath, $configFileReader);
    $config->load();

    return $config;
  }
}
