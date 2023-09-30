<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\Posts\CommentController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/test', TestController::class);

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

Route::resource('posts/{post}/comments', CommentController::class);


Route::get('/', function () {
    return view('welcome');
});
Route::view('/', 'welcome'); // the same

Route::redirect('/home', '/');
//Route::fallback(function (){
//    return 'our fallback';
//});

