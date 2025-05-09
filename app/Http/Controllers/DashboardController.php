<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = auth()->user();

        // Universal stats
        $totalBooks = Book::count();
        $borrowedBooks = Loan::whereNull('returned_at')
            ->when($user->role === 'customer', fn($q) => $q->where('user_id', $user->id))
            ->count();

        // Featured books with avg rating
        $featured = Book::with(['author', 'reviews'])
            ->inRandomOrder()
            ->limit(6)
            ->get()
            ->map(fn($book) => [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author->name,
                'description' => $book->description,
                'cover_image' => $book->cover_image,
                'average_rating' => round($book->reviews->avg('rating'), 1) ?: null,
                'is_available' => is_null($book->currentLoan),
            ]);

        return Inertia::render('Dashboard', [
            'user' => $user,
            'stats' => [
                'totalBooks' => $totalBooks,
                'borrowedBooks' => $borrowedBooks,
                'role' => $user->role,
            ],
            'featuredBooks' => $featured,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
