<?php


use App\Service\Router\Router;

/** @var Router $router */
$router->get('/', function () {
    echo "home";
});

$router->get('/books', function () {
    echo "all books";
});

$router->get('/books/:id-:slug', function ($id, $slug) use ($router) {
    echo $id . ' ' . $slug;
}, 'show.book')
    ->constraint('id', '[0-9]+')
    ->constraint('slug', '[a-z\-0-9]+');

$router->get('/books/:id', "Book#show");

$router->get('/books/:id/author/dogs/:dog', function ($id, $dog) {
    echo "author for " . $id . " " . $dog;
});

$router->post('/books/:id', function ($id) {
    echo $id;
});

/*
 * proxies are used to modify $matches or to secure endpoints
 */
//$router->addProxy('/books',function ($url, &$matches){ die;});