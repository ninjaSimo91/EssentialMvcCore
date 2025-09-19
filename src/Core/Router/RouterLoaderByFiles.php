<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Router;

use EssentialMVC\Support\Contracts\Loader;
use EssentialMVC\Support\Router\Exception\RouteException;

class RouterLoaderByFiles implements Loader
{
    private RouterFileReader $fileReader;

    /** 
     * @var array <string,string> $gateRoutes 
     */
    private array $gateRoutes;

    // /** 
    //  * @var array <array<string,string> $routes 
    //  */
    // private array $routes;

    /** 
     * @param array <string,string> $gateRoutes 
     */
    public function __construct(array $gateRoutes, RouterFileReader $fileReader)
    {
        $this->gateRoutes = $gateRoutes;
        $this->fileReader = $fileReader;
    }

    public function load(): void
    {
        foreach ($this->gateRoutes as $gateDir) {
            $this->checkExistDir($gateDir);
            $this->scanConfigDirectory($gateDir);
        }
    }

    /**
     * @throws RouteException
     */
    private function checkExistDir(string $gateDir): void
    {
        if (!is_dir($gateDir)) {
            throw new RouteException("Route path does not exist: {$gateDir}");
        }
    }

    private function scanConfigDirectory(string $gateDir): void
    {
        $files = scandir($gateDir);

        foreach ($files as $file) {
            if ($this->isNavigationDir($file)) {
                continue;
            }

            $path = $this->routeDir . DIRECTORY_SEPARATOR . $file;
            $filename = pathinfo($file, PATHINFO_FILENAME);

            // $data = $this->fileReader->read($path);
            // $this->routes[$filename] = $data;
        }
    }

    private function isNavigationDir(string $file): bool
    {
        return ($file === '.' || $file === '..');
    }
}
