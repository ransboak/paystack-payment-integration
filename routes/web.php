<?php

use App\Http\Controllers\PaystackController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    //$posts = Post::where('user_id', auth()->id())->get();
    return view('home');
})->name('home');
// Laravel 8 & 9
// Route::get('/payment/callback', [PaystackController::class, 'handleGatewayCallback']);
// // Laravel 8 & 9
// Route::post('/pay', [PaystackController::class, 'redirectToGateway'])->name('pay');
// Route::get('callback', [PaystackController::class, 'callback'])->name('callback');
// Route::get('success', [PaystackController::class, 'callback'])->name('success');
// Route::get('cancelled', [PaystackController::class, 'callback'])->name('cancelled');
// Route::post('/register', [UserController::class, 'register']);

// Route::post('/logout', [UserController::class, 'logout']);
// Route::post('/login', [UserController::class, 'login']);


// Route::post('/create-post', [PostController::class, 'createPost']);
// Route::get('/edit-post/{post}', [PostController::class, 'showEditScreen']);
// Route::put('/edit-post/{post}', [PostController::class, 'actuallyUpdatePost']);
// Route::delete('/delete-post/{post}', [PostController::class, 'deletePost']);
Route::post('/pay', [PaystackController::class, 'make_payment'])->name('pay');
Route::get('/pay/callback', [PaystackController::class, 'payment_callback'])->name('pay.callback');
