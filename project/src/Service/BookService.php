<?php

namespace App\Service;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;

class BookService
{
    private EntityManagerInterface $entityManager;
    private AuthorService $authorService;

    public function __construct(EntityManagerInterface $entityManager, AuthorService $authorService)
    {
        $this->entityManager = $entityManager;
        $this->authorService = $authorService;
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

    public function create(array $data): Book
    {
        $book = new Book();
        $book->title = $data['title'];
        $book->author = $this->authorService->getById($data['authorId']);

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return $book;
    }
}
