<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        // Base query: eager-load author & category
        $query = Book::with(['author', 'category', 'reviews']);

        // Text search
        if ($q = $request->get('q')) {
            $query->where('title', 'like', "%{$q}%");
        }

        // Category filter
        if ($cat = $request->get('category')) {
            $query->where('category_id', $cat);
        }

        // Paginate
        $books = $query
            ->paginate(9)
            ->withQueryString()
            ->through(fn($book) => [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author->name,
                'category' => $book->category->name,
                'description' => Str::limit($book->description, 100), // snippet
                'cover_image' => $book->cover_image,
                'average_rating' => round($book->reviews->avg('rating'), 1) ?: null,
                'is_available' => is_null($book->currentLoan?->returned_at),
            ]);

        // All categories for filter dropdown
        $categories = Category::orderBy('name')->get()->map->only(['id', 'name']);

        return Inertia::render('Books/Index', [
            'books' => $books,
            'categories' => $categories,
            'filters' => $request->only('q', 'category'),
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
    public function show(Book $id)
    {
        //
        // Eager-load relationships
        $id->load(['author', 'category', 'reviews.user']);

        // Shape the data sent to Vue
        $data = [
            'id' => $id->id,
            'title' => $id->title,
            'author' => $id->author->name,
            'description' => $id->description,
            'cover_image' => $id->cover_image,
            'publisher' => $id->publisher,
            'publication_date' => $id->publication_date,
            'category' => $id->category->name,
            'isbn' => $id->isbn,
            'page_count' => $id->page_count,
            'average_rating' => round($id->reviews->avg('rating'), 1) ?: null,
            'is_available' => is_null($id->currentLoan?->returned_at),
            'reviews' => $id->reviews->map(fn($r) => [
                'id' => $r->id,
                'user' => ['name' => $r->user->name],
                'rating' => $r->rating,
                'comment' => $r->comment,
            ])->toArray(),
        ];

        return Inertia::render('Books/Show', [
            'book' => $data,
        ]);
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
