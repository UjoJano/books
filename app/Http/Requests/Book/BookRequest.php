<?php
namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string'],
            'author_id' => ['nullable', 'integer'],
            'is_borrowed' => ['nullable', 'boolean'],
            'per_page' => ['nullable', 'integer'],
            'sort_by' => ['nullable', 'in:id,title,is_borrowed'],
            'sort_dir' => ['nullable', 'in:asc,desc'],
        ];
    }
}
