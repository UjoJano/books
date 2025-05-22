<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->getId(),
            'name'       => $this->getName(),
            'surname'    => $this->getSurname(),
            'booksCount' => $this->getBooksCount(),
        ];
    }
}
