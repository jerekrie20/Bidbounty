<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\UserController;
use App\Livewire\AuctionItems;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Volt::route('/auction', 'auction.auction-list')->name('auction.list');

Route::get('/auction/{id}',AuctionItems::class)->name('auction.item');

//user middleware group
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');
    Route::get('account',[UserController::class, 'account'])->name('account');
    Route::get('/userLots',[LotController::class, 'index'])->name('lots');
    Route::get('/listings',[ItemController::class, 'index'])->name('listings');
//    Route::put('user/{user}/account',[UserController::class, 'updateAccount'])->name('user.account');
});
