<?php


namespace tests\Controller;

use PHPUnit\Framework\TestCase;
use App\Controller\Book;

class BookTest extends TestCase
{
    public function testShow()
    {
        $bookController = new Book();
        $this->assertSame("1", $bookController->show(1));
    }
}