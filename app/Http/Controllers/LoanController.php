<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
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
        // only customers can check out
        if (!$request->user()->isCustomer()) {
            abort(403);
        }

        // already on loan?
        if ($book->currentLoan) {
            return back()->with('failure', 'This book is not available.');
        }

        $loan = Loan::create([
            'book_id' => $book->id,
            'user_id' => auth()->user()->id,
            'borrowed_at' => now(),
            'due_at' => now()->addDays(5),
        ]);

        return back()->with('success', "Checked out until {$loan->due_at->toDateString()}");
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
    public function edit(Book $book, Request $request)
    {
        //
        if (!$request->user()->isLibrarian()) {
            return back()->with('failure', 'Unauthorized.');
        }

        $loan = $book->currentLoan;
        if (!$loan) {
            return back()->with('failure', 'Book is already in the library.');
        }

        $loan->update(['returned_at' => now()]);

        return back()->with('success', 'Book marked as returned.');
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
