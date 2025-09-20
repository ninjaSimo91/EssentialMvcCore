<?php

declare(strict_types=1);

namespace EssentialMVC\Core\Router;

use EssentialMVC\Support\Contracts\Loader;

class RouterLoaderByFiles implements Loader
{
    private string $basePath;
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
    public function __construct(string $basePath, array $gateRoutes, RouterFileReader $fileReader)
    {
        $this->basePath = $basePath;
        $this->gateRoutes = $gateRoutes;
        $this->fileReader = $fileReader;
    }

    public function load(): void
    {
        foreach ($this->gateRoutes as $gateDir) {
            /** @var non-falsy-string $gateDir */
            $gateDir = $this->basePath . DIRECTORY_SEPARATOR . ltrim($gateDir, "\/");

            $this->scanConfigDirectory($gateDir);
        }
    }

    private function scanConfigDirectory(string $gateDir): void
    {
           $this->fileReader->read($gateDir);
        //     // $this->routes[$filename] = $data;
    }
}
