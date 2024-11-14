<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Blog\Model\BlogPost;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Blog\Repository\BlogPostRepositoryInterface;

class BlogPostRepository implements BlogPostRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(BlogPost $blogPost): void
    {
        $this->entityManager->persist($blogPost);
        $this->entityManager->flush();
    }

    public function findAllPaginated(int $page, int $limit): array
    {
        $query = $this->entityManager->createQueryBuilder()
                                     ->select('b')
                                     ->from(BlogPost::class, 'b')
                                     ->orderBy('b.createdAt', 'DESC')
                                     ->setFirstResult(($page - 1) * $limit)
                                     ->setMaxResults($limit)
                                     ->getQuery();

        return $query->getResult();
    }

    public function findAllByAuthorPaginated(int $authorId, int $page, int $limit): array
    {
        $query = $this->entityManager->createQueryBuilder()
                                     ->select('b')
                                     ->from(BlogPost::class, 'b')
                                     ->where('b.author = :authorId')
                                     ->setParameter('authorId', $authorId)
                                     ->orderBy('b.createdAt', 'DESC')
                                     ->setFirstResult(($page - 1) * $limit)
                                     ->setMaxResults($limit)
                                     ->getQuery();

        return $query->getResult();
    }

    public function findByUuid(string $uuid): ?BlogPost
    {
        return $this->entityManager->getRepository(BlogPost::class)->findOneBy(['uuid' => $uuid]);
    }

    public function count(): int
    {
        return (int)$this->entityManager->createQueryBuilder()
                                        ->select('COUNT(b.id)')
                                        ->from(BlogPost::class, 'b')
                                        ->getQuery()
                                        ->getSingleScalarResult();
    }

    public function countByAuthor(int $authorId): int
    {
        return (int)$this->entityManager->createQueryBuilder()
                                        ->select('COUNT(b.id)')
                                        ->from(BlogPost::class, 'b')
                                        ->where('b.author = :authorId')
                                        ->setParameter('authorId', $authorId)
                                        ->getQuery()
                                        ->getSingleScalarResult();
    }
}
