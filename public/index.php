<?php

require '../vendor/autoload.php';

use App\Router\Router;

$router = Router::getInstance();

$url = $_SERVER['PATH_INFO'] ?: "";
$method = $_SERVER['REQUEST_METHOD'];

if (!isset($method)) {

} else {
    $router->addProxy(function (String $url, array &$params = []) {
        $params[0] = 54345;
        $_GET['imam'] = "non";
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

    try {
        $router->run($url, $method);
    } catch (Exception $exception) {
        echo $exception->getMessage() . " " . $exception->getCode();
    }
}
