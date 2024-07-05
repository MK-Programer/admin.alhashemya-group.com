<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\MissionsAndVisionsController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\PartnersOrClientsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductsController;

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

    
    //Partners Or Clients
    Route::get('partners', [PartnersOrClientsController::class, 'showPartnersOrClients'])->name('showPartners');
    Route::get('clients', [PartnersOrClientsController::class, 'showPartnersOrClients'])->name('showClients');
    Route::prefix('partners-or-clients')->group(function () {
        Route::get('get-paginated-partners-or-clients-data', [PartnersOrClientsController::class, 'getPaginatedPartnersOrClientsData'])->name('getPaginatedPartnersOrClientsData');    
        Route::get('create-new-partner-or-client/{type}', [PartnersOrClientsController::class, 'showCreatePartnerOrClient'])->name('showCreatePartnerOrClient');    
        Route::post('save-created-partner-or-client', [PartnersOrClientsController::class, 'saveCreatedPartnerOrClient'])->name('saveCreatedPartnerOrClient');    
        Route::get('update-partner-or-client/{id}/{type}', [PartnersOrClientsController::class, 'showPartnerOrClientToUpdate'])->name('showPartnerOrClientToUpdate');    
        Route::post('save-updated-partner-or-client', [PartnersOrClientsController::class, 'saveUpdatedPartnerOrClient'])->name('saveUpdatedPartnerOrClient');
    });

    //home
    Route::prefix('home')->group(function () {
        Route::get('/', [AdminController::class, 'showHome'])->name('showHome');
        Route::get('get-paginated-home-data', [AdminController::class, 'getPaginatedHomeData'])->name('getPaginatedHomeData');
        Route::get('create-home', [AdminController::class, 'showCreateHome'])->name('showCreateHome');
        Route::post('home-update', [AdminController::class, 'saveCreatedHome'])->name('saveCreatedHome');
        Route::get('update-home/{id}', [AdminController::class, 'showHomeToUpdate'])->name('showHomeToUpdate');
        Route::post('save-updated-home', [AdminController::class, 'saveUpdatedHome'])->name('saveUpdatedHome');
    });
     
 
    //companies
    Route::prefix('companies')->group(function () {
        Route::get('/', [CompanyController::class, 'showCompany'])->name('showCompany');
        Route::get('get-paginated-companies-data', [CompanyController::class, 'getPaginatedCompanyData'])->name('getPaginatedCompanyData');
        Route::get('create-company', [CompanyController::class, 'showCreateCompany'])->name('showCreateCompany');
        Route::post('save-created-company', [CompanyController::class, 'saveCreatedCompany'])->name('saveCreatedCompany');
        Route::get('update-company/{id}', [CompanyController::class, 'showCompanyToUpdate'])->name('showCompanyToUpdate');
        Route::post('save-updated-company', [CompanyController::class, 'saveUpdatedCompany'])->name('saveUpdatedCompany');
    });
     
 
     //AboutUs
    Route::prefix('about-us')->group(function () {
        Route::get('/', [AboutUsController::class, 'showAboutUs'])->name('showAboutUs');
        Route::get('get-paginated-about-us-data', [AboutUsController::class, 'getPaginatedAboutUsData'])->name('getPaginatedAboutUsData');
        Route::get('create-about-us', [AboutUsController::class, 'showCreateAboutUs'])->name('showCreateAboutUs');
        Route::post('save-created-about-us', [AboutUsController::class, 'saveCreatedAboutUs'])->name('saveCreatedAboutUs');
        Route::get('update-about-us/{id}', [AboutUsController::class, 'showAboutUsToUpdate'])->name('showAboutUsToUpdate');
        Route::post('save-updated-about-us', [AboutUsController::class, 'saveUpdatedAboutUs'])->name('saveUpdatedAboutUs');
    });
     
 
    //categories
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'showCategories'])->name('showCategories');
        Route::get('get-paginated-categories-data', [CategoryController::class, 'getPaginatedCategoriesData'])->name('getPaginatedCategoriesData');
        Route::get('create-category', [CategoryController::class, 'showCreateCategory'])->name('showCreateCategory');
        Route::post('save-created-category', [CategoryController::class, 'saveCreatedCategory'])->name('saveCreatedCategory');
        Route::get('update-category/{id}', [CategoryController::class, 'showCategoryToUpdate'])->name('showCategoryToUpdate');
        Route::post('save-updated-category', [CategoryController::class, 'saveUpdatedCategory'])->name('saveUpdatedCategory');
    });
     

    //Products
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductsController::class, 'showProducts'])->name('showProducts');
        Route::get('get-paginated-products-data', [ProductsController::class, 'getPaginatedProductsData'])->name('getPaginatedProductsData');
        Route::get('create-product', [ProductsController::class, 'showCreateProduct'])->name('showCreateProduct');
        Route::post('save-created-product', [ProductsController::class, 'saveCreatedProduct'])->name('saveCreatedProduct');
        Route::get('update-product/{id}', [ProductsController::class, 'showProductToUpdate'])->name('showProductToUpdate');
        Route::post('save-updated-product', [ProductsController::class, 'saveUpdatedProduct'])->name('saveUpdatedProduct');
    });
     
 


    //Language Translation
    Route::get('/index/{locale}', [AppController::class, 'lang']);
    Route::get('/lang/datatables_{locale}.json', [AppController::class, 'dataTableLang'])->name('lang.datatables');
});
