<?php

use App\IoC\IoC;
use App\Service\Logger\Logger;
use App\Service\Router\Router;
use App\Service\Db\Connection;
use App\Repository\Factory;

IoC::getInstance()
    ->register("router", function () {
        static $router;
        if ($router instanceof Router) {
            return $router;
        }
        $router = new Router();
        return $router
            ->once(Router::ROUTER_REQUEST_EVENT, function (Router $router) {
                // LOG THIS SHIT $router->getRequestedUrl() . PHP_EOL;
            })
            ->once(Router::ROUTER_ROUTE_NOT_FOUND_EVENT, function (Router $router) {
                echo "Oups! Route not found";
                IoC::getInstance()->getService("logger")->error("[404] Route " . $router->getRequestedUrl() . " not found");
                http_response_code(404);
            })
            ->once(Router::ROUTER_RESPONSE_ERROR_EVENT, function (Router $router) {
                echo "Oups! Server error";
                IoC::getInstance()->getService("logger")->error("[500] Route " . $router->getRequestedUrl());
                http_response_code(500);
            })
            ->once(Router::ROUTER_RESPONSE_EVENT, function (Router $router) {
                $response = $router->getResponse();
                IoC::getInstance()->getService("logger")->info("[" . http_response_code() . "] Route " . $router->getRequestedUrl());
                echo $response;
            });
    })
    ->register("db", function () {
        static $connection;
        if ($connection instanceof Connection) {
            return $connection;
        }
        $connection = new Connection();
        $connection->init("pgsql:host=localhost;dbname=testdb;", "postgres", "password");
        return $connection;
    })
    ->register("repository.factory", function () {
        return new Factory(IoC::getInstance()->getService("db")->getConnection());
    })
    ->register("logger", function () {
        return new Logger(
            "logs.log",
            PROJECT_ROOT . DIRECTORY_SEPARATOR . "var" . DIRECTORY_SEPARATOR . "logs"
        );
    });
