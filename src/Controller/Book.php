<?php

namespace App\Controller;

use App\Services\Router\Router;
use App\IOC\IoC;

class Book
{
    use Controller;

    public function show(int $id): String
    {
        /** @var Router $router */
        $router = $this->getService("router");
        return $this->json(["url" => $router->url('show_book', ['id' => 1, 'slug' => 'my-book']), "id" => $id]);
    }
}