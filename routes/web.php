<?php

use App\Http\Controllers\HelloController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello-world/{name}', [HelloController::class, 'index']);

Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
Route::post('/posts/{id}/comments', [PostController::class, 'storeComment'])->name('comments.store');
Route::post('/posts/{postId}/comments/{commentId}/replies', [PostController::class, 'storeReply'])->name('comments.reply');
Route::post('/posts/{postId}/comments/{commentId}/like', [PostController::class, 'likeComment'])->name('comments.like');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
