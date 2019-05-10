<?php

namespace App\Controller;

use App\IoC\IoC;
use App\Repository\Factory;
use App\Repository\Author as AuthorRepo;

class Author
{
    use Controller;

    /** @var  Factory */
    private $reposFactory;

    public function __construct()
    {
        $container = IoC::getInstance();
        $this->reposFactory = $container->getService('repository.factory');
    }

    public function index(): String
    {
        $repos = $this->reposFactory->get(AuthorRepo::class);
        return $this->json($repos->fetchAll());
    }

    public function show(int $id): String
    {
        $repos = $this->reposFactory->get(AuthorRepo::class);
        $author = $repos->fetchById($id);
        return $author->getId();
    }
}
