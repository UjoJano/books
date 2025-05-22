<?php
namespace App\Services\Book;

use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Models\Book;
use App\Repositories\Book\BookRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BookService implements BookServiceInterface
{
    public function __construct(
        protected BookRepositoryInterface $repository
    ) {}

    public function getPaginatedBooks(int $perPage, array $filters = [], string $sortBy = 'id', string $sortDirection = 'desc'): LengthAwarePaginator
    {
        return $this->repository->paginateWithFilters($perPage, $filters, $sortBy, $sortDirection);
    }

    public function create(BookStoreRequest $request): void
    {
        $this->repository->create($request);
    }

    public function update(Book $book, BookUpdateRequest $request): Book
    {
        return $this->repository->update($book, $request);
    }

    public function delete(Book $book): void
    {
        $this->repository->delete($book);
    }

    public function toggleBorrowed(Book $book): void
    {
        $this->repository->toggleBorrowed($book);
    }

}
