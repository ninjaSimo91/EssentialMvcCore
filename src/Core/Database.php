<?php
declare(strict_types=1);

namespace EssentialMVC\Core;

class Database
{
    public \PDO $pdo;

    public function __construct()
    {
        $dbhost = getenv('DB_HOST');
        $dbname = getenv('DB_DATABASE');
        $dbuser = getenv('DB_USERNAME');
        $dbpwd = getenv('DB_PASSWORD');

        $this->pdo = new \PDO("mysql:host={$dbhost};dbname={$dbname};charset=utf8", $dbuser, $dbpwd, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_EMULATE_PREPARES => false
        ]);
    }
}
