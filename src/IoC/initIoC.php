<?php

use App\IoC\IoC;
use App\Service\Router\Router;
use App\Db\Connection;
use App\Repository\Factory;

IoC::getInstance()
    ->register("router", function () {
        static $router;
        if($router instanceof Router) {
            return $router;
        }
        $router = new Router();
        return $router
            ->once(Router::ROUTER_REQUEST_EVENT, function (Router $router) {
                // LOG THIS SHIT $router->getRequestedUrl() . PHP_EOL;
            })
            ->once(Router::ROUTER_ROUTE_NOT_FOUND_EVENT, function () {
                echo "Oups! Route not found";
                http_response_code(404);
            })
            ->once(Router::ROUTER_RESPONSE_ERROR_EVENT, function () {
                echo "Oups! Server error";
                http_response_code(500);
            })
            ->once(Router::ROUTER_RESPONSE_EVENT, function (Router $router) {
                echo $router->getResponse();
            });
    })
    ->register("db", function () {
        static $connection;
        if($connection instanceof Connection) {
            return $connection;
        }
        $connection = new Connection();
        $connection->init("pgsql:host=localhost;dbname=testdb;","postgres","password");
        return $connection;
    })
    ->register("repository.factory", function () {
        return new Factory(IoC::getInstance()->getService("db")->getConnection());
    });
