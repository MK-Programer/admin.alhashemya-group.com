<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
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
    Route::get('/', [HomeController::class, 'root'])->name('root');

    //User
    Route::get('user-profile', [UserController::class, 'showUserProfile'])->name('showUserProfile');
    Route::post('update-user-profile', [UserController::class, 'updateUserProfile'])->name('updateUserProfile');
    Route::post('update-user-password', [UserController::class, 'updateUserPassword'])->name('updateUserPassword');

    //Services
    Route::get('services', [ServiceController::class, 'showServices'])->name('showServices');
    Route::post('update-services', [ServiceController::class, 'updateServices'])->name('updateServices');

    Route::get('get-current-language', [HomeController::class, 'getCurrentLang'])->name('getCurrentLang');

    Route::get('{any}', [HomeController::class, 'index'])->name('index');

    //Language Translation
    Route::get('index/{locale}', [HomeController::class, 'lang']);
});
