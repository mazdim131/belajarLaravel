<?php

use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubscriptionPackageBookController;
use App\Http\Controllers\SubscriptionPackageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/search-category', [HomeController::class, 'searchCategory'])->name('searchCategory');
// Route::get('/category', [HomeController::class, 'allCategories'])->name('books.category.all');
Route::get('/category/{category:slug}', [HomeController::class, 'byCategory'])->name('books.category');

// Kelompok root yang boleh diakses setelah login versi admin
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

            // junction table
            Route::get('subscription-packages/{id}/books', [SubscriptionPackageBookController::class, 'show'])->name('subscription-packages.books');
            Route::post('subscription-packages/books', [SubscriptionPackageBookController::class, 'store'])->name('subscription-packages.books.store');

            // menyediakan http method resource route untuk mengelola data kategori buku
            // yang otomatis membuat semua method CRUD (create, read, update, delete)
            Route::resource('book-categories', BookCategoryController::class);
            Route::resource('subscription-packages', SubscriptionPackageController::class);
            Route::resource('books', BookController::class);
        });
    });
});

// Kelompok route yang boleh diakses sebelum login
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
