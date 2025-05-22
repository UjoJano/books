<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    protected $fillable = ['name', 'surname'];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $value): void
    {
        $this->name = $value;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $value): void
    {
        $this->surname = $value;
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function getBooksCount(): int
    {
        return $this->books()->count();
    }
}
