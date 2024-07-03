<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\MissionsAndVisionsController;
use App\Http\Controllers\MessagesController;
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
    Route::prefix('user')->group(function () {
        Route::get('user-profile', [UsersController::class, 'showUserProfile'])->name('showUserProfile');
        Route::post('update-user-profile', [UsersController::class, 'updateUserProfile'])->name('updateUserProfile');
        Route::post('update-user-password', [UsersController::class, 'updateUserPassword'])->name('updateUserPassword');
        Route::post('update-user-company-id', [UsersController::class, 'updateUserCompanyId'])->name('updateUserCompanyId');
    });
    
    //Services
    Route::prefix('services')->group(function () {
        Route::get('/', [ServicesController::class, 'showServices'])->name('showServices');
        Route::get('get-paginated-services-data', [ServicesController::class, 'getPaginatedServicesData'])->name('getPaginatedServicesData');
        Route::get('create-service', [ServicesController::class, 'showCreateService'])->name('showCreateService');
        Route::post('save-created-service', [ServicesController::class, 'saveCreatedService'])->name('saveCreatedService');
        Route::get('update-service/{id}', [ServicesController::class, 'showServiceToUpdate'])->name('showServiceToUpdate');
        Route::post('save-updated-service', [ServicesController::class, 'saveUpdatedService'])->name('saveUpdatedService');
    });
    
    //Missions And Visions 
    Route::prefix('missions-and-visions')->group(function () {
        Route::get('/', [MissionsAndVisionsController::class, 'showMissionsAndVisions'])->name('showMissionsAndVisions');
        Route::get('get-paginated-missions-and-visions-data', [MissionsAndVisionsController::class, 'getPaginatedMissionsAndVisionsData'])->name('getPaginatedMissionsAndVisionsData');
        Route::get('ru-mission-and-vision-details/{id}/{action}', [MissionsAndVisionsController::class, 'showRUMissionAndVision'])->name('showRUMissionAndVision');
        Route::get('create-new-mission-and-vision', [MissionsAndVisionsController::class, 'showCreateMissionAndVision'])->name('showCreateMissionAndVision');
        Route::post('save-created-mission-and-vision', [MissionsAndVisionsController::class, 'saveCreatedMissionAndVision'])->name('saveCreatedMissionAndVision');
        Route::post('save-updated-mission-and-vision', [MissionsAndVisionsController::class, 'saveUpdatedMissionAndVision'])->name('saveUpdatedMissionAndVision');
    });

    //Messages
    Route::prefix('messages')->group(function () {
        Route::get('/', [MessagesController::class, 'showMessages'])->name('showMessages');
        Route::get('get-paginated-messages-data', [MessagesController::class, 'getPaginatedMessagesData'])->name('getPaginatedMessagesData');    
        Route::post('change-message-reviewed-status', [MessagesController::class, 'changeMessageReviewedStatus'])->name('changeMessageReviewedStatus');    
        Route::get('message-details/{id}', [MessagesController::class, 'messageDetails'])->name('messageDetails');    
    });

    //Language Translation
    Route::get('/index/{locale}', [AppController::class, 'lang']);
    Route::get('/lang/datatables_{locale}.json', [AppController::class, 'dataTableLang'])->name('lang.datatables');
});
