<?php
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\backend\newsController;
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

// @User Signin
Route::post('/signin',                 [ApiController::class, 'signin']);

Route::middleware('auth:sanctum')->group( function () {
    // @Get Product
    Route::get('/product',          [ApiController::class, 'getProduct']);
    
    // @Add News
    Route::post('/add-news',         [newsController::class, 'apiAddNews']);
    Route::post('/update-news',      [newsController::class, 'apiUpdateNews']);
    Route::post('/remove-news',      [newsController::class, 'removeNews']);

    
});