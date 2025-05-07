<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AuthenticatedSessionController;

// Books
Route::get('/books/{id}', [BookController::class, 'show'])
    ->middleware('auth')
    ->name('books.show');
Route::get('/books', [BookController::class, 'index'])
    ->middleware('auth')
    ->name('books.index');

// Protected dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Login / Logout
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Registration
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

// Route::inertia('/', 'Landing')->name('landing');
Route::get('/', function () {
    if (Auth::check()) {
        // If you want to render the Dashboard component in place:
        // return Inertia::render('Dashboard');
        //—or if you'd rather redirect so the URL changes:
        return redirect()->route('dashboard');
    }

    // Guests see the public landing page:
    return Inertia::render('Landing', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('landing');