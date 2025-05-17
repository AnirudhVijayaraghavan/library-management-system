<?php

namespace App\Models;

use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'due_at',
        'returned_at',
    ];

    protected $casts = [
        'due_at' => 'datetime',
        'borrowed_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function scopeActive(Builder $query)
    {
        return $query
            ->whereNull('returned_at')
            ->where('due_at', '>=', now()->startOfDay());
    }

    /**
     * Only not‐returned loans whose due date has passed.
     */
    public function scopeOverdue(Builder $query)
    {
        return $query
            ->whereNull('returned_at')
            ->where('due_at', '<', now()->startOfDay());
    }
}
