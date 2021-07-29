<?php

namespace App\Controller;

use App\Entity\Book;
use App\Service\BookService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class BookController extends AbstractController
{
    const DEFAULT_LANG = 'ru';

    private TranslatorInterface $translator;

    private BookService $bookService;

    public function __construct(TranslatorInterface $translator, BookService $bookService)
    {
        $this->translator = $translator;
        $this->bookService = $bookService;
    }

    /**
     * @Route("/book/search", name="book_search")
     */
    public function search(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        /** @var Book $book */
        $book = $this->bookService->getByTitle($data['title']);

        return $this->json($book->author, 200, [], ['groups' => 'show_author_info']);
    }

    /**
     * @Route("/{lang}/book/{id}", name="get_book", requirements={"id"="\d+"})
     */
    public function get_book(string $lang, int $id)
    {
        /** @var Book $book */
        $book = $this->bookService->getById($id);

        if ($lang != self::DEFAULT_LANG) {
            $book->title = $this->translator->trans($book->title, [], null, $lang);
        }

        return $this->json($book, 200, [], ['groups' => 'show_book_info']);
    }
}
