<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if (Gate::denies('isLibrarian')) {
            return redirect(route('librarian.page'))->with('failure', 'Unauthorized.');
        }
        $authors = Author::orderBy('name')->get();
        return Inertia::render('Librarian/Authors/Index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return Inertia::render('Librarian/Authors/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        if (Gate::denies('isLibrarian')) {
            return redirect(route('librarian.page'))->with('failure', 'Unauthorized.');
        }
        $request->validate(['name' => 'required|string|unique:authors,name']);
        Author::create(['name' => $request->name]);
        return redirect()->route('authors.index')
            ->with('success', 'Author added.');
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
