<?php

use App\Http\Controllers\CompanyController;
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
//-----------------------Start Company Controller-----------------//
Route::post('add-company',[CompanyController::class,'adding']);
Route::put('edit-company',[CompanyController::class,'edit']);
Route::delete('delete-company',[CompanyController::class,'delete']);
Route::get('get-company',[CompanyController::class,'getData']);
//-----------------------End Company Controller-----------------//


