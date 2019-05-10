<?php

namespace App\Model;

class Author
{
    use ModelTrait;

    private $name;
    private $books;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param String $name
     * @return $this
     */
    public function setName(String $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * @param $book
     * @return $this
     * @internal param mixed $books
     */
    public function addBook(Book $book)
    {
        $this->books[$book->getId()] = $book;
        return $this;
    }
}
