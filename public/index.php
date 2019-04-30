<?php

require '../vendor/autoload.php';
require './initIoC.php';

use App\IOC\IoC;
use App\Services\Router\Router;

$container = IoC::getInstance();
/** @var \App\Services\Router\Router $router */
$router = $container->getService("router");

$url = $_SERVER['PATH_INFO'] ?: "";
$method = $_SERVER['REQUEST_METHOD'];

if (!isset($method)) {

} else {
    $router->addProxy(function (String $url, array &$params = []) {
        $params[0] = 54345;
    });

    $router->get('/', function () {
        echo "home";
    });

    $router->get('/books', function () {
        echo "all books";
    });

    $router->get('/books/:id-:slug', function ($id, $slug) use ($router) {
        echo $id . ' ' . $slug;
    }, 'show_book')
        ->constraint('id', '[0-9]+')
        ->constraint('slug', '[a-z\-0-9]+');

    $router->get('/books/:id', "Book#show");

    $router->get('/books/:id/author/dogs/:dog', function ($id, $dog) {
        echo "author for " . $id . " " . $dog;
    });

    $router->post('/books/:id', function ($id) {
        echo $id;
    });

    $router
        ->on(Router::ROUTER_REQUEST_EVENT, function ($args) {
        })
        ->on(Router::ROUTER_REQUEST_ERROR_EVENT, function ($args) {
            echo $args[0] . PHP_EOL;
            echo $args[1] . PHP_EOL;
            echo $args[2] . PHP_EOL;
        })
        ->on(Router::ROUTER_RESPONSE_EVENT, function ($args) {
            echo $args[0];
        })
        ->on(Router::ROUTER_RESPONSE_ERROR_EVENT, function ($args) {
            echo $args[0];
        });
    try {
        $router->run($url, $method);
    } catch (Exception $exception) {
        echo $exception->getMessage() . " " . $exception->getCode();
    }
}
