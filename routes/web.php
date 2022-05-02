<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ShopOwnerController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\EmployeeController;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Middleware\EmployeeMiddleware;
use App\Http\Middleware\ShopOwnerMiddleware;
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
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function (){
  if (Auth::user()) {
    return redirect()->route('home');
  }else {
    return view('welcome');
  }
})->name('index'); //Shows User's Home Page


// Laravel Auth Routes
Auth::routes(); //Handles functions for Laravel's Authentication

// Laravel Auth Email Verification Routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Shop Owner Registration Route
Route::get('/register/shopowner', [App\Http\Controllers\ShopOwnerController::class, 'showRegistrationForm'])->name('register.shopowner'); //Shows Registration  Page for Shopowners
Route::post('/register/shopowner/{pending_request?}', [App\Http\Controllers\ShopOwnerController::class, 'register'])->name('register.shopowner'); //Handles functions for Shopowner Registration Page

// End User Routes
Route::middleware('auth')->group(function (){
  Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); //Shows User's Home Page
  Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('profile'); //Shows User's Profile Page
  Route::get('/user/edit', [App\Http\Controllers\UserController::class, 'showUserEdit'])->name('profile.edit'); //Shows Edit Page for User's Profile
  Route::post('/user/edit', [App\Http\Controllers\UserController::class, 'editUser'])->name('profile.edit'); //Handles functions for Edit User's Profile Page
  Route::get('/user/edit-password', [App\Http\Controllers\UserController::class, 'showUserEditPassword'])->name('profile.edit.password'); //Shows Edit Page for User's Password
  Route::post('/user/edit-password', [App\Http\Controllers\UserController::class, 'editUserPassword'])->name('profile.edit.password'); //Handles functions for Edit User's Password Page
  Route::get('/user/request/{id}/{request_type}/{user_type?}', [App\Http\Controllers\PendingRequestController::class, 'addPendingRequest'])->name('request'); //Handles functions for Adding a Pending Request
  Route::get('/shop/{id}', [App\Http\Controllers\ShopController::class, 'showShop'])->name('shop'); //Shows Shop Page
  Route::get('/shop/{id}/images', [App\Http\Controllers\ShopController::class, 'showShopImages'])->name('shop.images'); //Shows Shop's Images Page
  Route::get('/shop/{id}/services', [App\Http\Controllers\ShopController::class, 'showShopServices'])->name('shop.services'); //Shows Shop's Services Page
  Route::get('/shop/{id}/reviews', [App\Http\Controllers\ShopController::class, 'showShopReviews'])->name('shop.reviews'); //Shows Shop's Reviews Page
  Route::get('/shop/{id}/reviews/add', [App\Http\Controllers\ShopController::class, 'showShopAddReview'])->name('shop.reviews.add'); //Shows Add Shop Review Page
  Route::post('/shop/{id}/reviews/add', [App\Http\Controllers\ReviewController::class, 'addShopReview'])->name('shop.reviews.add'); //Handles functions for Add Shop Review Page
  Route::post('/shop/{id}/reviews/report/{review_id}/{request_type}/user/{user_id}', [App\Http\Controllers\ReviewController::class, 'reportReview'])->name('shop.reviews.report'); //Handles functions for Reporting a Shop Review
  Route::post('/shop/{id}/ticket', [App\Http\Controllers\TicketController::class, 'getTicket'])->name('shop.ticket'); //Handles functions for getting a Queue Ticket
  Route::post('/shop/{id}/ticket/cancel', [App\Http\Controllers\TicketController::class, 'cancelTicket'])->name('shop.ticket.cancel'); //Handles functions for cancelling a Queue Ticket
  Route::get('/queue/{queue_id}/current_ticket', [App\Http\Controllers\QueueController::class, 'getCurrentTicket'])->name('queue.current_ticket'); //Handles functions for retrieving Queue's Current Ticket
});

// Shop Owner Routes
Route::middleware('isShopOwner')->group(function(){
  Route::get('/shopowner/home', [App\Http\Controllers\ShopOwnerController::class, 'index'])->name('shopowner.home'); //Shows Shopowner's Home Page
  Route::get('/shopowner/img/id', [App\Http\Controllers\ImageController::class, 'showUploadID'])->name('shopowner.img.id'); //Shows Shopowner's Page for Uploading their ID
  Route::post('/shopowner/img/id', [App\Http\Controllers\ImageController::class, 'uploadID'])->name('shopowner.img.id'); //Handles functions for Uploading Shopowner's ID Image
  Route::get('/shopowner/img/shop/doc', [App\Http\Controllers\ImageController::class, 'showUploadShopDocument'])->name('shopowner.img.shop.doc'); //Shows Shopowner's Page for Uploading their shop's Documents
  Route::post('/shopowner/img/shop/doc', [App\Http\Controllers\ImageController::class, 'uploadShopDocument'])->name('shopowner.img.shop.doc'); //Handles functions for Uploading Shop's Documents
  Route::get('/shopowner/shop', [App\Http\Controllers\ShopController::class, 'showShopAsShopOwner'])->name('shopowner.shop'); //Shows Shopowner's Shop Page
  Route::get('/shopowner/shop/add', [App\Http\Controllers\ShopController::class, 'showShopAddPage'])->name('shopowner.shop.add');  //Shows Create Shop Page
  Route::post('/shopowner/shop/add', [App\Http\Controllers\ShopController::class, 'addShop'])->name('shopowner.shop.add'); //Handles functions for Create Shop Page
  Route::get('/shopowner/shop/edit', [App\Http\Controllers\ShopController::class, 'showShopEdit'])->name('shopowner.shop.edit'); //Shows Edit Shop Page for Shopowner
  Route::post('/shopowner/shop/edit/{id?}', [App\Http\Controllers\ShopController::class, 'editShop'])->name('shopowner.shop.edit'); //Handles functions for Edit Shop Page
  Route::get('/shopowner/shop/images', [App\Http\Controllers\ShopController::class, 'showShopImagesAsShopOwner'])->name('shopowner.shop.images'); //Shows Shop's Images Page for Shopowner
  Route::post('/shopowner/shop/images/{id}/delete', [App\Http\Controllers\ImageController::class, 'deleteImage'])->name('shopowner.shop.images.delete'); //Handles functions for Deleting Shop Image
  Route::get('/shopowner/shop/images/upload', [App\Http\Controllers\ImageController::class, 'showUploadImage'])->name('shopowner.shop.images.upload'); //Shows Shop's Upload Image Page for Shopowner
  Route::post('/shopowner/shop/images/upload', [App\Http\Controllers\ImageController::class, 'uploadImage'])->name('shopowner.shop.images.upload'); //Handles functions for Uploading Shop Image
  Route::post('/shopowner/shop/images/logo/upload', [App\Http\Controllers\ImageController::class, 'uploadLogo'])->name('shopowner.shop.images.logo.upload'); //Handles functions for uploading Shop Logo Image
  Route::get('/shopowner/shop/queue', [App\Http\Controllers\ShopController::class, 'showShopQueueAsOwner'])->name('shopowner.shop.queue'); //Shows Shop's Queue Page for Shopowner
  Route::post('/shopowner/shop/queue/finish', [App\Http\Controllers\TicketController::class, 'finishCurrentTicket'])->name('shopowner.shop.queue.finish'); //Handles functions for finishing/ending Current Queue Ticket
  Route::post('/shopowner/shop/queue/hold', [App\Http\Controllers\TicketController::class, 'holdCurrentTicket'])->name('shopowner.shop.queue.hold'); //Handles functions for putting Current Queue Ticket on Hold
  Route::post('/shopowner/shop/queue/{id}/next', [App\Http\Controllers\TicketController::class, 'setNextTicket'])->name('shopowner.shop.queue.next'); //Handles functions for manually setting Next Queue Ticket
  Route::post('/shopowner/shop/queue/next/hold', [App\Http\Controllers\TicketController::class, 'setNextTicketFromOnHold'])->name('shopowner.shop.queue.next.hold'); //Handles functions for setting Next Queue Ticket from tickets in the On Hold pool
  Route::get('/shopowner/reviews', [App\Http\Controllers\ShopController::class, 'showShopReviewsAsOwner'])->name('shopowner.shop.reviews'); //Shows Shop's Reviews Page for Shopowner
  Route::get('/shopowner/shop/services', [App\Http\Controllers\ShopController::class, 'showShopServicesAsOwner'])->name('shopowner.shop.services'); //Shows Shop's Services Page for Shopowner
  Route::get('/shopowner/shop/services/add', [App\Http\Controllers\ShopController::class, 'showAddShopServices'])->name('shopowner.shop.services.add'); //Shows Add Service Page for Shop
  Route::post('/shopowner/shop/services/add', [App\Http\Controllers\ShopController::class, 'AddShopServices'])->name('shopowner.shop.services.add'); //Handles functions for Adding a Shop Service
  Route::post('/shopowner/shop/services/{id}/delete', [App\Http\Controllers\ShopController::class, 'deleteShopServices'])->name('shopowner.shop.services.delete'); //Handles functions for Deleting a Shop Service
  Route::get('/shopowner/shop/services/{id}/edit', [App\Http\Controllers\ShopController::class, 'showEditShopServices'])->name('shopowner.shop.services.edit'); //Shows Edit Page for Shop Service
  Route::post('/shopowner/shop/services/{id}/edit', [App\Http\Controllers\ShopController::class, 'editShopServices'])->name('shopowner.shop.services.edit'); //Handles functions for Editing a Shop Service
  Route::get('/shopowner/shop/employees', [App\Http\Controllers\ShopController::class, 'showShopEmployeesAsShopOwner'])->name('shopowner.shop.employees'); //Shows Shop's Employees
  Route::get('/shopowner/shop/employees/add', [App\Http\Controllers\ShopController::class, 'showAddShopEmployee'])->name('shopowner.shop.employees.add'); //Shows Add Employee Page for Shop
  Route::post('/shopowner/shop/employees/add', [App\Http\Controllers\EmployeeController::class, 'addShopEmployee'])->name('shopowner.shop.employees.add'); //Shows Add Employee Page for Shop
  Route::post('/shopowner/shop/employees/{id}/delete', [App\Http\Controllers\EmployeeController::class, 'deleteShopEmployee'])->name('shopowner.shop.employees.delete'); //Handles functions for Deleting a Shop Employee
});

// Employee Routes
Route::middleware('isEmployee')->group(function(){
  Route::get('/employee/shop', [App\Http\Controllers\ShopController::class, 'showShopAsEmployee'])->name('employee.shop'); //Shows Employee's Shop Page
  Route::get('/employee/shop/images', [App\Http\Controllers\ShopController::class, 'showShopImagesAsEmployee'])->name('employee.shop.images'); //Shows Shop's Images Page for Employee
  Route::post('/employee/shop/images/{id}/delete', [App\Http\Controllers\ImageController::class, 'deleteImage'])->name('employee.shop.images.delete'); //Handles functions for Deleting Shop Image
  Route::get('/employee/shop/images/upload', [App\Http\Controllers\ImageController::class, 'showUploadImage'])->name('employee.shop.images.upload'); //Shows Shop's Upload Image Page for Employee
  Route::post('/employee/shop/images/upload', [App\Http\Controllers\ImageController::class, 'uploadImage'])->name('employee.shop.images.upload'); //Handles functions for Uploading Shop Image
  Route::get('/employee/shop/queue', [App\Http\Controllers\ShopController::class, 'showShopQueueAsEmployee'])->name('employee.shop.queue'); //Shows Shop's Queue Page for Employee
  Route::post('/employee/shop/queue/finish', [App\Http\Controllers\TicketController::class, 'finishCurrentTicket'])->name('employee.shop.queue.finish'); //Handles functions for finishing/ending Current Queue Ticket
  Route::post('/employee/shop/queue/hold', [App\Http\Controllers\TicketController::class, 'holdCurrentTicket'])->name('employee.shop.queue.hold'); //Handles functions for putting Current Queue Ticket on Hold
  Route::post('/employee/shop/queue/{id}/next', [App\Http\Controllers\TicketController::class, 'setNextTicket'])->name('employee.shop.queue.next'); //Handles functions for manually setting Next Queue Ticket
  Route::post('/employee/shop/queue/next/hold', [App\Http\Controllers\TicketController::class, 'setNextTicketFromOnHold'])->name('employee.shop.queue.next.hold'); //Handles functions for setting Next Queue Ticket from tickets in the On Hold pool
  Route::get('/employee/reviews', [App\Http\Controllers\ShopController::class, 'showShopReviewsAsEmployee'])->name('employee.shop.reviews'); //Shows Shop's Reviews Page for Employee
  Route::get('/employee/shop/services', [App\Http\Controllers\ShopController::class, 'showShopServicesAsEmployee'])->name('employee.shop.services'); //Shows Shop's Services Page for Employee
  Route::get('/employee/shop/services/add', [App\Http\Controllers\ShopController::class, 'showAddShopServices'])->name('employee.shop.services.add'); //Shows Add Service Page for Shop
  Route::post('/employee/shop/services/add', [App\Http\Controllers\ShopController::class, 'AddShopServices'])->name('employee.shop.services.add'); //Handles functions for Adding a Shop Service
  Route::post('/employee/shop/services/{id}/delete', [App\Http\Controllers\ShopController::class, 'deleteShopServices'])->name('employee.shop.services.delete'); //Handles functions for Deleting a Shop Service
  Route::get('/employee/shop/services/{id}/edit', [App\Http\Controllers\ShopController::class, 'showEditShopServices'])->name('employee.shop.services.edit'); //Shows Edit Page for Shop Service
  Route::post('/employee/shop/services/{id}/edit', [App\Http\Controllers\ShopController::class, 'editShopServices'])->name('employee.shop.services.edit'); //Handles functions for Editing a Shop Service
  Route::get('/employee/shop/employees', [App\Http\Controllers\ShopController::class, 'showShopEmployeesAsEmployee'])->name('employee.shop.employees'); //Shows Shop's Employees
});

// Admin Routes
Route::middleware('isAdmin')->group(function(){
  Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.home'); //Shows Admin's Home Page
  Route::get('/admin/admins', [App\Http\Controllers\AdminController::class, 'admins'])->name('admin.admins'); //Shows List of Admins Page
  Route::get('/admin/admins/add', [App\Http\Controllers\AdminController::class, 'showAddAdmin'])->name('admin.add'); //Shows Add New Admin Page
  Route::post('/admin/admins/add', [App\Http\Controllers\AdminController::class, 'registerNoLogin'])->name('admin.add'); //Handles functions for Adding/Registering a New Admin
  Route::post('/admin/admins/delete/{id}', [App\Http\Controllers\AdminController::class, 'deleteAdmin'])->name('admin.delete'); //Handles functions for deleting an Admin

  Route::get('/admin/pending-requests', [App\Http\Controllers\AdminController::class, 'showPendingRequestsPage'])->name('admin.pending-requests'); //Shows Pending Requests Page
  Route::post('/admin/pending-requests/{request_type}/{id}/reject', [App\Http\Controllers\PendingRequestController::class, 'rejectPendingRequest'])->name('admin.pending-requests.reject'); //Handles functions for Rejecting a Pending Request

  Route::get('/admin/shopowners', [App\Http\Controllers\ShopOwnerController::class, 'showShopOwners'])->name('admin.shopowners'); //Shows list of Shopowners Page
  Route::get('/admin/shopowners/add', [App\Http\Controllers\ShopOwnerController::class, 'showShopOwnersAdd'])->name('admin.shopowners.add'); //Shows Add New Shopowner Page
  Route::post('/admin/shopowners/add', [App\Http\Controllers\ShopOwnerController::class, 'registerNoLogin'])->name('admin.shopowners.add'); //Handles functions for adding a New Shopowner as an Admin
  Route::get('/admin/shopowners/edit/{id}/{type}', [App\Http\Controllers\ShopOwnerController::class, 'showEditShopOwners'])->name('admin.shopowners.edit'); //Shows Edit Shopowner Page as an Admin
  Route::post('/admin/shopowners/edit/{id}/{type}', [App\Http\Controllers\UserController::class, 'changeUserType'])->name('admin.shopowners.edit'); //Handles functions for changing a User's account type (user/shopowner)

  Route::get('/admin/users', [App\Http\Controllers\UserController::class, 'showUsers'])->name('admin.users'); //Shows list of Shopowners Page
  Route::get('/admin/users/add', [App\Http\Controllers\UserController::class, 'showUsersAdd'])->name('admin.users.add'); //Shows Add New Shopowner Page
  // Route::post('/admin/users/add', [App\Http\Controllers\UserController::class, 'registerNoLogin'])->name('admin.users.add'); //Handles functions for adding a New Shopowner as an Admin
  // Route::get('/admin/users/edit/{id}/{type}', [App\Http\Controllers\UserController::class, 'showEditUsers'])->name('admin.users.edit'); //Shows Edit Shopowner Page as an Admin
  // Route::post('/admin/users/edit/{id}/{type}', [App\Http\Controllers\UserController::class, 'changeUserType'])->name('admin.users.edit'); //Handles functions for changing a User's account type (user/shopowner)

  Route::get('/admin/shop/{id}', [App\Http\Controllers\ShopController::class, 'showShop'])->name('admin.shop'); //Shows a Shop Page as an Admin
  Route::get('/admin/shops', [App\Http\Controllers\ShopController::class, 'showShops'])->name('admin.shops'); //Shows list of Shops Page
  Route::post('/admin/shops/add', [App\Http\Controllers\ShopController::class, 'addShop'])->name('admin.shops.add'); //Handles functions for Adding a New Shop as an Admin
  Route::get('/admin/shops/add/{lat?}/{lng?}', [App\Http\Controllers\ShopController::class, 'showShopsAdd'])->name('admin.shops.add'); //Shows Add New Shop Page as an Admin
  Route::get('/admin/shops/edit/{id}', [App\Http\Controllers\ShopController::class, 'showEditShop'])->name('admin.shops.edit'); //Shows Edit Shop Page as an Admin
  Route::post('/admin/shops/edit/{id}', [App\Http\Controllers\ShopController::class, 'editShop'])->name('admin.shops.edit'); //Handles functions for Edit Shop Page as an Admin
  Route::get('/admin/shops/delete/{id}', [App\Http\Controllers\ShopController::class, 'showDeleteShop'])->name('admin.shops.delete'); //Shows Delete Shop Page
  Route::post('/admin/shops/delete/{id}', [App\Http\Controllers\ShopController::class, 'deleteShop'])->name('admin.shops.delete'); //Handles functions for Deleting a Shop
  Route::post('/admin/shop/reviews/delete/{id}', [App\Http\Controllers\ReviewController::class, 'deleteReview'])->name('admin.shops.reviews.delete'); //Handles functions for deleting a Shop Review

  Route::post('/admin/shops/approve/{id}', [App\Http\Controllers\ShopController::class, 'approveShop'])->name('admin.shops.approve'); //Handles functions for Approving a New Shop
});

// Google Authentication
Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google'); //Handles functions for Redirecting from Saber to Google for User Login
Route::get('login/google/callback', [LoginController::class, 'handleGoogleCallback']); //Handles functions for Accepting Data from Google Account to Create/Login User
Route::get('register/google', [LoginController::class, 'redirectToGoogle'])->name('register.google'); //Handles functions for Redirecting from Saber to Google for User Registration
Route::get('register/shopowner/google', [ShopOwnerController::class, 'redirectToGoogle'])->name('register.shopowner.google'); //Handles functions for Redirecting from Saber to Google for Shopowner Registration
Route::get('register/shopowner/google/callback', [ShopOwnerController::class, 'handleGoogleCallback']); //Handles functions for Accepting Data from Google Account to Create/Login Shopowner
