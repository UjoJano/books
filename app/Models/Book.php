<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $fillable = ['author_id', 'title', 'is_borrowed'];

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $value): void
    {
        $this->title = $value;
    }

    public function isBorrowed(): bool
    {
        return $this->is_borrowed;
    }

    public function setIsBorrowed(bool $value): void
    {
        $this->is_borrowed = $value;
    }

    public function getAuthorId(): int
    {
        return $this->author_id;
    }

    public function setAuthorId(int $value): void
    {
        $this->author_id = $value;
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
