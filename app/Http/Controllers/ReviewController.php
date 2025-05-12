<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Book $book, Request $request)
    {
        //
        $gateAuthorization = Gate::inspect('create', Review::class);
        if ($gateAuthorization->denied()) {
            return redirect()->route('books.index')->with('failure', 'Unauthorized.');
        }
        if ($book->reviews()->where('user_id', auth()->user()->id)->exists()) {
            return redirect()->route('dashboard')->with('failure', 'You have already reviewed this book.');
        }

        $data = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
        ]);

        $book->reviews()->create([
            'user_id' => $request->user()->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'],
        ]);

        return redirect()->route('books.index')->with('success', 'Thank you for your review!');
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
    public function update(Book $book, Review $review, Request $request)
    {
        //
        // $this->authorize('update', $review);
        abort_if($review->book_id !== $book->id, 404);
        $gateAuthorization = Gate::inspect('update', $review);
        if ($gateAuthorization->denied()) {
            return redirect()->route('books.index')->with('failure', 'Unauthorized.');
        }
        // Gate::inspect('update', $review);
        $data = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
        ]);

        $review->update($data);

        return redirect()->route('books.index')->with('success', 'Your review was updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book, Review $review)
    {
        //
        abort_if($review->book_id !== $book->id, 404);
        $gateAuthorization = Gate::inspect('delete', $review);
        if ($gateAuthorization->denied()) {
            return redirect()->route('books.index')->with('failure', 'Unauthorized.');
        }
        $review->delete();
        return redirect()->route('books.index')->with('success', 'Your review was deleted.');
    }
}
