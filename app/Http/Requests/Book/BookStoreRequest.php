<?php
namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'author_id' => ['required', 'exists:authors,id'],
            'is_borrowed' => ['nullable', 'boolean'],
        ];
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthorId(): int
    {
        return $this->author_id;
    }
    public function isBorrowed(): bool
    {
        return $this->is_borrowed;
    }
}
