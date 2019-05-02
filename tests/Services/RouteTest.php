<?php


namespace tests\Services\Router;

use App\Services\Router\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public static $route;
    public const PATH = "/books/:slug-:id";

    public static function setUpBeforeClass(): void
    {
        self::$route = new Route(self::PATH, function ($slug, $id) {
            return $slug . " " . $id;
        });
    }

    public function testMatch()
    {
        $this->assertTrue(self::$route->match("/books/my-book-1"));
        $this->assertFalse(self::$route->match("/laptops/my-laptop-1"));
    }

    public function testConstraints()
    {
        $route = new Route(self::PATH, function ($slug, $id) {
            return $slug . " " . $id;
        });
        $route
            ->constraint('id', '[0-9]+')
            ->constraint('slug', '[a-z\-0-9]+');
        $this->assertTrue($route->match("/books/my-book-1"));
        $this->assertFalse($route->match("/books/my-book-15d"));
    }

    public function testGetUrl()
    {
        $this->assertSame(self::$route->getUrl(["id" => 1, "slug" => "my-book"]), "books/my-book-1");
    }

    public function testCall()
    {
        $this->assertSame("my-book 1",self::$route->call());
    }

    public function testGetMatches()
    {
        $this->assertSame(self::$route->getMatches(),["my-book","1"]);
    }
}