<?php

declare(strict_types=1);

namespace EssentialMVC\Core;

use EssentialMVC\Core\Router\Router;

class Kernel
{
    // private string $basePath;
    // private Request $request;
    // private Response $response;
    // private Router $router;
    // private Middleware $middleware;

    private Router $router;

    /** 
     * @var array<string,array<string,string>>
     */
    private array $config;

    /** 
     * @param array<string,array<string,string>>
     */
    public function __construct(
        // string $basePath,
        array $config,
        // Router $router,
        // Request $request,
        // Response $response,
        // Middleware $middleware
    ) {
        // $this->basePath = rtrim($basePath, '/');
        // $this->request = $request;
        // $this->response = $response;
        // $this->router = $router;
        // $this->middleware = $middleware;

        $this->config = $config;
        // $this->router = $router;

        // $this->request = new Request($this);
        // $this->middleware = new Middleware($this);
        // $this->response = new Response($this);

        // $this->loadRoutes();

        // $this->view = new View($this);

        // $this->getPdoConnection();
        // static::$instance = $this;
    }

    public function run(): void
    {
        // dd($this->config);
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
