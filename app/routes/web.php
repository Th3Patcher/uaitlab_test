<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarrantyClaimController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});


Route::middleware('auth')->group(function () {
    /*
                                    |----------|
                                    |  Logout  |
                                    |----------|
    */
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    /*
    |--------------------------------------------------------------------------|
    |                                   CRM
    |--------------------------------------------------------------------------|
    */

    Route::middleware('role:user')->group(function () {

        Route::redirect('/', '/warranty-claims/table');
        Route::redirect('/dashboard', '/warranty-claims/table')->name('dashboard');

        Route::name('warranty-claims.')->prefix('/warranty-claims')->group(function () {
            Route::get('/table', [WarrantyClaimController::class, 'index'])->name('table');
            Route::get('/create', [WarrantyClaimController::class, 'create'])->name('create');
        });

    });


    /*
    |--------------------------------------------------------------------------|
    |                                Admin-panel
    |--------------------------------------------------------------------------|
    */
    Route::middleware(['role:admin'])->name('admin.')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');


        Route::name('profile.')->prefix('/profile')->group(function () {
            Route::get('', [ProfileController::class, 'edit'])->name('edit');
            Route::patch('', [ProfileController::class, 'update'])->name('update');
            Route::delete('', [ProfileController::class, 'destroy'])->name('destroy');
            Route::put('', [PasswordController::class, 'update'])->name('password.update');
        });

        Route::name('users.')->prefix('/users')->group(function () {
            Route::get('', [UserController::class, 'index'])->name('list');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
        });

        Route::name('directory.')->prefix('/directory')->group(function () {
            Route::get('', [DirectoryController::class, 'index'])->name('list');
            Route::get('/show', [DirectoryController::class, 'show'])->name('show');
            Route::patch('/update', [DirectoryController::class, 'update'])->name('update');
            Route::get('/create', [DirectoryController::class, 'create'])->name('create');
            Route::post('/store', [DirectoryController::class, 'store'])->name('store');
        });
    });
});
