<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Model\Author;

interface AuthorRepositoryInterface
{

    public function save(Author $author): void;

    public function findByUuid(string $uuid): ?Author;

    public function deleteByUuid(string $uuid): void;

    public function findAllPaginated(int $page, int $limit): array;

    public function count(): int;
}
