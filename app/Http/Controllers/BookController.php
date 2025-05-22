<?php
namespace App\Http\Controllers;

use App\Http\Requests\Book\BookRequest;
use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Book;
use App\Services\Book\BookServiceInterface;
use Inertia\Inertia;

class BookController extends Controller
{
    public function __construct(protected BookServiceInterface $bookService) {}

    public function index(BookRequest $request)
    {
        $books = $this->bookService->getPaginatedBooks(
            perPage: $request->validated('per_page', 10),
            filters: $request->only(['title', 'author_id', 'is_borrowed']),
            sortBy: $request->validated('sort_by', 'id'),
            sortDirection: $request->validated('sort_dir', 'desc')
        );

        return Inertia::render('Book/Index', [
            'books' => BookResource::collection($books),
            'filters' => $request->only(['title', 'author_id', 'is_borrowed']),
            'sort' => [
                'sort_by' => $request->get('sort_by', 'id'),
                'sort_dir' => $request->get('sort_dir', 'desc')
            ],
            'authors' => Author::select('id', 'name', 'surname')->orderBy('surname')->get()
        ]);
    }

    public function store(BookStoreRequest $request)
    {
        $this->bookService->create($request);

        return redirect()->route('books.index')->with('success', 'Kniha bola pridaná');
    }

    public function update(BookUpdateRequest $request, Book $book)
    {
        $this->bookService->update($book, $request);

        return redirect()->route('books.index')->with('success', 'Kniha bola upravená.');
    }

    public function destroy(Book $book)
    {
        $this->bookService->delete($book);

        return redirect()->route('books.index')->with('success', 'Kniha bola odstránená.');
    }

    public function toggleBorrowed(Book $book)
    {
        $this->bookService->toggleBorrowed($book);

        return back()->with('success', 'Stav knihy bol zmenený.');
    }
}
