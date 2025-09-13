<?php

namespace EssentialMVC\Core;

use EssentialMVC\Core\View;
use EssentialMVC\Core\Database;
use EssentialMVC\Core\Middleware;
use EssentialMVC\Core\Router;
use EssentialMVC\Http\Request;
use EssentialMVC\Http\Response;
use EssentialMVC\Exception\NotFoundException;
use EssentialMVC\Support\Env\Env;
use EssentialMVC\Support\Env\EnvLoaderByFile;

class Kernel
{
    private string $basePath;
    private Env $env;
    private Request $request;
    private Response $response;
    private Router $router;
    private Middleware $middleware;

    public function __construct(
        string $basePath,
        Env $env,
        // Request $request,
        // Response $response,
        // Router $router,
        // Middleware $middleware
    ) {
        $this->basePath = $basePath;
        $this->env = $env;
        // $this->request = $request;
        // $this->response = $response;
        // $this->router = $router;
        // $this->middleware = $middleware;

        // $this->basePath = rtrim($basePath, '/');

        // date_default_timezone_set($env->get('APP_TIMEZONE', 'UTC'));


        // // // Timezone
        // // date_default_timezone_set($env->get('APP_TIMEZONE', 'UTC'));

        // $this->loadEnv();
        // $this->loadConfig();

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

    private function loadEnV(): void
    {
        $envLoader = new EnvLoaderByFile("{$this->basePath}/.env");
        $envLoader->load();
    }

















































    public static function getInstance(): App
    {
        return self::$instance;
    }

    private function loadConfig(): void
    {
        $dir = $this->basePath . '/config';
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') continue;
                $filename = pathinfo($file, PATHINFO_FILENAME);
                $this->config[$filename] = include $dir . '/' . $file;
            }
        } else if (is_file($dir)) {
            $filename = pathinfo($dir, PATHINFO_FILENAME);
            $this->config[$filename] = include $dir;
        }
    }

    private function loadRoutes(): void
    {
        $this->router->group([], function (Router $router) {
            foreach ($this->config['routes'] as $route) {
                $routeFile = $this->basePath . $route;
                if (file_exists($routeFile)) include $routeFile;
            }
        });
    }

    private function addMiddlewares(): void
    {
        $this->config['middlewares'] = $this->middleware->queueRoute;
    }

    private function getPdoConnection()
    {
        try {
            $this->pdo = (new Database())->pdo;
        } catch (\PDOException $e) {
            echo "Errore di connessione al database";
            exit;
        }
    }

    public function run(): void
    {
        try {
            $this->router->resolve();
        } catch (NotFoundException $e) {
            $this->response->set404($e);
        }
        $this->response->send();
    }
}
