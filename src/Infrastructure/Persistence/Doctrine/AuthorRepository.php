<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\User\Model\Author;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\User\Repository\AuthorRepositoryInterface;

class AuthorRepository implements AuthorRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Author $author): void
    {
        $this->entityManager->persist($author);
        $this->entityManager->flush();
    }

    public function deleteByUuid(string $uuid): void
    {
        $author = $this->findByUuid($uuid);

        if ($author !== null) {
            $this->entityManager->remove($author);
            $this->entityManager->flush();
        }
    }

    public function findByUuid(string $uuid): ?Author
    {
        return $this->entityManager->getRepository(Author::class)->findOneBy(['uuid' => $uuid]);
    }

    public function findAllPaginated(int $page, int $limit): array
    {
        $query = $this->entityManager->createQueryBuilder()
                                     ->select('a')
                                     ->from(Author::class, 'a')
                                     ->orderBy('a.name', 'ASC')
                                     ->setFirstResult(($page - 1) * $limit)
                                     ->setMaxResults($limit)
                                     ->getQuery();

        return $query->getResult();
    }

    public function count(): int
    {
        return (int)$this->entityManager->createQueryBuilder()
                                        ->select('COUNT(a.id)')
                                        ->from(Author::class, 'a')
                                        ->getQuery()
                                        ->getSingleScalarResult();
    }
}
