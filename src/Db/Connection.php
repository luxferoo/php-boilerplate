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
                $this->con = new \PDO('pgsql:host=localhost;dbname=testdb;', 'postgres', 'password');
                break;
            case self::TEST_ENV:
                $this->con = new \PDO('pgsql:host=localhost;dbname=testdb;', 'postgres', 'password');
                break;
            case self::PROD_ENV:
                $this->con = new \PDO('pgsql:host=localhost;dbname=testdb;', 'postgres', 'password');
                break;
            default:
                $this->con = new \PDO('pgsql:host=localhost;dbname=testdb;', 'postgres', 'password');
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