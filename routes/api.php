<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LocationController;
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//-----------------------AuthController-----------------//
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::middleware('auth:sanctum')->group(function () {
Route::post('/logout', [AuthController::class, 'logout']);
});
//-----------------------ReviewController-----------------//
Route::post('review',[ReviewController::class,'add']);
Route::get('review',[ReviewController::class,'get']);
//-----------------------Start Company Controller-----------------//

//-----------------------Start Company Controller route-----------------//
Route::post('company',[CompanyController::class,'add']);
Route::put('company',[CompanyController::class,'edit']);
Route::delete('company/{id}',[CompanyController::class,'delete']);
Route::get('company',[CompanyController::class,'get']);
//-----------------------End Company Controller-----------------//

//-----------------------SearchController-----------------//
Route::get('product',[SearchController::class,'searchProducts']);
//-----------------------End Company Controller route-----------------//

//-----------------------Start Category Controller route-----------------//
Route::post('category',[CategoryController::class,'add']);
Route::put('category',[CategoryController::class,'edit']);
Route::delete('category/{id}',[CategoryController::class,'delete']);
Route::get('category',[CategoryController::class,'get']);
//-----------------------End Category Controller route-------------//

//-----------------------Start Product Controller route-----------------//
Route::post('product',[ProductController::class,'add']);
Route::post('product/{id}',[ProductController::class,'edit']);
Route::delete('product',[ProductController::class,'delete']);
Route::get('product',[ProductController::class,'get']);
//-----------------------End Product Controller route-------------//

//-----------------------Start Material Controller route-----------------//
Route::post('material',[MaterialController::class,'add']);
Route::put('material',[MaterialController::class,'edit']);
Route::delete('material/{id}',[MaterialController::class,'delete']);
Route::get('material',[MaterialController::class,'get']);
//-----------------------End Material Controller route-------------//

//-----------------------List of countries-----------------//
Route::get('countries',[LocationController::class,'countries']);
 //-----------------------List of states-----------------//
 Route::get('states',[LocationController::class,'states']);