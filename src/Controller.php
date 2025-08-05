<?php

namespace SWD\Core;

use SWD\Core\App;

class Controller
{
    public App $app;
    public \PDO $db;

    public function __construct(App $app)
    {
        $this->app = $app;
        if(isset($this->app->pdo)) $this->db = $app->pdo;
    }

    public function view(string $page, array $values = [])
    {
        $this->app->view->render($page, $values);
    }
}
