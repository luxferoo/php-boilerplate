<?php

namespace App\Db;


class Connection
{
    private static $instance;
    private $con;
    const DEV_ENV = "dev";
    const PROD_ENV = "prod";
    const TEST_ENV = "test";

    private function __construct($env)
    {
        switch ($env) {
            case self::DEV_ENV:
                $this->con = new \PDO('mysql:host=localhost;dbname=testdb;charset=utf8mb4', 'root', 'password');
                break;
            case self::TEST_ENV:
                $this->con = new \PDO('mysql:host=localhost;dbname=testdb;charset=utf8mb4', 'root', 'password');
                break;
            case self::PROD_ENV:
                $this->con = new \PDO('mysql:host=localhost;dbname=testdb;charset=utf8mb4', 'root', 'password');
                break;
            default:
                $this->con = new \PDO('mysql:host=localhost;dbname=testdb;charset=utf8mb4', 'root', 'password');
        }
    }

    public static function getInstance(String $env = self::DEV_ENV)
    {
        if (self::$instance instanceof Connection) {
            return self::$instance;
        } else {
            self::$instance = new Connection($env);
            return self::$instance;
        }
    }

    public function getConnection()
    {
        return $this->con;
    }
}