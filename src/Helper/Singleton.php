<?php

namespace App\Helper;

trait Singleton
{
    private function __construct()
    {
    }

    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static;
        }
        return $instance;
    }
}
