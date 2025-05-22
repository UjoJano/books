<?php
namespace App\Http\Requests\Author;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'      => ['nullable', 'string', 'max:255'],
            'surname'   => ['nullable', 'string', 'max:255'],
            'per_page'  => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort_by'   => ['nullable', 'in:id,name,surname'],
            'sort_dir'  => ['nullable', 'in:asc,desc'],
        ];
    }
}
