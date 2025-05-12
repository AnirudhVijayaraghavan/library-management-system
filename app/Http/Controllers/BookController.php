<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Inertia\Inertia;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function adminIndex(Request $request)
    {
        if (Gate::denies('isLibrarian')) {
            return redirect(route('librarian.page'))->with('failure', 'Unauthorized.');
        }
        $books = Book::with(['author', 'category', 'currentLoan'])
            ->orderBy('updated_at', 'desc')
            ->paginate(15)
            ->withQueryString()
            ->through(fn($book) => [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author->name,
                'category' => $book->category->name,
                'is_available' => is_null($book->currentLoan),
                'due_at' => optional($book->currentLoan)->due_at?->toDateString(),
                'created_at' => $book->created_at->toDateString(),
                'loan_id' => optional($book->currentLoan)->id,
            ]);

        return Inertia::render('Librarian/Books/Index', [
            'books' => $books,
        ]);
    }

    public function index(Request $request)
    {

        $q = $request->get('q');
        $cat = $request->get('category');
        $auth = $request->get('author');
        $avail = $request->get('availability');
        $sort = $request->get('sort', 'title');
        $direction = $request->get('direction', 'asc');

        if ($q) {

            $paginator = Book::search($q)
                ->paginate(9)
                ->withQueryString();

            $paginator->getCollection()->load(['author', 'category', 'reviews', 'currentLoan']);
        } else {
            $query = Book::with(['author', 'category', 'reviews', 'currentLoan']);

            if ($cat)
                $query->where('category_id', $cat);
            if ($auth)
                $query->where('author_id', $auth);
            if ($avail !== null && $avail !== '') {
                $avail == 1
                    ? $query->whereDoesntHave('currentLoan')
                    : $query->whereHas('currentLoan');
            }

            switch ($sort) {
                case 'title':
                    $query->orderBy('title', $direction);
                    break;
                case 'author':
                    $query->join('authors', 'books.author_id', '=', 'authors.id')
                        ->orderBy('authors.name', $direction)
                        ->select('books.*');
                    break;
                case 'availability':
                    $query->leftJoin('loans', 'books.id', '=', 'loans.book_id')
                        ->orderByRaw(
                            $direction === 'asc'
                            ? 'CASE WHEN loans.returned_at IS NULL THEN 1 ELSE 0 END DESC'
                            : 'CASE WHEN loans.returned_at IS NULL THEN 0 ELSE 1 END DESC'
                        )
                        ->select('books.*');
                    break;
            }

            $paginator = $query->paginate(9)->withQueryString();
        }

        $books = $paginator->through(fn($book) => [
            'id' => $book->id,
            'title' => $book->title,
            'author' => $book->author->name,
            'category' => $book->category->name,
            'description' => Str::limit($book->description, 100),
            'cover_image' => $book->cover_image,
            'average_rating' => round($book->reviews->avg('rating'), 1) ?: null,
            'is_available' => is_null($book->currentLoan),
        ]);

        $categories = Category::orderBy('name')->get()->map->only(['id', 'name']);
        $authors = Author::orderBy('name')->get()->map->only(['id', 'name']);

        return Inertia::render('Books/Index', [
            'books' => $books,
            'categories' => $categories,
            'authors' => $authors,
            'filters' => $request->only('q', 'category', 'author', 'availability', 'sort', 'direction'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        if (Gate::denies('isLibrarian')) {
            return redirect(route('librarian.page'))->with('failure', 'Unauthorized.');
        }
        return Inertia::render('Librarian/Books/Create', [
            'authors' => Author::orderBy('name')->get(['id', 'name']),
            'categories' => Category::orderBy('name')->get(['id', 'name']),
        ]);
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
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|url',
            'publisher' => 'nullable|string|max:255',
            'publication_date' => 'nullable|date',
            'isbn' => [
                'nullable',
                'string',
                'size:13',
                'unique:books,isbn',
            ],
            'page_count' => 'nullable|integer|min:1',
        ]);

        Book::create($data);

        return redirect()->route('librarian.page')
            ->with('success', 'Book created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $id)
    {
        //
        $id->load(['author', 'category', 'reviews.user']);

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
            'is_available' => is_null($id->currentLoan),
            'due_at' => optional($id->currentLoan)->due_at?->toDateString(),
            'reviews' => $id->reviews->map(fn($r) => [
                'id' => $r->id,
                'user' => [
                    'id' => $r->user->id,
                    'name' => $r->user->name,
                ],
                'rating' => $r->rating,
                'comment' => $r->comment,
                'created_at' => $r->created_at->format('M j, Y'),
            ])->toArray(),
        ];

        return Inertia::render('Books/Show', [
            'book' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
        if (Gate::denies('isLibrarian')) {
            return redirect(route('librarian.page'))->with('failure', 'Unauthorized.');
        }
        return Inertia::render('Librarian/Books/Edit', [
            'book' => $book,
            'authors' => Author::orderBy('name')->get(['id', 'name']),
            'categories' => Category::orderBy('name')->get(['id', 'name']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
        if (Gate::denies('isLibrarian')) {
            return redirect(route('librarian.page'))->with('failure', 'Unauthorized.');
        }
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|url',
            'publisher' => 'nullable|string|max:255',
            'publication_date' => 'nullable|date',
            'isbn' => [
                'nullable',
                'string',
                'size:13',
                Rule::unique('books', 'isbn')->ignore($book->id),
            ],
            'page_count' => 'nullable|integer|min:1',
        ]);

        $book->update($data);

        return redirect()->route('librarian.page')
            ->with('success', 'Book updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
        if (Gate::denies('isLibrarian')) {
            return redirect(route('librarian.page'))->with('failure', 'Unauthorized.');
        }
        $book->delete();

        return redirect()->route('librarian.page')
            ->with('success', 'Book removed.');
        ;
    }
}
