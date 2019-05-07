<?php
declare(strict_types=1);
ini_set('display_errors', "1");

require '../vendor/autoload.php';
require '../src/IoC/initIoC.php';
require '../config/routes/aggregator.php';

$url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : "";
$method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;

if (is_string($method) && !empty($method)) {
    try {
        initRoutes($url, $method);
    } catch (Exception $exception) {
        echo $exception->getMessage() . " " . $exception->getCode();
    }
}
