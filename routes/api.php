<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

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


Route::apiResource('shops', 'App\Http\Controllers\API\ShopController')->middleware('api');
Route::apiResource('open_hours', 'App\Http\Controllers\API\OpenHoursController')->middleware('api');
Route::apiResource('reviews', 'App\Http\Controllers\API\ReviewController')->middleware('api');
Route::apiResource('images', 'App\Http\Controllers\API\ImageController')->middleware('api');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/email', [NotificationController::class, 'email']);

Route::post('/validate-phone-number', [\App\Http\Controllers\PhoneNumberController::class, 'show']);

