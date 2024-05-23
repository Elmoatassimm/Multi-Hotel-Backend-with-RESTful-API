<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\SpecialOfferController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomFeatureController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Routes sans authentification
Route::apiResource('features', FeatureController::class)->only(['index', 'show']);
Route::apiResource('events', EventController::class)->only(['index', 'show']);
Route::apiResource('hotel', HotelController::class)->only(['index', 'show']);
Route::apiResource('rooms', RoomController::class)->only(['index', 'show']);
Route::apiResource('reviews', ReviewController::class)->only(['index', 'show']);
Route::apiResource('specialOffer', SpecialOfferController::class)->only(['index', 'show']);




Route::middleware('auth:api')->group(function () {

Route::apiResource('reviews', ReviewController::class)->except(['index', 'show']);
Route::patch('/bookings/{id}/cancel', [BookingController::class, 'cancel']);
Route::patch('/bookings/{id}/confirm', [BookingController::class, 'confirm']);
Route::apiResource('Bookings',BookingController::class)->only(['store', 'show']);

});

Route::middleware('auth:api')->group(function () {
    Route::middleware('can:isAdmin')->group(function () {
    

    
Route::apiResource('features', FeatureController::class)->except(['index', 'show']);
Route::apiResource('events', EventController::class)->except(['index', 'show']);
Route::apiResource('hotel', HotelController::class)->except(['index', 'show']);

Route::apiResource('rooms', RoomController::class)->except(['index', 'show']);
Route::apiResource('specialOffer', SpecialOfferController::class)->except(['index', 'show']);
Route::post('/rooms/{room}/features', [RoomFeatureController::class, 'store']);
Route::delete('/rooms/{room}/features/{feature}', [RoomFeatureController::class, 'destroy']);
Route::apiResource('Bookings',BookingController::class)->except(['store', 'show']);


});
});








Route::group([
    
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
});

