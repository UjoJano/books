<?php
namespace App\Repositories\Author;

use App\Http\Requests\Author\AuthorStoreRequest;
use App\Http\Requests\Author\AuthorUpdateRequest;
use App\Models\Author;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function paginateWithFilters(
        int $perPage,
        array $filters = [],
        string $sortBy = 'id',
        string $sortDirection = 'desc'
    ): LengthAwarePaginator {
        return Author::withCount('books')
            ->when($filters['name'] ?? null, fn($q, $v) => $q->where('name', 'like', "%$v%"))
            ->when($filters['surname'] ?? null, fn($q, $v) => $q->where('surname', 'like', "%$v%"))
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(AuthorStoreRequest $request): void
    {
        Author::create([
            'name' => $request->getName(),
            'surname' => $request->getSurname(),
        ]);
    }

    public function update(Author $author, AuthorUpdateRequest $request): Author
    {
        $author->setName($request->getName());
        $author->setSurname($request->getSurname());
        $author->save();

        return $author;
    }

    public function delete(Author $author): void
    {
        $author->delete();
    }

}
