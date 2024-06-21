<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
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

Route::group(['middleware' => ['auth', 'active.user']], function () {
    Route::get('/', [HomeController::class, 'root'])->name('root');

    //User
    Route::get('user-profile', [UserController::class, 'showUserProfile'])->name('showUserProfile');
    Route::post('update-user-profile', [UserController::class, 'updateUserProfile'])->name('updateUserProfile');
    // Route::post('/update-password/{id}', [HomeController::class, 'updatePassword'])->name('updatePassword');

    Route::get('{any}', [HomeController::class, 'index'])->name('index');

    //Language Translation
    Route::get('index/{locale}', [HomeController::class, 'lang']);
});
