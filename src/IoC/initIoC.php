<?php

use App\IoC\IoC;
use App\Services\Router\Router;

$IoC = IoC::getInstance();

$IoC->register("router", function () {
    $router = App\Services\Router\Router::getInstance();
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
});