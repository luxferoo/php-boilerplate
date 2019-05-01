<?php


namespace tests\IoC;


use App\IoC\IoCException;
use PHPUnit\Framework\TestCase;
use App\IoC\IoC;

class IoCTest extends TestCase
{
    private static $routerFactory;
    private static $container;

    public static function setUpBeforeClass(): void
    {
        self::$routerFactory = function () {
            $router = new \stdClass();
            $router->name = "router";
            return $router;
        };
        self::$container = IoC::getInstance();
    }

    public function testRegister()
    {
        self::$container->register("router", self::$routerFactory);
        $this->assertTrue(true);
    }

    public function testRegisterSameName()
    {
        $this->expectException(IoCException::class);
        self::$container->register("router", self::$routerFactory);
    }

    public function testGetService()
    {
        self::$container->getService("router");
        $this->assertTrue(true);
    }

    public function testGetNonExistentService()
    {
        $this->expectException(IoCException::class);
        self::$container->getService("router1");
    }
}