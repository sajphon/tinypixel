<?php

namespace App\Application\User\UseCase;

use App\Domain\User\Repository\AuthorRepositoryInterface;

class ListAuthors
{
    private AuthorRepositoryInterface $authorRepository;

    public function __construct(AuthorRepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function execute(int $page, int $limit): array
    {
        $authors      = $this->authorRepository->findAllPaginated($page, $limit);
        $totalAuthors = $this->authorRepository->count();

        return [
            'authors'    => $authors,
            'totalPages' => (int)ceil($totalAuthors / $limit),
        ];
    }
}
