<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;

Route::get('/', function () {
    return view('welcome');
});

//Praktikum 1
// 1
Route::get('/hello', function () {
    return 'Hello World V2';
});
Route::get('/world', function () {
    return 'World V2';
});

// 2
Route::get('/user/{name}', function ($name) {
    return 'Nama saya '.$name;
});

Route::get('/posts/{post}/comments/{comment}', function
($postId, $commentId) {
    return 'Pos ke-'.$postId." Komentar ke-: ".$commentId;
});

Route::get('/articles/{id}', function ($id) {
    return 'Halaman Artikel dengan ID '.$id;
});

// 3
Route::get('/user/{name?}', function ($name=null) {
    return 'Nama saya '.$name;
});
Route::get('/user/{name?}', function ($name='Julian') {
    return 'Nama saya '.$name;
});


//Praktikum 2
Route::get('/HelloCtrl', [WelcomeController::class,'hello']);
Route::get('/WelcomeCtrl', [HomeController::class,'index']);
Route::get('/AboutCtrl', [AboutController::class,'about']);
Route::get('/ArticleCtrl/{id}', [ArticleController::class,'articles']);