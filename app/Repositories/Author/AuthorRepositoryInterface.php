<?php
namespace App\Repositories\Author;

use App\Http\Requests\Author\AuthorStoreRequest;
use App\Http\Requests\Author\AuthorUpdateRequest;
use App\Models\Author;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AuthorRepositoryInterface
{
    public function paginateWithFilters(
        int $perPage,
        array $filters = [],
        string $sortBy = 'id',
        string $sortDirection = 'desc'
    ): LengthAwarePaginator;

    public function create(AuthorStoreRequest $request): void;
    public function update(Author $author, AuthorUpdateRequest $request): Author;
    public function delete(Author $author): void;
}
