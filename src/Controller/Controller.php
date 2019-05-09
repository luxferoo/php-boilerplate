<?php

namespace App\Controller;

use App\IoC\IoC;

trait Controller
{
    private function getService(String $service): Object
    {
        return IoC::getInstance()->getService($service);
    }

    private function json($data): String
    {
        header("Content-type: application/json");
        return json_encode($data);
    }
}