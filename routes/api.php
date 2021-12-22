<?php

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


Route::apiResource('shops', 'App\Http\Controllers\API\ShopController')->middleware('api');
Route::apiResource('open_hours', 'App\Http\Controllers\API\OpenHoursController')->middleware('api');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
