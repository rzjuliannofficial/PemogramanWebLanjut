<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PenjualanController;
use Illuminate\Support\Facades\Route;

// Routes untuk POS - Jobsheet 02
Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/category/{category}', [ProductController::class,'category'])->name('product.category');
Route::get('/user/{id}/name/{name}', [UserController::class,'show'])->name('user.show');
Route::get('/penjualan', [PenjualanController::class,'index'])->name('penjualan');


