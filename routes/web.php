<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchConroller;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/createposts', function () {
    return view('posts.createPost');
});
Route::resource('/users' , UserController::class);
Route::resource('/posts' , PostController::class);
Route::post('/search-users', [SearchConroller::class, 'search'])->name('users.search');
Route::get('/login', [UserController::class, 'viewlogin'])->name('login.view');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');
