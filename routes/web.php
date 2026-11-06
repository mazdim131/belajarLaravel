<?php

use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubscriptionPackageBookController;
use App\Http\Controllers\SubscriptionPackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/search-category', [HomeController::class, 'searchCategory'])->name('searchCategory');
// Route::get('/category', [HomeController::class, 'allCategories'])->name('books.category.all');
Route::get('/category/{category:slug}', [HomeController::class, 'byCategory'])->name('books.category');

// route untuk checkout
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');

// Kelompok root yang boleh diakses setelah login
Route::middleware(['IsLoggedIn'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    // route untuk halaman keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('carts');
    Route::post('/cart', [CartController::class, 'store'])->name('carts.store');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('carts.destroy');

    // Route untuk detail subscription package
    Route::get('/resources/views/user/subscription-packages/show/{id}', [SubscriptionPackageController::class, 'show'])->name('subscription-packages.show');

    // Route untuk profile
    Route::get('/profile', [ProfileController::class, 'getProfile'])->name('profile');
    Route::resource('books', BookController::class)->except(['show']);

    // prefix untuk mengelompokkan route admin yang pathnya di awali dengan /admin
    // seluruh route pada kelompok ini akan memiliki nama route di awali dengan admin
    // contoh: admin.dashboard
    Route::middleware(['IsAdmin'])->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/dashboard', function () {
                return view('admin.dashboard');
            })->name('dashboard');

            Route::get('book-categories/export', [BookCategoryController::class, 'export'])->name('book-categories.export');
            Route::get('subscription-packages/export', [SubscriptionPackageController::class, 'export'])->name('subscription-packages.export');

            Route::resource('subscription-packages', SubscriptionPackageController::class);

            Route::get('subscription-packages/{id}/books', [SubscriptionPackageBookController::class, 'show'])->name('subscription-packages.books');
            Route::post('subscription-packages/{id}/books', [SubscriptionPackageBookController::class, 'store'])->name('subscription-packages.books.store');

            // Route untuk detail subscription package
            Route::get('/user/show{id}', [SubscriptionPackageController::class, 'show'])->name('subscription-packages.detail');

            // menyediakan http method resource route untuk mengelola data kategori buku
            Route::resource('book-categories', BookCategoryController::class);
            Route::get('books/export', [BookController::class, 'export'])->name('books.export');
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
