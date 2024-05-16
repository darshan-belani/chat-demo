<?php

use App\Http\Controllers\HomeController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/chat/send-message', [HomeController::class, 'store'])->name('chat.send');
Route::post('/chat/get-message', [HomeController::class, 'getMessage'])->name('getMessage');

Route::get('/user-chat', [HomeController::class, 'index'])->name('home');
Route::post('/user/chat/send-message', [HomeController::class, 'messageStore'])->name('user.chat.send');
Route::post('/user/chat/get-message', [HomeController::class, 'getUserMessage'])->name('user.getMessage');

