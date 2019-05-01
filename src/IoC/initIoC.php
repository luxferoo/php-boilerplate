<?php

use App\IoC\IoC;
use App\Services\Router\Router;

$IoC = IoC::getInstance();

$IoC->register("router", function () {
    $router = App\Services\Router\Router::getInstance();
    $router
        ->once(Router::ROUTER_REQUEST_ERROR_EVENT, function ($args) {
            echo $args[0] . PHP_EOL;
            echo $args[1] . PHP_EOL;
            echo $args[2] . PHP_EOL;
        })
        ->once(Router::ROUTER_RESPONSE_EVENT, function ($args) {
            echo $args[0];
        })
        ->once(Router::ROUTER_RESPONSE_ERROR_EVENT, function ($args) {
            echo $args[0];
        });
    return $router;
});