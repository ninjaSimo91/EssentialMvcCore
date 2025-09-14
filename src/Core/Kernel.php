<?php

namespace EssentialMVC\Core;

use EssentialMVC\Support\Config\Contracts\ConfigLoader;

class Kernel
{
    // private string $basePath;
    // private Request $request;
    // private Response $response;
    // private Router $router;
    // private Middleware $middleware;

    /** 
     * @var array<string,array<string,string>>
     */
    private array $config;

    public function __construct(
        // string $basePath,
        ConfigLoader $configLoader,
        // Request $request,
        // Response $response,
        // Router $router,
        // Middleware $middleware
    ) {
        // $this->basePath = rtrim($basePath, '/');
        // $this->request = $request;
        // $this->response = $response;
        // $this->router = $router;
        // $this->middleware = $middleware;

        $this->config = $this->loadConfig($configLoader);
        dd($this->config);

        // $this->request = new Request($this);
        // $this->router = new Router($this);
        // $this->middleware = new Middleware($this);
        // $this->response = new Response($this);

        // $this->loadRoutes();
        // dd($this->router->routes);

        // $this->view = new View($this);

        // $this->getPdoConnection();
        // static::$instance = $this;
    }

    /** 
     * @return array<string,array<string,string>> 
     */
    private function loadConfig(ConfigLoader $configLoader): array
    {
        return $configLoader->get();
    }

    // private function loadRoutes(): void
    // {
    //     $this->router->group([], function (Router $router) {
    //         foreach ($this->config['routes'] as $route) {
    //             $routeFile = $this->basePath . $route;
    //             if (file_exists($routeFile)) include $routeFile;
    //         }
    //     });
    // }

    // private function addMiddlewares(): void
    // {
    //     $this->config['middlewares'] = $this->middleware->queueRoute;
    // }

    // private function getPdoConnection()
    // {
    //     try {
    //         $this->pdo = (new Database())->pdo;
    //     } catch (\PDOException $e) {
    //         echo "Errore di connessione al database";
    //         exit;
    //     }
    // }

    // public function run(): void
    // {
    //     try {
    //         $this->router->resolve();
    //     } catch (NotFoundException $e) {
    //         $this->response->set404($e);
    //     }
    //     $this->response->send();
    // }
}
