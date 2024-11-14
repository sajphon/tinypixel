<?php

namespace App\Application\User\UseCase;

use RuntimeException;
use InvalidArgumentException;
use App\Domain\User\Repository\AuthorRepositoryInterface;
use App\Domain\Blog\Repository\BlogPostRepositoryInterface;

class DeleteAuthor
{
    private AuthorRepositoryInterface   $authorRepository;
    private BlogPostRepositoryInterface $blogPostRepository;

    public function __construct(
        AuthorRepositoryInterface   $authorRepository,
        BlogPostRepositoryInterface $blogPostRepository
    )
    {
        $this->authorRepository   = $authorRepository;
        $this->blogPostRepository = $blogPostRepository;
    }

    public function execute(string $uuid): void
    {
        $author = $this->authorRepository->findByUuid($uuid);

        if (!$author) {
            throw new InvalidArgumentException('Author not found.');
        }

        $blogPostCount = $this->blogPostRepository->countByAuthor($author->getId());
        if ($blogPostCount > 0) {
            throw new RuntimeException('Cannot delete author because they have associated blog posts.');
        }

        $this->authorRepository->deleteByUuid($uuid);
    }
}
