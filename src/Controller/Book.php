<?php

namespace App\Controller;

use App\IoC\IoC;

class Book
{
    use Controller;

    public function show(int $id): String
    {
        echo IoC::getInstance()->getService('router')->getUrl("show.book");
        return $id;
    }
}
