<?php

namespace App\Controller;

use App\Router\Router;

class Book
{
    public function show(int $id)
    {
        $router = Router::getInstance();
        echo $_GET['imam'] . PHP_EOL;
        echo $router->url('show_book', ['id' => 1, 'slug' => 'my-book']) . PHP_EOL;
        echo $id;
    }
}