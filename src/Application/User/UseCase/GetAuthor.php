<?php

namespace App\Application\User\UseCase;

use InvalidArgumentException;
use App\Domain\User\Model\Author;
use App\Domain\User\Repository\AuthorRepositoryInterface;

class GetAuthor
{
    private AuthorRepositoryInterface $repository;

    public function __construct(AuthorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $uuid): Author
    {
        $author = $this->repository->findByUuid($uuid);
        if (!$author) {
            throw new InvalidArgumentException('Author not found');
        }

        return $author;
    }
}
