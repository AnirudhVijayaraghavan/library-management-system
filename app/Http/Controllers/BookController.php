<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Inertia\Inertia;
use App\Models\Category;
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
        $query = Book::with(['author', 'category']);

        // Text search
        if ($q = $request->get('q')) {
            $query->where('title', 'like', "%{$q}%");
        }

        // Category filter
        if ($cat = $request->get('category')) {
            $query->where('category_id', $cat);
        }

        // Paginate
        $books = $query->paginate(10)
            ->withQueryString()
            ->through(fn($book) => [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author->name,
                'category' => $book->category->name,
                'isAvailable' => is_null($book->currentLoan?->returned_at),
            ]);

        // All categories for filter dropdown
        $categories = Category::orderBy('name')->get()->map->only(['id', 'name']);

        return Inertia::render('Books/Index', [
            'books' => $books,
            'filters' => $request->only('q', 'category'),
            'categories' => $categories,
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
