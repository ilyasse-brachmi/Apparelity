<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\categoryController;
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
Route::post('add-company',[CompanyController::class,'adding']);
Route::put('edit-company',[CompanyController::class,'edit']);
Route::delete('delete-company',[CompanyController::class,'delete']);
Route::get('get-company',[CompanyController::class,'getData']);
//-----------------------End Company Controller-----------------//
//-----------------------SearchController-----------------//
Route::get('searchProduct',[SearchController::class,'searchProducts']);