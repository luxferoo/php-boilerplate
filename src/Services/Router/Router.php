<?php

namespace App\Services\Router;

use App\Helpers\EventEmitter;

class Router extends EventEmitter
{
    private $routes = [];
    private $namedRoutes = [];
    private $proxies = [];
    private $response;
    private $url;
    private static $instance;
    const GET = "GET";
    const POST = "POST";
    const PUT = "PUT";
    const DELETE = "DELETE";
    const ROUTER_REQUEST_EVENT = "router.request";
    const ROUTER_ROUTE_NOT_FOUND_EVENT = "router.route.not.found";
    const ROUTER_RESPONSE_EVENT = "router.response";
    const ROUTER_RESPONSE_ERROR_EVENT = "router.response.error";

    private function __construct()
    {
    }

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
        $this->url = $url;
        $this->response = null;
        $this->emit(self::ROUTER_REQUEST_EVENT, $this);
        if (isset($this->routes[$method])) {
            /** @var Route $route */
            foreach ($this->routes[$method] as $route) {
                if ($route->match($url)) {
                    $matches = $route->getMatches();
                    foreach ($this->proxies as $proxy) {
                        $proxy($url, $matches);
                    }
                    $route->setMatches($matches);
                    try {
                        $this->response = $route->call();
                        $this->emit(self::ROUTER_RESPONSE_EVENT, $this);
                        return;
                    } catch (\Exception $exception) {
                        $this->emit(self::ROUTER_RESPONSE_ERROR_EVENT, $this);
                        return;
                    }
                }
            }
        }
        $this->emit(self::ROUTER_ROUTE_NOT_FOUND_EVENT, $this);
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
            $this->namedRoutes[$callback] = $callback;
        }
        if ($name) {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    public function getUrl(String $name, array $params = [])
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

    public function getRoutes()
    {
        return $this->routes;
    }

    public function getRequestedUrl()
    {
        return $this->url;
    }

    public function getResponse()
    {
        return $this->response;
    }
}