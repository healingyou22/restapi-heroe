<?php

use App\Http\Controllers\Authentication\AuthenticationController;
use App\Http\Controllers\BackOffice\DashboardController;
use App\Http\Controllers\BackOffice\GalleryController;
use App\Http\Controllers\BackOffice\OrderController;
use App\Http\Controllers\BackOffice\PricingController;
use App\Http\Controllers\BackOffice\ReminderController;
use App\Http\Controllers\BackOffice\ReportController;
use App\Http\Controllers\BackOffice\UserController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\WebApp\Midtrans\PaymentCallbackController;
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

// start of authentication
Route::post('/register', [AuthenticationController::class, 'register'])->name('register');
Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:api')->name('logout');
// end of authentication

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/events', [DashboardController::class, 'getEvents'])->name('events');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::put('/users/{userId}', [UserController::class, 'update'])->name('users.update');
Route::get('/users/{userId}', [UserController::class, 'show'])->name('users.show');
Route::delete('/users/{userId}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/{reportId}', [ReportController::class, 'show'])->name('reports.show');

Route::get('/galleries', [GalleryController::class, 'index'])->name('galleries.index');
Route::post('/galleries', [GalleryController::class, 'store'])->name('galleries.store');
Route::delete('/galleries/{galleryId}', [GalleryController::class, 'destroy'])->name('galleries.destroy');

Route::get('/pricings', [PricingController::class, 'index'])->name('pricings.index');
Route::post('/pricings', [PricingController::class, 'store'])->name('pricings.store');
Route::put('/pricings/{pricingId}', [PricingController::class, 'update'])->name('pricings.update');
Route::get('/pricings/{pricingId}', [PricingController::class, 'show'])->name('pricings.show');
Route::delete('/pricings/{pricingId}', [PricingController::class, 'destroy'])->name('pricings.destroy');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{orderId}', [OrderController::class, 'show'])->name('orders.show');
Route::get('/orders-cancel/{orderId}', [OrderController::class, 'cancel'])->name('orders.cancel');
Route::get('/orders-list', [OrderController::class, 'list'])->name('orders.list');

Route::post('payment/midtrans-notification', [PaymentCallbackController::class, 'receive']);
Route::post('reminder/whatsapp-notification', [ReminderController::class, 'reminder']);
