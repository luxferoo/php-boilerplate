<?php

namespace App\Services\Router;

use App\Helpers\EventEmitter;

class Router implements EventEmitter
{
    private $routes = [];
    private $namedRoutes = [];
    private $proxies = [];
    private $events = [];
    private $eventsOnce = [];
    private static $instance;
    const GET = "GET";
    const POST = "POST";
    const PUT = "PUT";
    const DELETE = "DELETE";
    const ROUTER_REQUEST_EVENT = "router.request";
    const ROUTER_REQUEST_ERROR_EVENT = "router.request.error";
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
        $this->emit(self::ROUTER_REQUEST_EVENT, $url, $method);

        /** @var Route $route */
        foreach ($this->routes[$method] as $route) {
            if ($route->match($url)) {
                $matches = $route->getMatches();
                foreach ($this->proxies as $proxy) {
                    $proxy($url, $matches);
                }
                $route->setMatches($matches);
                try {
                    $result = $route->call();
                    $this->emit(self::ROUTER_RESPONSE_EVENT, $result, $url, $method);
                    return $result;
                } catch (\Exception $exception) {
                    $this->emit(self::ROUTER_RESPONSE_ERROR_EVENT, $exception->getMessage(), $url, $method);
                    return null;
                }
            }
        }
        $this->emit(self::ROUTER_REQUEST_ERROR_EVENT, "Oups! Route not found : $url", $url, $method);
        //throw new RouterException("Oups! Route not found : $url", 404);
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

    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Executes a callback on an emitted event
     * @param String $event
     * @param \Closure $callback
     * @param int $priority
     * @return mixed
     */
    public function on(String $event, \Closure $callback, int $priority = 0): self
    {
        $this->events[$event][] = [$priority => $callback];
        return $this;
    }

    /**
     * Executes a callback on an emitted event and only once
     * @param String $event
     * @param \Closure $callback
     * @return mixed
     */
    public function once(String $event, \Closure $callback): self
    {
        if (!isset($this->eventsOnce[$event])) {
            $this->eventsOnce[$event] = $callback;
        }
        return $this;
    }

    /**
     * Emits an event
     * @param String $event
     * @param $args
     * @internal param \Closure $callback
     * @internal param $args
     */
    public function emit(String $event, ...$args): void
    {
        if (isset($this->eventsOnce[$event])) {
            $this->eventsOnce[$event]($args);
            return;
        }
        if (isset($this->events[$event])) {
            $events = $this->events[$event];
            uasort($events, function ($a, $b) {
                return array_keys($a)[0] < array_keys($b)[0];
            });
            foreach ($events as $callbacks) {
                foreach ($callbacks as $k => $callback) {
                    $callback($args);
                }
            }
        }
    }

    public function detach(String $event, \Closure $callback): self
    {
        return $this;
    }

    public function detachOnce(String $event, \Closure $callback): self
    {
        return $this;
    }
}