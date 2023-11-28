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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//-----------------------AuthController-----------------//
Route::get('register',[AuthController::class,'register']);
Route::get('login',[AuthController::class,'login']);
Route::middleware('auth:sanctum')->group(function () {
Route::post('/logout', [AuthController::class, 'logout']);
});
//-----------------------ReviewController-----------------//
Route::post('addReview',[ReviewController::class,'addReview']);
Route::get('getReviews',[ReviewController::class,'getReviews']);
//-----------------------Start Company Controller-----------------//

//-----------------------Start Company Controller route-----------------//
Route::post('add-company',[CompanyController::class,'adding']);
Route::put('edit-company',[CompanyController::class,'edit']);
Route::delete('delete-company',[CompanyController::class,'delete']);
Route::get('get-company',[CompanyController::class,'getData']);
//-----------------------End Company Controller-----------------//

//-----------------------SearchController-----------------//
Route::get('searchProduct',[SearchController::class,'searchProducts']);
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
