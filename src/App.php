<?php

namespace SWD\Core;

use SWD\Core\View;
use SWD\Core\Database;
use SWD\Core\Middleware;
use SWD\Core\Router;
use SWD\Core\Http\Request;
use SWD\Core\Http\Response;
use SWD\Core\Exception\NotFoundException;

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
        $this->basePath = $basePath;

        $this->request = new Request();
        $this->middleware = new Middleware($this);
        $this->router = new Router($this);
        $this->response = new Response($this);
        $this->view = new View($this);

        $this->addConfig();
        
        // $this->getPdoConnection();
        static::$instance = $this;
    }

    public static function getInstance(): App
    {
        return self::$instance;
    }

    private function addConfig(): void
    {
        $this->addRoutes();

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
        $this->config['middleware'] = $this->middleware->queueRoute;
    }

    private function addRoutes(): void
    {
        $this->config['routes'] = $this->router->group(function (Router $router) {
            include $this->basePath . '/routes/web.php';
            return $router->routes;
        });
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
