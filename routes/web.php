<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDemoController;
use App\Http\Middleware\LoginMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware('emailVerify' , 'auth')->group(function (){
    Route::resource('users' , UserController::class);
    Route::resource('posts' , PostController::class);
    Route::resource('comments', CommentController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('chats', ChatController::class);
    Route::resource('user-demo', UserDemoController::class);
});

//Route::get('/logout', [LoginController::class, 'logout'])->name('logout.view');
//Route::get('/login', [LoginController::class, 'viewLogin'])->name('login.view');
//Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
//Route::get('/forgot', [LoginController::class, 'viewForgot'])->name('forgot.password');
//Route::post('/forgot', [LoginController::class, 'forgot'])->name('forgot.submit');
//Route::get('/reset', [LoginController::class, 'viewReset'])->name('reset.password');
//Route::post('/reset', [LoginController::class, 'reset'])->name('reset.submit');
//Route::get('/verify', [LoginController::class, 'viewVerify'])->name('email.verify');
//Route::post('/verify', [LoginController::class, 'verify'])->name('verify.user');
Route::post('/usersData', [UserController::class, 'exports'])->name('exports.user');
Route::get('/chat/search', [ChatController::class, 'chat'])->name('chat.admin.user');
Route::get('/chat/message', [ChatController::class, 'message'])->name('chat.messages');
Route::get('/admin/chat/messages', [ChatController::class, 'getMessages'])->name('chat.message');

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('verified')->name('home');
