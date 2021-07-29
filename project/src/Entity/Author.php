<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 */
class Author
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"show_author_info", "show_book_info"})
     */
    public int $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Book", mappedBy="author")
     * @Groups({"show_author_info"})
     */
    public $books;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_author_info", "show_book_info"})
     */
    public string $name;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    /**
     * @return Collection|Book[]
     */
    public function getProducts(): Collection
    {
        return $this->books;
    }
}
