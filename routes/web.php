<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Cache;
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

Route::get('demo-cache', function(){
    // Cache::put('domain', 'unicode.vn', '600');
    // Cache::put('course', 'LARAVEL ONLINE', '600');
    // echo Cache::get('domain');
    echo Cache::get('course');
});

Route::get('product/{id}',[ProductController::class, 'getProduct'])->name('getProduct');

Route::get('forget-cache/{id}',[ProductController::class, 'forgetCache'])->name('forget-cache');

Route::get('flush-cache',[ProductController::class, 'flushCache'])->name('flush-cache');
