<?php

namespace App\Domain\Blog\Repository;

use App\Domain\Blog\Model\BlogPost;

interface BlogPostRepositoryInterface
{
    public function save(BlogPost $blogPost): void;

    public function findByUuid(string $uuid): ?BlogPost;

    public function findAllPaginated(int $page, int $limit): array;

    public function findAllByAuthorPaginated(int $authorId, int $page, int $limit): array;

    public function count(): int;

    public function countByAuthor(int $authorId): int;
}
