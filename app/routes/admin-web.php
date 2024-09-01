<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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
    Route::get('login', [AdminController::class, 'login'])->name('login');
    Route::post('login/store', [AdminController::class, 'store']);
});

Route::middleware('admin.auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard')->middleware('verified');

    Route::post('logout', [AdminController::class, 'destroy'])->name('logout');

    Route::name('profile.')->prefix('/profile')->group(function () {
        Route::get('', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('', [ProfileController::class, 'update'])->name('update');
        Route::delete('', [ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::name('users.')->prefix('/users')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('list');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
    });
    Route::name('directory.')->prefix('/directory')->group(function () {
        Route::get('', [DirectoryController::class, 'index'])->name('list');
        //Route::get('/directory/{directory}', [DirectoryController::class, 'show'])->name('show');
        Route::get('/create', [DirectoryController::class, 'create'])->name('create');
        Route::post('/store', [DirectoryController::class, 'store'])->name('store');
    });
});
