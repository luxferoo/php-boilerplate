<?php

namespace App\Router;

class Router
{
    private $routes = [];
    private $namedRoutes = [];
    private $proxies = [];
    private static $instance;
    const GET = "GET";
    const POST = "POST";
    const PUT = "PUT";
    const DELETE = "DELETE";

    private function __construct(){}

    public static function getInstance()
    {
        if (self::$instance instanceof Router) {
            return self::$instance;
        } else {
            self::$instance = new Router();
            return self::$instance;
        }
    }

    public function run(String $url, String $method)
    {
        /** @var Route $route */
        foreach ($this->routes[$method] as $route) {
            if ($route->match($url)) {
                $matches = $route->getMatches();
                foreach ($this->proxies as $proxy) {
                    $proxy($url, $matches);
                }
                $route->setMatches($matches);
                return $route->call();
            }
        }
        throw new RouterException("Oups! Route not found : $url", 404);
    }

    public function get(String $path, $callback, String $name = null): Route
    {
        return $this->add($path, $callback, self::GET, $name);
    }

    public function post(String $path, $callback, String $name = null): Route
    {
        return $this->add($path, $callback, self::POST, $name);
    }

    public function put(String $path, $callback, String $name = null): Route
    {
        return $this->add($path, $callback, self::PUT, $name);
    }

    public function delete(String $path, $callback, String $name = null): Route
    {
        return $this->add($path, $callback, self::DELETE, $name);
    }

    public function add(String $path, $callback, String $method, String $name = null): Route
    {
        $route = new Route($path, $callback);
        $this->routes[$method][] = $route;
        if (is_string($callback) && $name == null) {
            $this->namedRoutes[$name] = $callback;
        }
        if ($name) {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    public function url(String $name, array $params = [])
    {
        if (!isset($this->namedRoutes[$name])) {
            throw new RouterException('No route matches this name');
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }

    public function addProxy(\Closure $callback)
    {
        $this->proxies[] = $callback;
        return $this;
    }

    public function getRoutes(){
        return $this->routes;
    }
}