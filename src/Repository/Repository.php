<?php

namespace App\Repository;

use App\Model\Author;
use App\Model\ModelTrait;

abstract class Repository
{
    protected $con;

    public function __construct($con)
    {
    }

    public function fetchAll(): array
    {
        $class = call_user_func([$this, "getModel"]);
        return [new $class()];
    }

    public function fetchById($id)
    {
        $class = call_user_func([$this, "getModel"]);
        return (new $class())->setId($id);
    }

    abstract public function getModel();
}
