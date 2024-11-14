<?php

namespace App\Application\User\UseCase;

use App\Domain\User\Model\Author;
use App\Domain\User\Repository\AuthorRepositoryInterface;

class CreateAuthor
{
    private AuthorRepositoryInterface $repository;

    public function __construct(AuthorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $name, string $email): void
    {
        $author = new Author($name, $email);
        $this->repository->save($author);
    }
}
