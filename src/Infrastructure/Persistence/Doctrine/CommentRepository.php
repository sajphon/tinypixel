<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Blog\Model\Comment;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Blog\Repository\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Comment $comment): void
    {
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }

    public function deleteByUuid(string $uuid): void
    {
        $comment = $this->findByUuid($uuid);
        if ($comment !== null) {
            $this->entityManager->remove($comment);
            $this->entityManager->flush();
        }
    }

    public function findByUuid(string $uuid): ?Comment
    {
        return $this->entityManager->getRepository(Comment::class)->findOneBy(['uuid' => $uuid]);
    }
}