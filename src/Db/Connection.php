<?php

namespace App\Db;

class Connection
{
    private $con;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        static $instance;
        if ($instance instanceof Connection) {
            return $instance;
        } else {
            $instance = new Connection();
            return $instance;
        }
    }

    public function init($dsn, $username, $password)
    {
        if (isset($this->con)) {
            throw new DatabaseConnectionException("Database connection already initialized");
        }
        $this->con = new \PDO($dsn, $username, $password);
    }

    public function getConnection()
    {
        if (!isset($this->con)) {
            throw new DatabaseConnectionException("Database connection not initialised");
        }
        return $this->con;
    }
}
