<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Inertia\Inertia;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $loans = Loan::with(['book', 'user'])
            ->whereNull('returned_at')
            ->orderBy('due_at')
            ->get()
            ->map(fn($loan) => [
                'id' => $loan->id,
                'book_title' => $loan->book->title,
                'user_name' => $loan->user->name,
                'borrowed_at' => $loan->borrowed_at->toDateString(),
                'due_at' => $loan->due_at->toDateString(),
            ]);

        return Inertia::render('Librarian/Loans/Index', compact('loans'));
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

        return back()->with(
            'success',
            "Checked out until {$loan->due_at->toDateString()}"
        );
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
    public function edit(Loan $loan, Request $request)
    {
        //

        return redirect()->route('librarian.loan.index')->with('success', 'Book marked as returned.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        //
        $loan->update(['returned_at' => now()]);

        return redirect()->route('librarian.page')->with('success', 'Book marked as returned.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
