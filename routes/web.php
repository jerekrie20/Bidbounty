<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

//user middleware group

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');
    Route::get('account',[UserController::class, 'account'])->name('account');
    Route::get('/userLots',[LotController::class, 'index'])->name('lots');
//    Route::put('user/{user}/account',[UserController::class, 'updateAccount'])->name('user.account');



    Route::get('categories', function () {
        return view('categories');
    })->name('categories');

    Route::get('products', function () {
        return view('products');
    })->name('products');

    Route::get('orders', function () {
        return view('orders');
    })->name('orders');

    Route::get('users', function () {
        return view('users');
    })->name('users');

    Route::get('settings', function () {
        return view('settings');
    })->name('settings');
});
