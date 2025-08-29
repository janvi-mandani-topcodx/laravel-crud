<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchConroller;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('/users' , UserController::class);
Route::resource('/posts' , PostController::class);
Route::resource('comments', CommentController::class);
Route::post('/search-users', [UserController::class, 'search'])->name('users.search');
Route::post('/search', [PostController::class, 'searchPost'])->name('posts.search');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout.view');
Route::get('/login', [LoginController::class, 'viewLogin'])->name('login.view');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/forgot', [LoginController::class, 'viewForgot'])->name('forgot.password');
Route::post('/forgot', [LoginController::class, 'forgot'])->name('forgot.submit');
Route::get('/reset', [LoginController::class, 'viewReset'])->name('reset.password');
Route::post('/reset', [LoginController::class, 'reset'])->name('reset.submit');

Route::get('/mail' , [MailController::class , 'mail']);
