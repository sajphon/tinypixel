<?php

namespace App\Application\Blog\UseCase\Comments;

use App\Domain\Blog\Model\Comment;
use App\Domain\User\Model\CommentAuthor;
use App\Domain\Blog\Repository\CommentRepositoryInterface;
use App\Domain\Blog\Repository\BlogPostRepositoryInterface;
use App\Domain\User\Repository\CommentAuthorRepositoryInterface;

class AddComment
{
    private BlogPostRepositoryInterface      $blogPostRepository;
    private CommentRepositoryInterface       $commentRepository;
    private CommentAuthorRepositoryInterface $commentAuthorRepository;

    public function __construct(
        BlogPostRepositoryInterface      $blogPostRepository,
        CommentRepositoryInterface       $commentRepository,
        CommentAuthorRepositoryInterface $commentAuthorRepository
    )
    {
        $this->blogPostRepository      = $blogPostRepository;
        $this->commentRepository       = $commentRepository;
        $this->commentAuthorRepository = $commentAuthorRepository;
    }

    public function execute(string $blogPostUuid, string $content, string $authorName, string $authorEmail): void
    {
        $blogPost = $this->blogPostRepository->findByUuid($blogPostUuid);

        $commentAuthor = $this->commentAuthorRepository->findByEmail($authorEmail);

        if (!$commentAuthor) {
            $commentAuthor = new CommentAuthor($authorName, $authorEmail);
            $this->commentAuthorRepository->save($commentAuthor);
        }

        $comment = new Comment($content, $commentAuthor, $blogPost);
        $this->commentRepository->save($comment);
    }
}
