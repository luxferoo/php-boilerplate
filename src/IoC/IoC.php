<?php

namespace App\IoC;


class IoC
{
    private $services = [];
    private static $instance;

    private function __construct(){}

    public static function getInstance()
    {
        if (self::$instance instanceof IoC) {
            return self::$instance;
        } else {
            self::$instance = new IoC();
            return self::$instance;
        }
    }

    public function register(String $name, \Closure $callback)
    {
        if (isset($this->services[$name])) {
            throw new IoCException("Service $name already exist.");
        }
        $this->services[$name] = $callback;
    }

    public function getService(String $name)
    {
        if (!isset($this->services[$name])) {
            throw new IoCException("Service $name does not exist.");
        }
        return $this->services[$name]();
    }

}