<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthorController::class, 'index'])->name('authors.index');
Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store');
Route::put('/authors/{author}', [AuthorController::class, 'update'])->name('authors.update');
Route::delete('/authors/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy');


Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::post('/books', [BookController::class, 'store'])->name('books.store');
Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
Route::patch('/books/{book}/toggle', [BookController::class, 'toggleBorrowed'])->name('books.toggle');

Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');

require __DIR__.'/auth.php';
