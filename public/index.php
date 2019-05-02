<?php
declare(strict_types=1);
ini_set('display_errors', "1");

require '../vendor/autoload.php';
require '../src/IoC/initIoC.php';

use App\IOC\IoC;
use App\Services\Router\Router;

$container = IoC::getInstance();
/** @var Router $router */
$router = $container->getService("router");

$url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : "";
$method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;

if (!isset($method)) {

} else {
    /* books */
    $router->get('/', function () {
        return "home";
    });

    $router->get('/books', function () {
        return "all books";
    });

    $router->get('/books/:id-:slug', function ($id, $slug) use ($router) {
        return $id . ' ' . $slug;
    }, 'show.book')
        ->constraint('id', '[0-9]+')
        ->constraint('slug', '[a-z\-0-9]+');

    $router->get('/books/:id', "Book#show");

    $router->get('/books/:id/author/dogs/:dog', function ($id, $dog) {
        return "author for " . $id . " " . $dog;
    });

    $router->post('/books/:id', function ($id) {
        return $id;
    });
    /* books */

    try {
        $router->run($url, $method);
    } catch (Exception $exception) {
        echo $exception->getMessage() . " " . $exception->getCode();
    }
}
