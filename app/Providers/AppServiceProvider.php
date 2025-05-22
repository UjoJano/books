<?php

namespace App\Providers;

use App\Repositories\Author\AuthorRepository;
use App\Repositories\Author\AuthorRepositoryInterface;
use App\Repositories\Book\BookRepository;
use App\Repositories\Book\BookRepositoryInterface;
use App\Services\Author\AuthorService;
use App\Services\Author\AuthorServiceInterface;
use App\Services\Book\BookService;
use App\Services\Book\BookServiceInterface;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthorServiceInterface::class, AuthorService::class);
        $this->app->bind(AuthorRepositoryInterface::class, AuthorRepository::class);
        $this->app->bind(BookServiceInterface::class, BookService::class);
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
