<?php

namespace App\Controller;

use App\Router\Router;
use App\IOC\IoC;

class Book
{
    public function show(int $id)
    {
        /** @var Router $router */
        $router = IoC::getInstance()->getService("router");
        echo $router->url('show_book', ['id' => 1, 'slug' => 'my-book']) . PHP_EOL;
    }
}