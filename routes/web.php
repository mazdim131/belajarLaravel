<?php

use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionPackageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $subscriptionPackages = \App\Models\SubscriptionPackage::all();
    return view('home', compact('subscriptionPackages'));
})->name('home');

// Kelompok root yang boleh diaksesnya setelah login versi admin
Route::middleware(['IsLoggedIn'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    // prefix untuk mengelompokkan route admin yang pathnya di awali dengan /admin
    // seluruh route pada kelompok ini akan memiliki nama route di awali dengan admin
    // contoh: admin.dashboard
    Route::middleware(['IsAdmin'])->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/dashboard', function () {
                return view('admin.dashboard');
            })->name('dashboard');

            // menyediakan http method resource route untuk mengelola data kategori buku yang otomatis membuat semua method CRUD (create, read, update, delete) pada bookcategorycontroller
            Route::resource('book-categories', BookCategoryController::class);
            Route::resource('subscription-packages', SubscriptionPackageController::class);
        });
    });
});

// Kelompok route yang boleh diaksesny4a sebelum login
Route::middleware(['IsGuest'])->group(function () {
    Route::get('/register', function () {
        return view('register');
    })->name('register');

    Route::get('/login', function () {
        return view('login');
    })->name('login');

    // path boleh sama tapi http method harus berbeda
    // ini untuk kirim data
    Route::post('/register', [UserController::class, 'register'])->name('register.store')->middleware('throttle:5.1'); // beda karena register udh dipakai diatas
    Route::post('/login', [UserController::class, 'login'])->name('login.store')->middleware('throttle:5.1');
});
