<?php

namespace App\Application\Blog\UseCase\Posts;

use InvalidArgumentException;
use App\Domain\Blog\Model\BlogPost;
use App\Domain\Blog\Repository\BlogPostRepositoryInterface;

class GetBlogPost
{
    private BlogPostRepositoryInterface $repository;

    public function __construct(BlogPostRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $uuid): BlogPost
    {
        $blogPost = $this->repository->findByUuid($uuid);
        if (!$blogPost) {
            throw new InvalidArgumentException('Blog post not found');
        }

        return $blogPost;
    }
}
