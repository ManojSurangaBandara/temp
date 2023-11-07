<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NokController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForceController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\UsertypeController;
use App\Http\Controllers\CardPrintController;
use App\Http\Controllers\EthnicityController;
use App\Http\Controllers\CardDetailController;
use App\Http\Controllers\DependenceController;
use App\Http\Controllers\DSDivisionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RanaviruTypeController;
use App\Http\Controllers\RelationShipController;
use App\Http\Controllers\MaritalStatusController;
use App\Http\Controllers\CardIssuePersonController;
use App\Http\Controllers\CardIssueCriteriaController;
use App\Http\Controllers\CardIssuanceStatusController;
use App\Http\Controllers\PermissionCategoryController;
use App\Http\Controllers\RegimentDepartmentController;

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

    Route::get('/forces/inactive/{id}',[ForceController::class,'inactive'])->name('forces.inactive');
    Route::get('/forces/activate/{id}',[ForceController::class,'activate'])->name('forces.activate');
    Route::resource('forces', ForceController::class);

    Route::get('/ranks/inactive/{id}',[RankController::class,'inactive'])->name('ranks.inactive');
    Route::get('/ranks/activate/{id}',[RankController::class,'activate'])->name('ranks.activate');
    Route::resource('ranks', RankController::class);

    Route::get('/ranaviru_types/inactive/{id}',[RanaviruTypeController::class,'inactive'])->name('ranaviru_types.inactive');
    Route::get('/ranaviru_types/activate/{id}',[RanaviruTypeController::class,'activate'])->name('ranaviru_types.activate');
    Route::resource('ranaviru_types', RanaviruTypeController::class);

    Route::get('/card_issuance_status/inactive/{id}',[CardIssuanceStatusController::class,'inactive'])->name('card_issuance_status.inactive');
    Route::get('/card_issuance_status/activate/{id}',[CardIssuanceStatusController::class,'activate'])->name('card_issuance_status.activate');
    Route::resource('card_issuance_status', CardIssuanceStatusController::class);

    Route::get('/ethnicity/inactive/{id}',[EthnicityController::class,'inactive'])->name('ethnicity.inactive');
    Route::get('/ethnicity/activate/{id}',[EthnicityController::class,'activate'])->name('ethnicity.activate');
    Route::resource('ethnicity', EthnicityController::class);

    Route::get('/marital_status/inactive/{id}',[MaritalStatusController::class,'inactive'])->name('marital_status.inactive');
    Route::get('/marital_status/activate/{id}',[MaritalStatusController::class,'activate'])->name('marital_status.activate');
    Route::resource('marital_status', MaritalStatusController::class);

    Route::get('/province/inactive/{id}',[ProvinceController::class,'inactive'])->name('province.inactive');
    Route::get('/province/activate/{id}',[ProvinceController::class,'activate'])->name('province.activate');
    Route::resource('province', ProvinceController::class);

    Route::get('/card_issue_criterias/inactive/{id}',[CardIssueCriteriaController::class,'inactive'])->name('card_issue_criterias.inactive');
    Route::get('/card_issue_criterias/activate/{id}',[CardIssueCriteriaController::class,'activate'])->name('card_issue_criterias.activate');
    Route::resource('card_issue_criterias', CardIssueCriteriaController::class);

    Route::get('/regiment_departments/inactive/{id}',[RegimentDepartmentController::class,'inactive'])->name('regiment_departments.inactive');
    Route::get('/regiment_departments/activate/{id}',[RegimentDepartmentController::class,'activate'])->name('regiment_departments.activate');
    Route::resource('regiment_departments', RegimentDepartmentController::class);

    Route::get('/relation_ships/inactive/{id}',[RelationShipController::class,'inactive'])->name('relation_ships.inactive');
    Route::get('/relation_ships/activate/{id}',[RelationShipController::class,'activate'])->name('relation_ships.activate');
    Route::resource('relation_ships', RelationShipController::class);

    Route::get('/district/inactive/{id}',[DistrictController::class,'inactive'])->name('district.inactive');
    Route::get('/district/activate/{id}',[DistrictController::class,'activate'])->name('district.activate');
    Route::resource('district', DistrictController::class);

    Route::get('/dsdivision/inactive/{id}',[DSDivisionController::class,'inactive'])->name('dsdivision.inactive');
    Route::get('/dsdivision/activate/{id}',[DSDivisionController::class,'activate'])->name('dsdivision.activate');
    Route::resource('dsdivision', DSDivisionController::class);

    Route::get('/usertype/inactive/{id}',[UsertypeController::class,'inactive'])->name('usertype.inactive');
    Route::get('/usertype/activate/{id}',[UsertypeController::class,'activate'])->name('usertype.activate');
    Route::resource('usertype', UsertypeController::class);

    //modification for viewing only 3 for every users
    Route::get('/persons/actionPendingList',[PersonController::class,'actionPendingList'])->name('persons.action_pending_list');
    Route::get('/persons/actionTakenList',[PersonController::class,'actionTakenList'])->name('persons.action_taken_list');
    

    Route::get('/persons/inactive/{id}',[PersonController::class,'inactive'])->name('persons.inactive');
    Route::get('/persons/activate/{id}',[PersonController::class,'activate'])->name('persons.activate');
    Route::get('/persons/pending',[PersonController::class,'pending'])->name('persons.pending');
    Route::get('/persons/fwdpending',[PersonController::class,'fwdPending'])->name('persons.fwd_pending');
    Route::get('/persons/rejectlist',[PersonController::class,'rejectList'])->name('persons.reject_list');
    Route::get('/persons/approvedlist',[PersonController::class,'approvedList'])->name('persons.approved_list');
    Route::post('/persons/approve/{id}',[PersonController::class,'approve'])->name('persons.approve');
    Route::post('/persons/reject/{id}',[PersonController::class,'reject'])->name('persons.reject');
    Route::post('/persons/fwd/{id}',[PersonController::class,'fwd'])->name('persons.fwd');
    Route::post('/persons/fwdreject/{id}',[PersonController::class,'fwdreject'])->name('persons.fwd_reject');
    Route::post('/persons/draft/{id}',[PersonController::class,'draft'])->name('persons.draft');
    Route::post('/persons/eligible/{id}',[PersonController::class,'eligible'])->name('persons.eligible');
    Route::post('/persons/issue/{id}',[PersonController::class,'issue'])->name('persons.issue');
    Route::resource('persons', PersonController::class);

    Route::get('/cardprints/print/{id}',[CardPrintController::class,'print'])->name('cardprints.print');
    Route::get('/cardprints/close/{id}',[CardPrintController::class,'close'])->name('cardprints.close');
    Route::get('/cardprints/delete/{id}',[CardPrintController::class,'deletePermanent'])->name('cardprints.deletePermanent');
    Route::get('/cardprints/printclose',[CardPrintController::class,'printClose'])->name('cardprints.printclose');
    Route::resource('cardprints', CardPrintController::class);

    Route::get('/carddetails/issue/{id}',[CardPrintController::class,'issue'])->name('carddetails.issue');
    Route::resource('carddetails', CardDetailController::class);

    Route::get('/cardissuepersons/create/{id}',[CardIssuePersonController::class, 'create'])->name('cardissuepersons.create');
    Route::post('/cardissuepersons/{id}',[CardIssuePersonController::class, 'store'])->name('cardissuepersons.store');
    //Route::resource('cardissuepersons', CardIssuePersonController::class);

    Route::get('/permissioncategories/inactive/{id}',[PermissionCategoryController::class,'inactive'])->name('permissioncategories.inactive');
    Route::get('/permissioncategories/activate/{id}',[PermissionCategoryController::class,'activate'])->name('permissioncategories.activate');
    Route::resource('permissioncategories', PermissionCategoryController::class);

    Route::get('/permissions/inactive/{id}',[PermissionController::class,'inactive'])->name('permissions.inactive');
    Route::get('/permissions/activate/{id}',[PermissionController::class,'activate'])->name('permissions.activate');
    Route::resource('permissions', PermissionController::class);

    Route::prefix('persons/{person}')->group(function (){
        Route::resource('noks',NokController::class);
        Route::resource('dependence', DependenceController::class);
    });

    Route::get('/reports/person_profile/',[ReportController::class,'person_profile'])->name('reports.person_profile');
});

Route::get('/ajax/getRanks',[AjaxController::class,'getRanks'])->name('ajax.getRanks');

Route::get('/ajax/getRegementDepartment',[AjaxController::class,'getRegementDepartment'])->name('ajax.getRegementDepartment');

Route::get('/ajax/getDistricts',[AjaxController::class,'getDistricts'])->name('ajax.getDistricts');

Route::get('/ajax/getDSDivisions',[AjaxController::class,'getDSDivisions'])->name('ajax.getDSDivisions');


