<?php
declare(strict_types=1);

namespace EssentialMVC\Core;

use Closure;
use EssentialMVC\Core\App;
use EssentialMVC\Exception\NotFoundException;

class Router
{
    public App $app;
    public array $routes = [];
    private array $groupPrefixes = [];
    private array $groupAliases = [];
    private array $groupMiddlewares = [];
    private string $parentController = '';


    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function group(array $options, Closure $callback): void
    {
        if (!empty($options['prefix'])) $prevPrefixes = $this->groupPrefixes;
        if (!empty($options['alias'])) $prevAliases = $this->groupAliases;
        if (!empty($options['middleware'])) $prevMiddleware = $this->groupMiddlewares;
        if (!empty($options['controller']))  $prevController = $this->parentController;

        if (!empty($options['prefix'])) $this->groupPrefixes[] = trim($options['prefix'], '/');
        if (!empty($options['alias'])) $this->groupAliases[] = trim($options['alias'], '.');
        if (!empty($options['middleware'])) $this->addMiddlelwares($options['middleware']);
        if (!empty($options['controller'])) $this->parentController = $options['controller'];

        $callback($this);

        if (!empty($options['prefix'])) $this->groupPrefixes = $prevPrefixes;
        if (!empty($options['alias'])) $this->groupAliases = $prevAliases;
        if (!empty($options['middleware'])) $this->groupMiddlewares = $prevMiddleware;
        if (!empty($options['controller'])) $this->parentController = $prevController;
    }

    private function addMiddlelwares(array $middleware)
    {
        foreach ($middleware as $middleware) {
            if (!in_array($middleware, $this->groupMiddlewares)) $this->groupMiddlewares[] = $middleware;
        }
    }

    public function prefix(string $prefix, Closure $callback)
    {
        $this->group(['prefix' => $prefix], $callback);
    }

    public function alias(string $alias, Closure $callback)
    {
        $this->group(['alias' => $alias], $callback);
    }

    public function controller(Controller $controller, Closure $callback)
    {
        $this->group(['controller' => $controller], $callback);
    }

    public function middleware(array|string $middleware, Closure $callback)
    {
        if (!is_array($middleware)) $middleware = [$middleware];
        $this->group(['middleware' => $middleware], $callback);
    }

    public function prefixAlias(string $prefixAlias, Closure $callback)
    {
        $this->group(['prefix' => $prefixAlias, 'alias' => $prefixAlias], $callback);
    }

    public function prefixAliasWithMiddleware(string $prefixAlias, array|string $middleware, Closure $callback)
    {
        if (!is_array($middleware)) $middleware = [$middleware];
        $this->group(['prefix' => $prefixAlias, 'alias' => $prefixAlias, 'middleware' => $middleware], $callback);
    }

    public function prefixAliasWithController(string $prefixAlias, string $controller, Closure $callback)
    {
        $this->group(['prefix' => $prefixAlias, 'alias' => $prefixAlias, 'controller' => $controller], $callback);
    }

    public function prefixAliasWithControllerAndMiddleware(string $prefixAlias, string $controller, array|string $middleware, Closure $callback)
    {
        if (!is_array($middleware)) $middleware = [$middleware];
        $this->group(['prefix' => $prefixAlias, 'alias' => $prefixAlias, 'controller' => $controller, 'middleware' => $middleware], $callback);
    }

    public function get(string $route, array|string $controller, string $alias = "", array $middleware = []): void
    {
        if (!is_array($controller)) $controller = [$this->parentController, $controller];
        $this->addRoute('get', $route, $controller, $middleware, $alias);
    }

    public function post(string $route, array|string $controller, string $alias = "", array $middleware = []): void
    {
        if (is_string($controller)) $controller = [$this->parentController, $controller];
        $this->addRoute('post', $route, $controller, $middleware, $alias);
    }

    public function keyget(string $route, string $key, array $middleware = [], ?Controller $controller = null): void
    {
        $controller = (null === $controller) ? [$this->parentController, $key] : [$controller, $key];
        $this->get(rtrim(str_replace('$', $key, $route), '/'), $controller, $key, $middleware);
    }

    public function keypost(string $route, string $key, array $middleware = [], ?Controller $controller = null): void
    {
        $controller = (null === $controller) ? [$this->parentController, $key] : [$controller, $key];
        $this->post(rtrim(str_replace('$', $key, $route), '/'), $controller, $key, $middleware);
    }

    private function addRoute(string $method, string $route, array $controller, array $middleware = [], string $alias = ""): void
    {
        $route = implode('/', $this->groupPrefixes) . "{$route}";
        if (!isset($this->routes[$method])) $this->routes[$method] = [];

        $this->routes[$method][$route]['controller'] = $controller[0];
        $this->routes[$method][$route]['method'] = $controller[1];
        $this->routes[$method][$route]['alias'] = (empty($alias)) ? implode('.', $this->groupAliases) : ltrim(implode('.', $this->groupAliases) . ".{$alias}", ".");
        $this->routes[$method][$route]['middleware'] = array_unique(array_merge($this->groupMiddlewares, $middleware));
    }

    public function resolve(): void
    {
        $response = $this->getRoute();
        if (empty($response)) throw new NotFoundException();
        $this->dispatch($response);
    }

    public function getRoute(): array
    {
        $method = $this->app->request->getRequestMethod();
        $path = $this->app->request->getRequestPath();

        if ($method == 'post' || $method == 'put' || $method == 'delete') $post = $this->app->request->getRequestAttributes();
        return $this->routes[$method][$path] ?? $this->parseRoute($this->routes[$method], $path);
    }

    private function parseRoute(array $routes, string $path): array
    {
        foreach ($routes as $route => $attributes) {
            if (strpos($route, '{') !== false) {
                $pattern = preg_replace('#\{([\w]+)\}#', '([^/]+)', $route);
                $regex = "#^" . $pattern . "$#";

                if (preg_match($regex, $path, $matches)) {
                    array_shift($matches);
                    preg_match_all('#\{([\w]+)\}#', $route, $paramNames);

                    $params = array_combine($paramNames[1], $matches);
                    $routes[$route]['attributes'] = $params;
                    return $routes[$route];
                }
            }
        }

        return [];
    }

    public function dispatch($response): void
    {

        $controller = $response['controller'];
        $action = $response['method'];
        $attributes = $response['attributes'] ?? [];
        $middleware = $response['middleware'] ?? [];

        $instance = new $controller($this->app);

        if (!empty($middleware)) $this->app->middleware->execute($middleware);
        call_user_func_array([$instance, $action], $attributes);
    }
}
