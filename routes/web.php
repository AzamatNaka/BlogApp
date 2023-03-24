<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
    return redirect()->route('posts.index');
});

Route::middleware('auth')->group(function (){
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::resource('posts', PostController::class)->except('index', 'show');
    Route::resource('/comments', CommentController::class)->only('store', 'update', 'destroy');
});
Route::resource('posts', PostController::class)->only('index', 'show');

Route::get('/register', [RegisterController::class, 'create'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [LoginController::class, 'create'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');


