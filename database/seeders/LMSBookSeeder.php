<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LMSBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        // 1) Identify which books have an active (unreturned) loan
        $keepIds = Book::whereHas('currentLoan')->pluck('id')->all();

        // 2) Delete everything else from `books`
        //    (cascadeOnDelete will remove their reviews, but leaves authors/categories intact)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Book::whereNotIn('id', $keepIds)->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 3) If you want to reseed categories/authors too, do so here or just skip to books:
        //    (we’re assuming you already have categories & authors in place)

        // --- Helpers for new random data ---
        $words = ['Shadows', 'Light', 'Journey', 'Secret', 'Legacy', 'Dream', 'Whisper', 'Echo', 'Flame', 'Storm', 'Promise', 'Gate', 'Mirror', 'Song', 'River', 'Soul', 'Memory', 'Edge', 'Fall', 'Rise'];
        $publishers = ['Penguin Random House', 'HarperCollins', 'Simon & Schuster', 'Macmillan', 'Hachette', 'Scholastic', 'Oxford Press', 'Cambridge Press'];

        $categories = Category::all();
        $authors = Author::all();

        // 4) Seed 50 brand-new books
        for ($i = 1; $i <= 50; $i++) {
            $title = ucfirst($words[array_rand($words)]) . ' ' . ucfirst($words[array_rand($words)]);
            $description = 'A captivating ' . strtolower($words[array_rand($words)]) .
                ' story that explores ' . strtolower($words[array_rand($words)]) .
                ' and ' . strtolower($words[array_rand($words)]) . '.';
            $coverImage = 'https://picsum.photos/seed/book' . time() . $i . '/200/300';
            $author = $authors->random();
            $category = $categories->random();
            $publisher = $publishers[array_rand($publishers)];
            $publicationDate = Carbon::create(
                rand(1950, Carbon::now()->year),
                rand(1, 12),
                rand(1, 28)
            )->toDateString();
            $isbn = str_pad((string) rand(1000000000000, 9999999999999), 13, '0', STR_PAD_LEFT);
            $pageCount = rand(100, 1000);

            Book::create([
                'title' => $title,
                'description' => $description,
                'cover_image' => $coverImage,
                'author_id' => $author->id,
                'publisher' => $publisher,
                'publication_date' => $publicationDate,
                'category_id' => $category->id,
                'isbn' => $isbn,
                'page_count' => $pageCount,
            ]);
        }
    }
}
