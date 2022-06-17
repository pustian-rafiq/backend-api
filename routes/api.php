<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PageController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Person routes
Route::prefix('auth')->group(function (){

    Route::post("/login",[AuthController::class, 'login']);
    Route::post("/register",[AuthController::class, 'register']);
   
});

//Page routes
Route::group(['middleware'=>'auth:api','prefix'=>'page'], function($router) {
    Route::post("/create",[PageController::class, 'store']);
});