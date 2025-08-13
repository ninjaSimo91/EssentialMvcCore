<?php

namespace EssentialMVC\Core;

use EssentialMVC\Core\View;
use EssentialMVC\Core\Database;
use EssentialMVC\Core\Middleware;
use EssentialMVC\Core\Router;
use EssentialMVC\Http\Request;
use EssentialMVC\Http\Response;
use EssentialMVC\Exception\NotFoundException;

class App
{
    private static App $instance;

    public string $basePath;
    public array $config;
    public Request $request;
    public Router $router;

    public Middleware $middleware;
    public View $view;
    public Response $response;

    public \PDO $pdo;

    public function __construct(string $basePath)
    {
        $this->basePath = rtrim($basePath, '/');
        $this->loadConfig();

        $this->request = new Request($this);
        $this->router = new Router($this);
        $this->middleware = new Middleware($this);
        $this->response = new Response($this);

        $this->loadRoutes();

        // $this->view = new View($this);

        // $this->getPdoConnection();
        // static::$instance = $this;
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
