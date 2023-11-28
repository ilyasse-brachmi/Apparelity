<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//-----------------------Start Company Controller route-----------------//
Route::post('add-company',[CompanyController::class,'adding']);
Route::put('edit-company',[CompanyController::class,'edit']);
Route::delete('delete-company',[CompanyController::class,'delete']);
Route::get('get-company',[CompanyController::class,'getData']);
//-----------------------End Company Controller route-----------------//

//-----------------------Start Category Controller route-----------------//
Route::post('add-category',[CategoryController::class,'adding']);
Route::put('edit-category',[CategoryController::class,'edit']);
Route::delete('delete-category',[CategoryController::class,'delete']);
Route::get('get-category',[CategoryController::class,'getData']);
//-----------------------End Category Controller route-------------//

//-----------------------Start Product Controller route-----------------//
Route::post('add-product',[ProductController::class,'adding']);
Route::put('edit-product',[ProductController::class,'edit']);
Route::delete('delete-product',[ProductController::class,'delete']);
Route::get('get-product',[ProductController::class,'getData']);
//-----------------------End Product Controller route-------------//

//-----------------------Start Material Controller route-----------------//
Route::post('add-material',[MaterialController::class,'adding']);
Route::put('edit-material',[MaterialController::class,'edit']);
Route::delete('delete-material',[MaterialController::class,'delete']);
Route::get('get-material',[MaterialController::class,'getData']);
//-----------------------End Material Controller route-------------//
