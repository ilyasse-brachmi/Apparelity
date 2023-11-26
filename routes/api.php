<?php

use App\Http\Controllers\CompanyController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//-----------------------AuthController-----------------//
Route::get('register',[AuthController::class,'register']);
Route::get('login',[AuthController::class,'login']);
Route::middleware('auth:sanctum')->group(function () {
Route::post('/logout', [AuthController::class, 'logout']);
});
//-----------------------Start Company Controller-----------------//
Route::post('add-company',[CompanyController::class,'adding']);
Route::put('edit-company',[CompanyController::class,'edit']);
Route::delete('delete-company',[CompanyController::class,'delete']);
Route::get('get-company',[CompanyController::class,'getData']);
//-----------------------End Company Controller-----------------//


