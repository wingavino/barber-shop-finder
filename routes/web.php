<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ShopOwnerController;
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
// Shop Owner Registration Route
Route::get('/register/shopowner', [App\Http\Controllers\ShopOwnerController::class, 'showRegistrationForm'])->name('register.shopowner');
Route::post('/register/shopowner/{pending_request?}', [App\Http\Controllers\ShopOwnerController::class, 'register'])->name('register.shopowner');

// End User Routes
Route::middleware('auth')->group(function (){
  Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
  Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('profile');
  Route::get('/user/edit', [App\Http\Controllers\UserController::class, 'showUserEdit'])->name('profile.edit');
  Route::post('/user/edit', [App\Http\Controllers\UserController::class, 'editUser'])->name('profile.edit');
  Route::get('/user/edit-password', [App\Http\Controllers\UserController::class, 'showUserEditPassword'])->name('profile.edit.password');
  Route::post('/user/edit-password', [App\Http\Controllers\UserController::class, 'editUserPassword'])->name('profile.edit.password');
  Route::get('/user/request/{id}/{request_type}/{user_type?}', [App\Http\Controllers\PendingRequestController::class, 'addPendingRequest'])->name('request');
  Route::get('/shop/{id}', [App\Http\Controllers\ShopController::class, 'showShop'])->name('shop');
  Route::get('/shop/{id}/images', [App\Http\Controllers\ShopController::class, 'showShopImages'])->name('shop.images');
  // Route::get('/user/{user}', [App\Http\Controllers\UserController::class, 'index'])->name('profile');
});

// Shop Owner Routes
Route::middleware('isShopOwner')->group(function(){
  Route::get('/shopowner/home', [App\Http\Controllers\ShopOwnerController::class, 'index'])->name('shopowner.home');
  Route::get('/shopowner/shop', [App\Http\Controllers\ShopController::class, 'showShopAsShopOwner'])->name('shopowner.shop');
  Route::get('/shopowner/shop/add', [App\Http\Controllers\ShopController::class, 'showShopAddPage'])->name('shopowner.shop.add');
  Route::post('/shopowner/shop/add', [App\Http\Controllers\ShopController::class, 'addShop'])->name('shopowner.shop.add');
  Route::get('/shopowner/shop/edit', [App\Http\Controllers\ShopController::class, 'showShopEdit'])->name('shopowner.shop.edit');
  Route::post('/shopowner/shop/edit/{id?}', [App\Http\Controllers\ShopController::class, 'editShop'])->name('shopowner.shop.edit');
  Route::get('/shopowner/shop/images', [App\Http\Controllers\ShopController::class, 'showShopImagesAsShopOwner'])->name('shopowner.shop.images');
  Route::post('/shopowner/shop/images/{id}/delete', [App\Http\Controllers\ImageController::class, 'deleteImage'])->name('shopowner.shop.images.delete');
  Route::get('/shopowner/shop/images/upload', [App\Http\Controllers\ImageController::class, 'showUploadImage'])->name('shopowner.shop.images.upload');
  Route::post('/shopowner/shop/images/upload', [App\Http\Controllers\ImageController::class, 'uploadImage'])->name('shopowner.shop.images.upload');
  Route::get('/shopowner/shop/services', [App\Http\Controllers\ShopController::class, 'showShopServices'])->name('shopowner.shop.services');
  Route::get('/shopowner/shop/services/add', [App\Http\Controllers\ShopController::class, 'showAddShopServices'])->name('shopowner.shop.services.add');
  Route::post('/shopowner/shop/services/add', [App\Http\Controllers\ShopController::class, 'AddShopServices'])->name('shopowner.shop.services.add');
});

// Admin Routes
Route::middleware('isAdmin')->group(function(){
  Route::get('/admin/home', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.home');
  Route::get('/admin/admins', [App\Http\Controllers\AdminController::class, 'admins'])->name('admin.admins');
  Route::get('/admin/admins/add', [App\Http\Controllers\AdminController::class, 'showAddAdmin'])->name('admin.add');
  Route::post('/admin/admins/add', [App\Http\Controllers\AdminController::class, 'registerNoLogin'])->name('admin.add');
  Route::post('/admin/admins/delete/{id}', [App\Http\Controllers\AdminController::class, 'deleteAdmin'])->name('admin.delete');

  Route::get('/admin/pending-requests', [App\Http\Controllers\AdminController::class, 'showPendingRequestsPage'])->name('admin.pending-requests');
  Route::post('/admin/pending-requests/{request_type}/{id}/reject', [App\Http\Controllers\PendingRequestController::class, 'rejectPendingRequest'])->name('admin.pending-requests.reject');

  Route::get('/admin/shopowners', [App\Http\Controllers\ShopOwnerController::class, 'showShopOwners'])->name('admin.shopowners');
  Route::get('/admin/shopowners/add', [App\Http\Controllers\ShopOwnerController::class, 'showShopOwnersAdd'])->name('admin.shopowners.add');
  Route::post('/admin/shopowners/add', [App\Http\Controllers\ShopOwnerController::class, 'registerNoLogin'])->name('admin.shopowners.add');
  Route::get('/admin/shopowners/edit/{id}/{type}', [App\Http\Controllers\ShopOwnerController::class, 'showEditShopOwners'])->name('admin.shopowners.edit');
  Route::post('/admin/shopowners/edit/{id}/{type}', [App\Http\Controllers\UserController::class, 'changeUserType'])->name('admin.shopowners.edit');

  Route::get('/admin/shops', [App\Http\Controllers\ShopController::class, 'showShops'])->name('admin.shops');
  Route::post('/admin/shops/add', [App\Http\Controllers\ShopController::class, 'addShop'])->name('admin.shops.add');
  Route::get('/admin/shops/add/{lat?}/{lng?}', [App\Http\Controllers\ShopController::class, 'showShopsAdd'])->name('admin.shops.add');
  Route::get('/admin/shops/edit/{id}', [App\Http\Controllers\ShopController::class, 'showEditShop'])->name('admin.shops.edit');
  Route::post('/admin/shops/edit/{id}', [App\Http\Controllers\ShopController::class, 'editShop'])->name('admin.shops.edit');
  Route::get('/admin/shops/delete/{id}', [App\Http\Controllers\ShopController::class, 'showDeleteShop'])->name('admin.shops.delete');
  Route::post('/admin/shops/delete/{id}', [App\Http\Controllers\ShopController::class, 'deleteShop'])->name('admin.shops.delete');

  Route::post('/admin/shops/{id}', [App\Http\Controllers\ShopController::class, 'approveShop'])->name('admin.shops.approve');
});

// Google Authentication
Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [LoginController::class, 'handleGoogleCallback']);
Route::get('register/google', [LoginController::class, 'redirectToGoogle'])->name('register.google');
Route::get('register/shopowner/google', [ShopOwnerController::class, 'redirectToGoogle'])->name('register.shopowner.google');
Route::get('register/shopowner/google/callback', [ShopOwnerController::class, 'handleGoogleCallback']);
