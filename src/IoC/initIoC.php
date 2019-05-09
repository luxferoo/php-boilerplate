<?php

use App\IoC\IoC;
use App\Service\Router\Router;
use App\Db\Connection;
use App\Repository\Factory;

IoC::getInstance()
    ->register("router", function () {
        $router = Router::getInstance();
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
        return Connection::getInstance("dev");
    })
    ->register("repository.factory", function () {
        return new Factory(Connection::getInstance("dev")->getConnection());
    });
