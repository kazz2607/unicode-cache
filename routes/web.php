<?php

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
