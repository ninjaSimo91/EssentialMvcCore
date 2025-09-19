<?php

declare(strict_types=1);

namespace EssentialMVC\Core;

use EssentialMVC\Support\Contracts\Loader;

class RouterLoaderByFiles implements Loader
{
    private string $routeDir;
    private RouterFileReader $fileReader;

    /** 
     * @var array<string,array<string,string>> $routes
     */
    private array $routes;

    public function __construct(string $routerDir, RouterFileReader $fileReader)
    {
        $this->routerDir = $routerDir;
        $this->fileReader = $fileReader;
    }

    public function load(): void {}


   
}
