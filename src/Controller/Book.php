<?php

namespace App\Controller;

class Book
{
    use Controller;

    public function show(int $id): String
    {
        return $id;
    }
}
