<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Service\AuthorService;
use App\Service\BookService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use Exception;

class BookController extends AbstractController
{
    const DEFAULT_LANG = 'ru';

    private TranslatorInterface $translator;

    private BookService $bookService;

    private AuthorService $authorService;

    public function __construct(
        TranslatorInterface $translator,
        BookService $bookService,
        AuthorService $authorService
    ) {
        $this->translator = $translator;
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    /**
     * @Route("/book/create", name="create_book", methods={"POST"})
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        try {
            $this->authorService->checkExists($data['authorId']);

            $book = $this->bookService->create($data);

            return $this->json($book, 200, [], ['groups' => 'show_book_info']);
        } catch (Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 404);
        }
    }

    /**
     * @Route("/book/search", name="book_search", methods={"POST"})
     */
    public function search(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        /** @var Book $book */
        $book = $this->bookService->getByTitle($data['title']);

        return $this->json($book->author, 200, [], ['groups' => 'show_author_info']);
    }

    /**
     * @Route("/{lang}/book/{id}", name="get_book", requirements={"id"="\d+"}, methods={"GET"})
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
