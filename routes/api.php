<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocationController;
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//-----------------------AuthController-----------------//
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
Route::post('/logout', [AuthController::class, 'logout']);
//-----------------------Start Company Controller route-----------------//
Route::post('company',[CompanyController::class,'add']);
Route::put('company',[CompanyController::class,'edit']);
Route::delete('company/{id}',[CompanyController::class,'delete']);

//-----------------------End Company Controller-----------------//

//-----------------------Start Category Controller route-----------------//
Route::post('category',[CategoryController::class,'add']);
Route::put('category',[CategoryController::class,'edit']);
Route::delete('category/{id}',[CategoryController::class,'delete']);
//-----------------------End Category Controller route-------------//

//-----------------------product controller-------------//
Route::post('product',[ProductController::class,'add']);
Route::post('product/{id}',[ProductController::class,'edit']);
Route::delete('product/{id}',[ProductController::class,'delete']);
//-----------------------Start Material Controller route-----------------//
Route::post('material',[MaterialController::class,'add']);
Route::put('material/{id}',[MaterialController::class,'edit']);
Route::delete('material/{id}',[MaterialController::class,'delete']);
//-----------------------End Material Controller route-------------//

});
//-----------------------Material controller-----------------//

//-----------------------ReviewController-----------------//
Route::post('review',[ReviewController::class,'add']);
Route::get('review',[ReviewController::class,'get']);

//-----------------------Start Product Controller route-----------------//
Route::get('product',[ProductController::class,'get']);
Route::get('product/search',[ProductController::class,'search']);
Route::get('product/{company_id}/search', [ProductController::class, 'searchInCompany']);
Route::get('product/{id}', [ProductController::class, 'getProductCompany']);
//-----------------------End Product Controller route-------------//

//-----------------------List of countries-----------------//
Route::get('countries',[LocationController::class,'countries']);

 //-----------------------List of states-----------------//
Route::get('states',[LocationController::class,'states']);

Route::get('company',[CompanyController::class,'get']);
Route::get('company/{id}',[CompanyController::class,'getOneCompany']);
Route::get('category',[CategoryController::class,'get']);

Route::get('material',[MaterialController::class,'get']);
Route::get('material/{id}',[MaterialController::class,'getMaterials']);