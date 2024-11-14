<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Model\CommentAuthor;

interface CommentAuthorRepositoryInterface
{
    public function save(CommentAuthor $author): void;

    public function findByUuid(string $uuid): ?CommentAuthor;

    public function findByEmail(string $email): ?CommentAuthor;
}
