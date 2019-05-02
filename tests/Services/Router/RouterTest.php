<?php

namespace tests\Services\Router;

use App\Services\Router\Route;
use App\Services\Router\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @var Router $router
     */
    private static $router;

    public static function setUpBeforeClass(): void
    {
        self::$router = Router::getInstance();
    }

    public function testGet()
    {
        /** @var Route $route */
        self::$router->get("/books", function () {
            echo "list of books";
        }, "list_books");

        $this->assertTrue(array_key_exists(Router::GET, self::$router->getRoutes()));
        $this->assertTrue(self::$router->getRoutes()[Router::GET][0] instanceof Route);
    }

    public function testPost()
    {
        /** @var Route $route */
        self::$router->post("/books", function () {
        }, "list_books");

        $this->assertTrue(array_key_exists(Router::POST, self::$router->getRoutes()));
        $this->assertTrue(self::$router->getRoutes()[Router::POST][0] instanceof Route);
    }

    public function testPut()
    {
        /** @var Route $route */
        self::$router->put("/books/:id", function () {
        }, "list_books");

        $this->assertTrue(array_key_exists(Router::PUT, self::$router->getRoutes()));
        $this->assertTrue(self::$router->getRoutes()[Router::PUT][0] instanceof Route);
    }

    public function testDelete()
    {
        /** @var Route $route */
        self::$router->delete("/books", function () {
        }, "list_books");

        $this->assertTrue(array_key_exists(Router::DELETE, self::$router->getRoutes()));
        $this->assertTrue(self::$router->getRoutes()[Router::DELETE][0] instanceof Route);
    }
}