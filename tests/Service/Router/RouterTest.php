<?php

namespace tests\Services\Router;

use App\Service\Router\Route;
use App\Service\Router\Router;
use App\Service\Router\RouterException;
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
        self::$router->get("/books", function () {
            return "list of books";
        }, "books_list");

        $this->assertTrue(array_key_exists(Router::GET, self::$router->getRoutes()));
        $this->assertTrue(self::$router->getRoutes()[Router::GET][0] instanceof Route);
    }

    public function testPost()
    {
        self::$router->post("/books", function () {
        }, "post_book");

        $this->assertTrue(array_key_exists(Router::POST, self::$router->getRoutes()));
        $this->assertTrue(self::$router->getRoutes()[Router::POST][0] instanceof Route);
    }

    public function testPut()
    {
        self::$router->put("/books/:id", function () {
        }, "put_book");

        $this->assertTrue(array_key_exists(Router::PUT, self::$router->getRoutes()));
        $this->assertTrue(self::$router->getRoutes()[Router::PUT][0] instanceof Route);
    }

    public function testDelete()
    {
        self::$router->delete("/books", function () {
        }, "delete_book");

        $this->assertTrue(array_key_exists(Router::DELETE, self::$router->getRoutes()));
        $this->assertTrue(self::$router->getRoutes()[Router::DELETE][0] instanceof Route);
    }

    public function testUniqueRouteNameStringCallback()
    {
        $this->expectException(RouterException::class);
        self::$router->get("/books1", "Book#list1");
        self::$router->get("/books1", "Book#list1");
    }

    public function testUniqueRouteNameClosure()
    {
        $this->expectException(RouterException::class);
        self::$router->get("/books2", function () {
        }, "my_book_list_1");
        self::$router->get("/books2", function () {
        }, "my_book_list_1");
    }

    public function testGetRequestedUrl()
    {
        self::$router->run("/books", Router::GET);
        $this->assertSame(self::$router->getRequestedUrl(), "/books");
    }
}
