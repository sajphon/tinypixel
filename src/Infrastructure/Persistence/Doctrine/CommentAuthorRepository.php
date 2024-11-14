<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\User\Model\CommentAuthor;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\User\Repository\CommentAuthorRepositoryInterface;

class CommentAuthorRepository implements CommentAuthorRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(CommentAuthor $author): void
    {
        $this->entityManager->persist($author);
        $this->entityManager->flush();
    }

    public function findByEmail(string $email): ?CommentAuthor
    {
        return $this->entityManager->getRepository(CommentAuthor::class)->findOneBy(['email' => $email]);
    }


    public function findByUuid(string $uuid): ?CommentAuthor
    {
        return $this->entityManager->getRepository(CommentAuthor::class)->findOneBy(['uuid' => $uuid]);
    }
}