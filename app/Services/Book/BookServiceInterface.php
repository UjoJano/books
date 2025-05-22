<?php
namespace App\Services\Book;

use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BookServiceInterface
{
    public function getPaginatedBooks(int $perPage, array $filters = [], string $sortBy = 'id', string $sortDirection = 'desc'): LengthAwarePaginator;
    public function create(BookStoreRequest $request): void;
    public function update(Book $author, BookUpdateRequest $request): Book;
    public function delete(Book $author): void;
    public function toggleBorrowed(Book $author): void;
}
