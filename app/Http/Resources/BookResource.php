<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'is_borrowed' => $this->is_borrowed,
            'author'      => [
                'id'   => $this->author->id,
                'name' => $this->author->name,
                'surname' => $this->author->surname,
            ]
        ];
    }
}
