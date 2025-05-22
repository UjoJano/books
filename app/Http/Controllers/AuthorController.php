<?php
namespace App\Http\Controllers;

use App\Http\Requests\Author\AuthorRequest;
use App\Http\Requests\Author\AuthorStoreRequest;
use App\Http\Requests\Author\AuthorUpdateRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use App\Services\Author\AuthorServiceInterface;
use Inertia\Inertia;

class AuthorController extends Controller
{
    public function __construct(protected AuthorServiceInterface $authorService) {}

    public function index(AuthorRequest $request)
    {
        $authors = $this->authorService->getPaginatedAuthors(
            perPage: $request->validated('per_page', 10),
            filters: $request->only(['name', 'surname']),
            sortBy: $request->validated('sort_by', 'id'),
            sortDirection: $request->validated('sort_dir', 'desc')
        );

        return Inertia::render('Author/Index', [
            'authors' => AuthorResource::collection($authors),
            'filters' => $request->only(['name', 'surname']),
            'sort' => [
                'sort_by' => $request->get('sort_by', 'id'),
                'sort_dir' => $request->get('sort_dir', 'desc')
            ]
        ]);
    }

    public function store(AuthorStoreRequest $request)
    {
        $this->authorService->create($request);

        return redirect()->route('authors.index')->with('success', 'Autor bol pridaný');
    }

    public function update(AuthorUpdateRequest $request, Author $author)
    {
        $this->authorService->update($author, $request);

        return redirect()->route('authors.index')->with('success', 'Autor bol upravený.');
    }

    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()->route('authors.index')->with('success', 'Autor bol odstránený.');
    }
}
