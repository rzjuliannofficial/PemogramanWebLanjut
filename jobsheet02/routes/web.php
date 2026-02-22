<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
// Route::get('/user/{name?}', function ($name='Julian') {
//     return 'Nama saya '.$name;
// });
