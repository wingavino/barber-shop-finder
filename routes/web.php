<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Models\User;
// use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('profile')->middleware('auth');
// Route::get('/user/{user}', [App\Http\Controllers\UserController::class, 'index'])->name('profile');

// Google Authentication
Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [LoginController::class, 'handleGoogleCallback']);

// User Profile
// Route::get('/user/{id}', [App\Http\Controllers\UserController::class, 'getUser']);
// Route::get('/user/edit/$user', [App\Http\Controllers\UserController::class, 'editUser']);
