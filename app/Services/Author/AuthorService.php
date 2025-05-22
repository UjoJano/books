<?php
namespace App\Services\Author;

use App\Http\Requests\Author\AuthorStoreRequest;
use App\Http\Requests\Author\AuthorUpdateRequest;
use App\Models\Author;
use App\Repositories\Author\AuthorRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AuthorService implements AuthorServiceInterface
{
    public function __construct(
        protected AuthorRepositoryInterface $repository
    ) {}

    public function getPaginatedAuthors(int $perPage, array $filters = [], string $sortBy = 'id', string $sortDirection = 'desc'): LengthAwarePaginator
    {
        return $this->repository->paginateWithFilters($perPage, $filters, $sortBy, $sortDirection);
    }

    public function create(AuthorStoreRequest $data): void
    {
        $this->repository->create($data);
    }

    public function update(Author $author, AuthorUpdateRequest $request): Author
    {
        return $this->repository->update($author, $request);
    }

    public function delete(Author $author): void
    {
        $this->repository->delete($author);
    }

}
