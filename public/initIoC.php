<?php

use App\IoC\IoC;

$IoC = IoC::getInstance();

$IoC->register("router", function(){
    return App\Services\Router\Router::getInstance();
});