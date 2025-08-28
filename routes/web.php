<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchConroller;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/create/posts', function () {
    return view('posts.create-post');
});
Route::resource('/users' , UserController::class);
Route::resource('/posts' , PostController::class);
Route::post('/search-users', [SearchConroller::class, 'search'])->name('users.search');
Route::post('/search-post', [PostController::class, 'searchPost'])->name('posts.search');
Route::get('/login', [LoginController::class, 'viewlogin'])->name('login.view');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
