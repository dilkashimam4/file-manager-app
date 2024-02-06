<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\CrudController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/home/get-data',[HomeController::class,'getData']);
Route::post('/folder/create',[CrudController::class,'createFolder']);
Route::get('/files/get-data/{id}',[HomeController::class,'getFiles']);
Route::get('/folder/edit/{id}',[HomeController::class,'getFolderName']);
Route::post('/folder/update/{id}',[CrudController::class,'updateFolder']);
Route::get('/folder/delete/{id}',[CrudController::class,'deleteFolder']);
Route::post('/files/upload/{id}',[HomeController::class,'uploadFiles']);
Route::get('/files/download/{id}',[HomeController::class,'downloadFiles']);
Route::get('/file/delete/{id}',[CrudController::class,'deleteFiles']);