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


// Index/Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Laravel Auth Routes
Auth::routes();

// User Routes
Route::middleware('auth')->group(function (){
  Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
  Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('profile');
  Route::get('/user/edit', [App\Http\Controllers\UserController::class, 'showUserEdit'])->name('profile.edit');
  Route::post('/user/edit', [App\Http\Controllers\UserController::class, 'editUser'])->name('profile.edit');
  Route::get('/user/edit-password', [App\Http\Controllers\UserController::class, 'showUserEditPassword'])->name('profile.edit.password');
  Route::post('/user/edit-password', [App\Http\Controllers\UserController::class, 'editUserPassword'])->name('profile.edit.password');
  // Route::get('/user/{user}', [App\Http\Controllers\UserController::class, 'index'])->name('profile');
});

// Shop Owner Routes
Route::middleware('isShopOwner')->group(function(){

});

// Admin Routes
Route::middleware('isAdmin')->group(function(){
  Route::get('/admin/home', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.home');
  Route::get('/admin/shopowners', [App\Http\Controllers\AdminController::class, 'showShopOwners'])->name('admin.shopowners');
  Route::get('/admin/shopowners/add', [App\Http\Controllers\AdminController::class, 'showShopOwnersAdd'])->name('admin.shopowners.add');
  Route::get('/admin/shops', [App\Http\Controllers\AdminController::class, 'showShops'])->name('admin.shops');
  Route::get('/admin/shops/add', [App\Http\Controllers\AdminController::class, 'showShopsAdd'])->name('admin.shops.add');
});

// Google Authentication
Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [LoginController::class, 'handleGoogleCallback']);
