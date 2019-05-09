<?php

namespace App\Repository;

class Author extends Repository
{
    private $table = "author";

    function getModel()
    {
        return \App\Model\Author::class;
    }
}