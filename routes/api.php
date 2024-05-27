<?php

use App\Http\Controllers\API\v1\BookingController;
use App\Http\Controllers\API\v1\HotelController;
use App\Http\Controllers\API\v1\RoomController;
use App\Http\Controllers\API\v1\EventController;
use App\Http\Controllers\API\v1\FeatureController;
use App\Http\Controllers\API\v1\SpecialOfferController;
use App\Http\Controllers\API\v1\ProfileController;
use App\Http\Controllers\API\v1\ReviewController;
use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\API\v1\RoomFeatureController;
use App\Http\Controllers\API\v1\HotelAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('v1')->group(function () {

// Routes sans authentification
Route::apiResource('features', FeatureController::class)->only(['index', 'show']);
Route::apiResource('events', EventController::class)->only(['index', 'show']);
Route::apiResource('hotels', HotelController::class)->only(['index', 'show']);
Route::apiResource('rooms', RoomController::class)->only(['index', 'show']);
Route::apiResource('reviews', ReviewController::class)->only(['index', 'show']);
Route::apiResource('specialOffers', SpecialOfferController::class)->only(['index', 'show']);




Route::middleware('auth:api')->group(function () {

Route::apiResource('reviews', ReviewController::class)->except(['index', 'show']);
Route::patch('/bookings/{id}/cancel', [BookingController::class, 'cancel']);
Route::patch('/bookings/{id}/confirm', [BookingController::class, 'confirm']);
Route::apiResource('bookings',BookingController::class)->only(['store', 'show']);

});

Route::middleware('auth:api')->group(function () {
    Route::middleware('can:isAdmin')->group(function () {
    

    
Route::apiResource('features', FeatureController::class)->except(['index', 'show']);
Route::apiResource('events', EventController::class)->except(['index', 'show']);
Route::apiResource('hotels', HotelController::class)->except(['index', 'show']);

Route::apiResource('rooms', RoomController::class)->except(['index', 'show']);
Route::apiResource('specialOffers', SpecialOfferController::class)->except(['index', 'show']);
Route::post('/rooms/{room}/features', [RoomFeatureController::class, 'store']);
Route::delete('/rooms/{room}/features/{feature}', [RoomFeatureController::class, 'destroy']);
Route::apiResource('bookings',BookingController::class)->except(['store', 'show']);
Route::get('/my-hotel-rooms', [RoomController::class, 'showMyHotelRooms']);


       
        Route::get('hotel-admins/my-hotels', [HotelAdminController::class, 'showMyHotels']);
        Route::delete('hotel-admins/my-hotels', [HotelAdminController::class, 'destroyMyHotels']);
        Route::get('my-bookings', [BookingController::class, 'showMyBookings']);


});
});

Route::middleware('auth:api')->group(function () {
    Route::middleware('can:isSuperAdmin')->group(function () {

        Route::get('hotel-admins', [HotelAdminController::class, 'index']);
        Route::get('hotel-admins/{hotel_id}/{user_id}', [HotelAdminController::class, 'show']);
        Route::delete('hotel-admins/{hotel_id}/{user_id}', [HotelAdminController::class, 'destroy']);

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

});