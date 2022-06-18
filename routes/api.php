<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\Api\PostController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });



/**
 * 
 * This API's was mandatory for me
 * 
*/

//Person routes
Route::prefix('auth')->group(function (){

    Route::post("/login",[AuthController::class, 'login']);
    Route::post("/register",[AuthController::class, 'register']);
});

Route::group(['middleware'=>'auth:api'], function () {

    //Page routes
    Route::prefix('page')->group(function($router) {
        Route::post("/create",[PageController::class, 'store']);
        Route::post("/{id}/attach-post",[PostController::class, 'PagePostStore']);
    });


    //Post routes for person
    Route::prefix('person')->group(function($router) {
        Route::post("/attach-post",[PostController::class, 'PersonPostStore']);

        //Optional api routes
        Route::get("/feed",[PostController::class, 'getAllPost']);
    });




    /**
     * 
     * This API's was optional for me
     * 
     * Page and user follower routes
     * 
    */
    Route::prefix('follow')->group(function($router) {
        Route::put("/person/{id}",[PersonController::class, 'StoreFollowingPerson']);
        Route::put("/page/{id}",[PageController::class, 'StoreFollowingPage']);
    });

});

 