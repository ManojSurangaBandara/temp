<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RankController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RegimentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DirectorateController;
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

    Route::get('/ranks/activate/{id}',[RankController::class,'activate'])->name('ranks.activate');
    Route::get('/ranks/resetpass/{id}',[RankController::class,'resetpass'])->name('ranks.resetpass');
    Route::resource('ranks', RankController::class);

    Route::get('/regiments/activate/{id}',[RegimentController::class,'activate'])->name('regiments.activate');
    Route::get('/regiments/resetpass/{id}',[RegimentController::class,'resetpass'])->name('regiments.resetpass');
    Route::resource('regiments', RegimentController::class);

    Route::get('/directorates/activate/{id}',[DirectorateController::class,'activate'])->name('directorates.activate');
    Route::get('/directorates/resetpass/{id}',[DirectorateController::class,'resetpass'])->name('directorates.resetpass');
    Route::resource('directorates',DirectorateController::class);

    Route::get('/units/activate/{id}',[UnitController::class,'activate'])->name('units.activate');
    Route::get('/units/resetpass/{id}',[UnitController::class,'resetpass'])->name('units.resetpass');
    Route::resource('units',UnitController::class);

    Route::get('/permissioncategories/inactive/{id}',[PermissionCategoryController::class,'inactive'])->name('permissioncategories.inactive');
    Route::get('/permissioncategories/activate/{id}',[PermissionCategoryController::class,'activate'])->name('permissioncategories.activate');
    Route::resource('permissioncategories', PermissionCategoryController::class);

    Route::get('/permissions/inactive/{id}',[PermissionController::class,'inactive'])->name('permissions.inactive');
    Route::get('/permissions/activate/{id}',[PermissionController::class,'activate'])->name('permissions.activate');
    Route::resource('permissions', PermissionController::class);

    Route::get('/change-password',  [ChangePasswordController::class,'index'])->name('change.index');
    Route::post('/change-password', [ChangePasswordController::class,'store'])->name('change.password');

    Route::get('/reports/person_profile/',[ReportController::class,'person_profile'])->name('reports.person_profile');
});




