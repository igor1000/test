<?php

namespace App\Service;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthorService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(array $data): Author
    {
        $author = new Author();
        $author->name = $data['name'];

        $this->entityManager->persist($author);
        $this->entityManager->flush();

        return $author;
    }

    public function getById(int $id): ?Author
    {
        return $this->entityManager
            ->getRepository(Author::class)
            ->find($id);
    }

    public function checkExists(int $authorId)
    {
        if (!$this->getById($authorId)) {
            throw new NotFoundHttpException('Автора не существует');
        }
    }
}
