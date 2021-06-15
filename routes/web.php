<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/bs-4', function () {
    return view('bs4');
});

Route::get('/bs-5', function () {
    return view('bs5');
});

Route::get('/tailwind', function () {
    return view('tw');
});
