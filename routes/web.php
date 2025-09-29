<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
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
    Route::resource('product', ProductController::class);
    Route::resource('order', OrderController::class);
    Route::resource('discounts', DiscountController::class);
    Route::get('products/cart', [ProductController::class, 'proCart'])->name('cart.product');
    Route::get('cart', [CartController::class, 'cart'])->name('cart');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('update.cart');
    Route::get('/cart/add', [CartController::class, 'cartAddButton'])->name('cart.add');
    Route::get('checkout', [CheckoutController::class, 'checkout'])->name('checkout.show');
    Route::get('items/search', [OrderController::class, 'orderSearch'])->name('order.item.search');
    Route::get('discount/product/search', [DiscountController::class, 'productSearch'])->name('discount.product.search');
    Route::get('discount/user/search', [DiscountController::class, 'userSearch'])->name('discount.user.search');
    Route::get('discount/check', [DiscountController::class, 'discountCodeCheck'])->name('discount.code.check');
    Route::post('items/update/{items}', [OrderController::class, 'orderItemUpdate'])->name('order.items.update');
//    Route::post('/item/update', [CartController::class, 'updateItems'])->name('update.item');

//    Route::post('order/create', [CheckoutController::class, 'orderCreate'])->name('create.order');
//    Route::get('order/index', [CheckoutController::class, 'orderIndex'])->name('orders.index');
//    Route::get('order/show', [CheckoutController::class, 'orderShow'])->name('orders.show');
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
Route::get('delete/variant', [ProductController::class, 'variantDelete'])->name('variants.delete');
Route::get('delete/cart', [CartController::class, 'cartDelete'])->name('delete.cart');
Route::get('delete/order/item', [OrderController::class, 'orderItemDelete'])->name('delete.order.item');


Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->middleware('verified')->name('home');
