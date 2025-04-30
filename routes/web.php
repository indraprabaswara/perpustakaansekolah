<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'showlogin'])->name('login');
Route::post('/', [Authcontroller::class, 'login']);
Route::get('/register', [Authcontroller::class, 'showregister'])->name('register');
Route::post('/register', [Authcontroller::class, 'register']);
Route::post('/logout', [Authcontroller::class, 'logout'])->name('logout');

Route::middleware(['auth', 'UserAkses:admin'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('books', BookController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('users', UserController::class);
});

Route::middleware(['auth', 'UserAkses:member'])->prefix('member')->name('member.')->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('borrow', BorrowController::class);
    Route::resource('return', ReturnController::class);
 

});
