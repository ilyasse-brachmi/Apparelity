<?php

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
Route::get('/store', function () {
    return view('welcome');
});
Route::get('/privacy-policy', function () {
    return view('welcome');
});
Route::get('/terms-of-service', function () {
    return view('welcome');
});
Route::get('/complete-account', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('welcome');
});
Route::get('/example', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('welcome');
});
