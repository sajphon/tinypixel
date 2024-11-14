<?php

namespace App\Application\Blog\UseCase\Posts;

use InvalidArgumentException;
use App\Domain\Blog\Model\BlogPost;
use App\Domain\User\Repository\AuthorRepositoryInterface;
use App\Domain\Blog\Repository\BlogPostRepositoryInterface;

class CreateBlogPost
{
    private BlogPostRepositoryInterface $repository;
    private AuthorRepositoryInterface   $authorRepository;

    public function __construct(
        BlogPostRepositoryInterface $repository,
        AuthorRepositoryInterface   $authorRepository
    )
    {
        $this->repository       = $repository;
        $this->authorRepository = $authorRepository;
    }

    public function execute(string $title, string $description, string $content, string $authorUuid): BlogPost
    {
        $author = $this->authorRepository->findByUuid($authorUuid);

        if (!$author) {
            throw new InvalidArgumentException('Author not found');
        }

        $blogPost = new BlogPost($title, $description, $content, $author);

        $this->repository->save($blogPost);

        return $blogPost;
    }
}
