<?php

use App\Models\Book;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AuthenticatedSessionController;


// Profile routes
Route::get('/profile', [UserProfileController::class, 'edit'])
    ->middleware('auth')
    ->name('profile.edit');
Route::put('/profile', [UserProfileController::class, 'update'])
    ->middleware('auth')
    ->name('profile.update');
Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])
    ->middleware('auth')
    ->name('profile.password');

// Librarian routes
Route::middleware(['auth', 'isLibrarian'])->group(function () {
    // Show Librarian Page
    Route::get('/librarians/books', [BookController::class, 'adminIndex'])
        ->name('librarian.page');
    // Books (existing) 
    // Show the form to create a book
    Route::get('/librarians/books/create', [BookController::class, 'create'])
        ->name('librarian.create');
    // Persist a new book
    Route::post('/librarians/books/store', [BookController::class, 'store'])
        ->name('librarian.store');
    // Show the form to edit
    Route::get('/librarians/books/{book}/edit', [BookController::class, 'edit'])
        ->name('librarian.edit');
    // Update an existing
    Route::put('/librarians/books/{book}', [BookController::class, 'update'])
        ->name('librarian.update');
    // Delete a book
    Route::delete('/librarians/books/{book}', [BookController::class, 'destroy'])
        ->name('librarian.destroy');


    // Loans 
    Route::get('/librarians/loans', [LoanController::class, 'index'])
        ->name('librarian.loan.index');
    Route::put('/librarians/loans/{loan}/return', [LoanController::class, 'update'])
        ->name('librarian.return');

    // Categories 
    Route::get('/librarians/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/librarians/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/librarians/categories', [CategoryController::class, 'store'])->name('categories.store');

    // Authors
    Route::get('/librarians/authors', [AuthorController::class, 'index'])->name('authors.index');
    Route::get('/librarians/authors/create', [AuthorController::class, 'create'])->name('authors.create');
    Route::post('/librarians/authors', [AuthorController::class, 'store'])->name('authors.store');
});

// Books
Route::get('/books/{id}', [BookController::class, 'show'])
    ->middleware('auth')
    ->name('books.show');
Route::get('/books', [BookController::class, 'index'])
    ->middleware('auth')
    ->name('books.index');
Route::post('/books/{book}/checkout', [LoanController::class, 'store'])
    ->middleware('auth')
    ->name('books.checkout');
Route::post(
    '/books/{book}/reviews',
    [ReviewController::class, 'store']
)->middleware('auth')->name('books.reviews.store');
Route::put(
    '/books/{book}/reviews/{review}',
    [ReviewController::class, 'update']
)->middleware('auth')->name('books.reviews.update');
// (If you also want delete:)
Route::delete(
    '/books/{book}/reviews/{review}',
    [ReviewController::class, 'destroy']
)->middleware('auth')->name('books.reviews.destroy');

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
        return redirect()->route('dashboard');
    }

    $featuredBooks = Book::latest()
        ->take(4)
        ->with(['author', 'reviews'])
        ->get()
        ->map(fn($book) => [
            'id' => $book->id,
            'title' => $book->title,
            'author' => $book->author->name,
            'cover_image' => $book->cover_image,
            'average_rating' => round($book->reviews->avg('rating'), 1) ?: null,
            'is_available' => is_null($book->currentLoan),
        ]);

    return Inertia::render('Landing', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'featuredBooks' => $featuredBooks,
    ]);
})->name('landing');