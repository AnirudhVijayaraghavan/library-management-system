<?php

namespace App\Models;

use App\Models\Loan;
use App\Models\Author;
use App\Models\Review;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'author_id',
        'publisher',
        'publication_date',
        'category_id',
        'isbn',
        'page_count',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function currentLoan()
    {
        return $this->hasOne(Loan::class)->whereNull('returned_at');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
