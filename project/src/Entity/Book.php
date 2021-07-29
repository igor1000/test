<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"show_author_info", "show_book_info"})
     */
    public int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="author")
     * @Groups({"show_book_info"})
     */
    public Author $author;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_author_info", "show_book_info"})
     */
    public string $title;
}
