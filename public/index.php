<?php

require '../vendor/autoload.php';

use App\Router\Router;

$router = new Router();

$url = $_SERVER['PATH_INFO'] ?: "";
$method = $_SERVER['REQUEST_METHOD'];

if (!isset($method)) {

} else {
    $router->get('/', function () {
        echo "home";
    });

    $router->get('/books', function () {
        echo "all books";
    });

    $router->get('/books/:id-:slug', function ($id, $slug) {
        echo $slug . " " . $id;
    })
        ->constraint('id', '[0-9]+')
        ->constraint('slug', '[a-z\-0-9]+');

    $router->get('/books/:id', function ($id) {
        echo $id;
    });

    $router->get('/books/:id/author/dogs/:dog', function ($id, $dog) {
        echo "author for " . $id . " " . $dog;
    });

    $router->post('/books/:id', function ($id) {
        echo $id;
    });

    try {
        $router->run($url, $method);
    } catch (Exception $exception) {
        echo $exception->getMessage() . " " . $exception->getCode();
    }
}
