<?php

use App\Http\Controllers\Cron;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BungalowController;
use App\Http\Controllers\RegimentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DirectorateController;
use App\Http\Controllers\CancelRemarkController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\PermissionCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::group(['middleware' => ['auth']], function() {

    Route::resource('roles', RoleController::class);

    Route::get('/users/suspend/{id}',[UserController::class,'suspend'])->name('users.suspend');
    Route::get('/users/suspendusers/',[UserController::class,'suspendusers'])->name('users.suspendusers');
    Route::get('/users/activate/{id}',[UserController::class,'activate'])->name('users.activate');
    Route::get('/users/resetpass/{id}',[UserController::class,'resetpass'])->name('users.resetpass');
    Route::resource('users', UserController::class);

    Route::get('/ranks/inactive/{id}',[RankController::class,'inactive'])->name('ranks.inactive');
    Route::get('/ranks/activate/{id}',[RankController::class,'activate'])->name('ranks.activate');
    Route::resource('ranks', RankController::class);

    Route::get('/regiments/inactive/{id}',[RegimentController::class,'inactive'])->name('regiments.inactive');
    Route::get('/regiments/activate/{id}',[RegimentController::class,'activate'])->name('regiments.activate');
    Route::resource('regiments', RegimentController::class);

    Route::get('/directorates/inactive/{id}',[DirectorateController::class,'inactive'])->name('directorates.inactive');
    Route::get('/directorates/activate/{id}',[DirectorateController::class,'activate'])->name('directorates.activate');
    Route::resource('directorates',DirectorateController::class);

    Route::get('/units/inactive/{id}',[UnitController::class,'inactive'])->name('units.inactive');
    Route::get('/units/activate/{id}',[UnitController::class,'activate'])->name('units.activate');
    Route::resource('units',UnitController::class);

    Route::get('/bungalows/inactive/{id}',[BungalowController::class,'inactive'])->name('bungalows.inactive');
    Route::get('/bungalows/activate/{id}',[BungalowController::class,'activate'])->name('bungalows.activate');
    Route::resource('bungalows',BungalowController::class);

    Route::get('/permissioncategories/inactive/{id}',[PermissionCategoryController::class,'inactive'])->name('permissioncategories.inactive');
    Route::get('/permissioncategories/activate/{id}',[PermissionCategoryController::class,'activate'])->name('permissioncategories.activate');
    Route::resource('permissioncategories', PermissionCategoryController::class);

    Route::get('/permissions/inactive/{id}',[PermissionController::class,'inactive'])->name('permissions.inactive');
    Route::get('/permissions/activate/{id}',[PermissionController::class,'activate'])->name('permissions.activate');
    Route::resource('permissions', PermissionController::class);

    Route::get('/bungalow/bookings/{bungalow}',[BookingController::class,'bookings'])->name('bookings.bungalow_bookings');
    Route::get('/bookings/upload-payment-view/{id}',[BookingController::class,'upload_payment_view'])->name('bookings.upload_payment_view');
    Route::put('/bookings/upload-payment/{booking}',[BookingController::class,'upload_payment'])->name('bookings.upload_payment');
    Route::get('/bookings/cancel-booking-view/{id}',[BookingController::class,'cancelBookingView'])->name('bookings.cancel_booking_view');
    Route::put('/bookings/cancel-payment/{booking}',[BookingController::class,'cancelBooking'])->name('bookings.cancel_booking');
    Route::get('/bookings/refund-booking-view/{id}',[BookingController::class,'refundBookingView'])->name('bookings.refund_booking_view');
    Route::put('/bookings/refund-payment/{booking}',[BookingController::class,'refundBooking'])->name('bookings.refund_booking');
    Route::get('/bookings/calender/{bungalow}',[BookingController::class,'calenderView'])->name('bookings.calender');
    Route::get('/bookings/create/retired-admin',[BookingController::class,'createRetiredAdmin'])->name('bookings.create_retired_admin');
    Route::post('/bookings/store/retired-admin',[BookingController::class,'storeRetiredAdmin'])->name('bookings.store_retired_admin');

    Route::get('/bookings/pending',[BookingController::class,'bookingPending'])->name('bookings.booking_pending');
    Route::get('/bookings/approve/{booking}',[BookingController::class,'approveBooking'])->name('bookings.booking_approve');

    Route::resource('bookings',BookingController::class);

    Route::get('/banks/inactive/{id}',[BankController::class,'inactive'])->name('banks.inactive');
    Route::get('/banks/activate/{id}',[BankController::class,'activate'])->name('banks.activate');
    Route::resource('banks', BankController::class);

    Route::get('/cancel_remarks/inactive/{id}',[CancelRemarkController::class,'inactive'])->name('cancel_remarks.inactive');
    Route::get('/cancel_remarks/activate/{id}',[CancelRemarkController::class,'activate'])->name('cancel_remarks.activate');
    Route::resource('cancel_remarks', CancelRemarkController::class);

    Route::get('/change-password',  [ChangePasswordController::class,'index'])->name('change.index');
    Route::post('/change-password', [ChangePasswordController::class,'store'])->name('change.password');

    Route::get('/reports/booking_report/',[ReportController::class,'booking_report'])->name('reports.booking_report');


});

Route::get('/ajax/getBungalow',[AjaxController::class,'getBungalow'])->name('ajax.getBungalow');

Route::get('/ajax/getPayment',[AjaxController::class,'getPayment'])->name('ajax.getPayment');

Route::get('/ajax/getUnits',[AjaxController::class,'getUnits'])->name('ajax.getUnits');

// Route::get('/bookings/create/retired',[BookingController::class,'createRetired'])->name('bookings.create_retired');
// Route::post('/bookings/store/retired',[BookingController::class,'storeRetired'])->name('bookings.store_retired');

Route::get('/bookings/auto/cancel',[Cron::class,'autoCancelBookings'])->name('bookings.auto_cancel');





