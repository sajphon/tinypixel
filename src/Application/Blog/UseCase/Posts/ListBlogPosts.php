<?php

namespace App\Application\Blog\UseCase\Posts;

use App\Domain\Blog\Repository\BlogPostRepositoryInterface;

class ListBlogPosts
{
    private BlogPostRepositoryInterface $repository;

    public function __construct(BlogPostRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $page, int $limit): array
    {
        $blogPosts = $this->repository->findAllPaginated($page, $limit);

        $totalPosts = $this->repository->count();
        $totalPages = (int)ceil($totalPosts / $limit);

        return [
            'blogPosts'  => $blogPosts,
            'totalPages' => $totalPages,
        ];
    }
}
