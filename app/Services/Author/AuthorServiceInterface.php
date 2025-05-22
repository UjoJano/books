<?php
namespace App\Services\Author;

use App\Http\Requests\Author\AuthorStoreRequest;
use App\Http\Requests\Author\AuthorUpdateRequest;
use App\Models\Author;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AuthorServiceInterface
{
    public function getPaginatedAuthors(int $perPage, array $filters = [], string $sortBy = 'id', string $sortDirection = 'desc'): LengthAwarePaginator;
    public function create(AuthorStoreRequest $data): void;
    public function update(Author $author, AuthorUpdateRequest $request): Author;
    public function delete(Author $author): void;
}
