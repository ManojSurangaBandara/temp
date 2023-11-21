<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\BungalowController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Generate Token and send to mobile app
Route::post('/generate-token', [AuthController::class, 'generateToken']);

// Generate OTP and send to mobile app
Route::post('/generate-otp', [AuthController::class, 'generateOTP']);

// Verify OTP and generate JWT token
Route::post('/verify-otp', [AuthController::class, 'verifyOTP']);

Route::get('/bungalows', [BungalowController::class, 'index']);

Route::get('/bookings', [BookingController::class, 'index']); 

Route::post('/store-booking', [BookingController::class, 'storeBooking']);

Route::get('/search-by-eno', [BookingController::class, 'serachbyEno']);

Route::post('/store-booking-guest', [BookingController::class, 'storeGuest']);

Route::post('/store-booking-guest-one', [BookingController::class, 'storeGuestOne']);

Route::post('/store-booking-vehicle', [BookingController::class, 'storeVehicle']);

Route::post('/store-booking-vehicle-one', [BookingController::class, 'storeVehicleOne']);

Route::get('/get-booking-vehicles', [BookingController::class, 'getVehicles']);

Route::get('/get-booking-guests', [BookingController::class, 'getGuests']);

Route::put('/update-guest',[BookingController::class, 'updateGuest']);

Route::put('/update-vehicle',[BookingController::class, 'updateVehicle']);

Route::delete('/delete-guest', [BookingController::class, 'deleteGuest']);

Route::delete('/delete-vehicle', [BookingController::class, 'deleteVehicle']);

Route::get('/getbanks', [BankController::class, 'index']);

Route::post('/store-booking-payment', [BookingController::class, 'storePayment']);


