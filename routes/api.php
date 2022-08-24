<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('/author/{author}',[AuthorsController::class,'show']);
Route::post('/register',[AuthorController::class,'register']);

Route::post('/login',[AuthorController::class,'login']);
Route::middleware('auth:sanctum')->post('/logout',[AuthorController::class,'logout']);
Route::middleware('auth:sanctum')->post('/store',[AuthorsController::class,'store']);
Route::middleware('auth:sanctum')->post('/update/{id}',[AuthorsController::class,'update']);
Route::middleware('auth:sanctum')->get('/show',[AuthorsController::class,'show']);
Route::middleware('auth:sanctum')->get('/send-verify-mail/{email}',[AuthorController::class,'sendVerifyMail']);
Route::middleware('auth:sanctum')->post('/change',[AuthorController::class,'change_password']);
Route::post('/pswrst',[PasswordResetController::class,'send_reset_password_email']);
Route::post('/reset/{token}',[PasswordResetController::class,'reset']);
 

