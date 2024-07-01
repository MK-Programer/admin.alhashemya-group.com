<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\MissionsAndVisionsController;
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

Auth::routes([
    'register' => false, // Disable registration
    'reset' => false,    // Disable password reset/verification
]);

Route::middleware(['auth', 'active.user'])->group(function () {
    //Dashboard
    Route::get('/', [DashBoardController::class, 'root'])->name('dashboard');

    //User
    Route::get('/user/user-profile', [UsersController::class, 'showUserProfile'])->name('showUserProfile');
    Route::post('/user/update-user-profile', [UsersController::class, 'updateUserProfile'])->name('updateUserProfile');
    Route::post('/user/update-user-password', [UsersController::class, 'updateUserPassword'])->name('updateUserPassword');
    Route::post('/user/update-user-company-id', [UsersController::class, 'updateUserCompanyId'])->name('updateUserCompanyId');

    //Services
    Route::get('/services', [ServicesController::class, 'showServices'])->name('showServices');
    Route::get('/services/get-paginated-services-data', [ServicesController::class, 'getPaginatedServicesData'])->name('getPaginatedServicesData');
    Route::get('/services/create-service', [ServicesController::class, 'showCreateService'])->name('showCreateService');
    Route::post('/services/save-created-service', [ServicesController::class, 'saveCreatedService'])->name('saveCreatedService');
    Route::get('/services/update-service/{id}', [ServicesController::class, 'showServiceToUpdate'])->name('showServiceToUpdate');
    Route::post('/services/save-updated-service', [ServicesController::class, 'saveUpdatedService'])->name('saveUpdatedService');

    //Missions And Visions 
    Route::get('/missions-and-visions', [MissionsAndVisionsController::class, 'showMissionsAndVisions'])->name('showMissionsAndVisions');
    Route::get('/missions-and-visions/get-paginated-missions-and-visions-data', [MissionsAndVisionsController::class, 'getPaginatedMissionsAndVisionsData'])->name('getPaginatedMissionsAndVisionsData');

    //Language Translation
    Route::get('/index/{locale}', [AppController::class, 'lang']);
    Route::get('/lang/datatables_{locale}.json', [AppController::class, 'dataTableLang'])->name('lang.datatables');
});
