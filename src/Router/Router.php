<?php

namespace App\Router;

class Router
{
    private $routes = [];

    public function run(String $url, String $method)
    {
        /** @var Route $route */
        foreach ($this->routes[$method] as $route) {
            if ($route->match($url)) {
                return $route->call();
            }
        }
        throw new RouterException("Oups! Route not found : $url", 404);
    }

    public function get(String $path, \Closure $callable): Route
    {
        $route = new Route($path, $callable);
        $this->routes['GET'][] = $route;
        return $route;
    }

    public function post(String $path, \Closure $callable): Route
    {
        $route = new Route($path, $callable);
        $this->routes['POST'][] = $route;
        return $route;
    }

    public function delete(String $path, \Closure $callable): Route
    {
        $route = new Route($path, $callable);
        $this->routes['DELETE'][] = $route;
        return $route;
    }

    public function put(String $path, \Closure $callable): Route
    {
        $route = new Route($path, $callable);
        $this->routes['PUT'][] = $route;
        return $route;
    }
}