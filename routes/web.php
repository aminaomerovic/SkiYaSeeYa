<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    return redirect()->route('customer.browse');
});

// Kontakt stranica
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {
    Route::get('/change-password', [LoginController::class, 'showChangePasswordForm'])->name('change-password');
    Route::post('/change-password', [LoginController::class, 'changePassword'])->name('update-password');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/approve-user/{id}', [AdminController::class, 'approveUser'])->name('approve-user');
    Route::post('/admin/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('delete-user');
Route::get('/announcements', [AdminController::class, 'announcements'])->name('announcements');
    Route::get('/announcements/create', [AdminController::class, 'createAnnouncement'])->name('create-announcement');
    Route::post('/announcements', [AdminController::class, 'storeAnnouncement'])->name('store-announcement');
    Route::delete('/announcements/{id}', [AdminController::class, 'deleteAnnouncement'])->name('delete-announcement');
});


Route::prefix('provider')->name('provider.')->group(function () {
    Route::get('/dashboard', [ProviderController::class, 'dashboard'])->name('dashboard');
    Route::get('/equipment/create', [ProviderController::class, 'createEquipment'])->name('create-equipment');
    Route::post('/equipment', [ProviderController::class, 'storeEquipment'])->name('store-equipment');
    Route::get('/equipment/{id}/edit', [ProviderController::class, 'editEquipment'])->name('edit-equipment');
    Route::put('/equipment/{id}', [ProviderController::class, 'updateEquipment'])->name('update-equipment');
    Route::delete('/equipment/{id}', [ProviderController::class, 'deleteEquipment'])->name('delete-equipment');
    Route::get('/reservations', [ProviderController::class, 'reservations'])->name('reservations');
    Route::get('/reviews', [ProviderController::class, 'reviews'])->name('reviews');
    Route::post('/reservations/{id}/complete', [ProviderController::class, 'completeReservation'])
        ->name('complete-reservation');
});

Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('/browse', [CustomerController::class, 'browseEquipment'])->name('browse');
    Route::get('/equipment/{id}', [CustomerController::class, 'showEquipment'])->name('equipment-detail');
    
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::get('/equipment/{id}/reserve', [CustomerController::class, 'reserveEquipment'])->name('reserve-equipment');
        Route::post('/equipment/{id}/reserve', [CustomerController::class, 'storeReservation'])->name('store-reservation');
        Route::get('/reservation/{id}/review', [CustomerController::class, 'showReviewForm'])->name('review-form');
        Route::post('/reservation/{id}/review', [CustomerController::class, 'storeReview'])->name('store-review');
    });
});