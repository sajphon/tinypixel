<?php

namespace App\Application\Blog\UseCase\Comments;

use App\Domain\Blog\Repository\CommentRepositoryInterface;

class DeleteComment
{
    private CommentRepositoryInterface $repository;

    public function __construct(CommentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $uuid): void
    {
        $this->repository->deleteByUuid($uuid);
    }
}
