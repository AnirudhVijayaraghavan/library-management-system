<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LMSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        // 1. Seed User
        $users = [
            [
                'name' => 'Anirudh Vijayaraghavan',
                'email' => 'aniroxta@gmail.com',
                'password' => 'Adadad@131313',
                'role' => 'customer',
            ],
            [
                'name' => 'Librarian1',
                'email' => 'anirudh1997@hotmail.com',
                'password' => 'Adadad@131313',
                'role' => 'librarian',
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate($user);
        }

        // 1. Seed Categories
        $categoryNames = [
            'Fiction',
            'Non-Fiction',
            'Science',
            'Biography',
            'History',
            'Fantasy',
            'Mystery',
            'Romance',
            'Thriller',
            'Self-Help',
        ];
        $categories = [];
        foreach ($categoryNames as $name) {
            $categories[] = Category::firstOrCreate(['name' => $name]);
        }

        // 2. Seed Authors
        $authorNames = [
            'Jane Austen',
            'Mark Twain',
            'George Orwell',
            'Virginia Woolf',
            'Ernest Hemingway',
            'Agatha Christie',
            'J.K. Rowling',
            'Stephen King',
            'Isabel Allende',
            'Haruki Murakami',
            'Chinua Achebe',
            'Gabriel García Márquez',
            'Fyodor Dostoevsky',
            'Leo Tolstoy',
            'J.R.R. Tolkien',
            'Harper Lee',
            'Charles Dickens',
            'Oscar Wilde',
            'Mary Shelley',
        ];
        $authors = [];
        foreach ($authorNames as $name) {
            $authors[] = Author::firstOrCreate(['name' => $name]);
        }

        // Word list for generating titles and descriptions
        $words = [
            'Shadows',
            'Light',
            'Journey',
            'Secret',
            'Legacy',
            'Dream',
            'Whisper',
            'Echo',
            'Flame',
            'Storm',
            'Promise',
            'Gate',
            'Mirror',
            'Song',
            'River',
            'Soul',
            'Memory',
            'Edge',
            'Fall',
            'Rise'
        ];

        // Publisher names
        $publishers = [
            'Penguin Random House',
            'HarperCollins',
            'Simon & Schuster',
            'Macmillan',
            'Hachette',
            'Scholastic',
            'Oxford Press',
            'Cambridge Press',
        ];

        // 3. Seed Books
        for ($i = 1; $i <= 50; $i++) {
            $title = ucfirst($words[array_rand($words)]) . ' ' . ucfirst($words[array_rand($words)]);
            $description = 'A captivating ' . strtolower($words[array_rand($words)]) .
                ' story that explores ' . strtolower($words[array_rand($words)]) .
                ' and ' . strtolower($words[array_rand($words)]) . '.';
            $coverImage = 'https://picsum.photos/seed/book' . $i . '/200/300';
            $author = $authors[array_rand($authors)];
            $category = $categories[array_rand($categories)];
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
