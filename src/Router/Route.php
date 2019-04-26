<?php

namespace App\Router;

class Route
{
    private $callback;
    private $path;
    private $matches = [];
    private $params = [];

    public function __construct(String $path, \Closure $callback)
    {
        $this->path = trim($path, '/');
        $this->callback = $callback;
    }

    public function match(String $url)
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "%^$path$%i";
        if (!preg_match($regex, $url, $matches)) {
            return false;
        } else {
            array_shift($matches);
            $this->matches = $matches;
            return true;
        }
    }

    public function call()
    {
        return call_user_func_array($this->callback, $this->matches);
    }

    public function constraint(String $param, String $regex)
    {
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this;
    }

    private function paramMatch(array $match)
    {
        if (isset($this->params[$match[1]])) {
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }
}