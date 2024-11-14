<?php

namespace App\Domain\Blog\Repository;

use App\Domain\Blog\Model\Comment;

interface CommentRepositoryInterface
{
    public function save(Comment $comment): void;

    public function findByUuid(string $uuid): ?Comment;

    public function deleteByUuid(string $uuid): void;
}
