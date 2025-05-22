<?php
namespace App\Repositories\Book;

use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BookRepository implements BookRepositoryInterface
{
    public function paginateWithFilters(int $perPage, array $filters = [], string $sortBy = 'id', string $sortDirection = 'desc'): LengthAwarePaginator
    {
        return Book::with('author')
            ->when($filters['title'] ?? null, fn($q, $v) => $q->where('title', 'like', "%$v%"))
            ->when($filters['author_id'] ?? null, fn($q, $v) => $q->where('author_id', $v))
            ->when(!is_null($filters['is_borrowed'] ?? null), fn($q) => $q->where('is_borrowed', $filters['is_borrowed']))
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(BookStoreRequest $request): void
    {
        Book::create([
            'title' => $request->getTitle(),
            'author_id' => $request->getAuthorId(),
            'is_borrowed' => $request->isBorrowed(),
        ]);
    }

    public function update(Book $book, BookUpdateRequest $request): Book
    {
        $book->setTitle($request->getTitle());
        $book->setAuthorId($request->getAuthorId());
        $book->setIsBorrowed($request->isBorrowed());
        $book->save();

        return $book;
    }

    public function delete(Book $book): void
    {
        $book->delete();
    }

    public function toggleBorrowed(Book $book): void
    {
        $book->setIsBorrowed(!$book->isBorrowed());
        $book->save();
    }

}
