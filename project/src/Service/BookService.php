<?php

namespace App\Service;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;

class BookService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getById(int $id): ?Book
    {
        return $this->entityManager
            ->getRepository(Book::class)
            ->find($id);
    }

    public function getByTitle(string $title): ?Book
    {
        return $this->entityManager
            ->getRepository(Book::class)
            ->findOneBy([
                'title' => $title
            ]);
    }
}
