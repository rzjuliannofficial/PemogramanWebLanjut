<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

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


Route::resource('photos', PhotoController::class);
Route::resource('photos', PhotoController::class)->only([
 'index', 'show'
]);
Route::resource('photos', PhotoController::class)->except([
 'create', 'store', 'update', 'destroy'
]);

// Praktikum 3
Route::get('/greeting', function () {
    return view('hello', ['name' => 'Julian']);
});
