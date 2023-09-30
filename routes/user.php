<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function (){
    Route::get('/posts', [PostController::class, 'index'])->name('user.posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('user.posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('user.posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('user.posts.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('user.posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('user.posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'delete'])->name('user.posts.delete');
    Route::put('/posts/{post}/like', [PostController::class, 'like'])->name('user.posts.like');
});