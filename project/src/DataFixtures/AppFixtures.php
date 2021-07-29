<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    private array $books = [
        'Нетерпение сердца',
        'Метель',
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for ($authorIndex = 0; $authorIndex < 10000; $authorIndex++) {
            $author = new Author();
            $author->name = $faker->name;

            $manager->persist($author);
        }

        $manager->flush();

        foreach ($this->books as $bookTitle) {
            $book = new Book();
            $book->author = $author;
            $book->title = $bookTitle;

            $manager->persist($book);
        }

        $manager->flush();
    }
}
