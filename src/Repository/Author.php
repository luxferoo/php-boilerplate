<?php

namespace App\Repository;

class Author extends Repository
{
    private $table = "author";

    public function getModel()
    {
        return \App\Model\Author::class;
    }
}
