<?php
namespace App\Repositories\Book;

use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BookRepositoryInterface
{
    public function paginateWithFilters(
        int $perPage,
        array $filters = [],
        string $sortBy = 'id',
        string $sortDirection = 'desc'
    ): LengthAwarePaginator;

    public function create(BookStoreRequest $request): void;
    public function update(Book $book, BookUpdateRequest $request): Book;
    public function delete(Book $book): void;
    public function toggleBorrowed(Book $book): void;
}
