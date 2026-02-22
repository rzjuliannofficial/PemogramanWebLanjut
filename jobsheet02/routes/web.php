<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return 'Hello World V2';
});
Route::get('/world', function () {
    return 'World V2';
});
