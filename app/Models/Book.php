<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'publisher_id',
        'category_id',
        'title',
        'pages',
        'borrowed',
    ];

    public function scopeFilter($query, array $filters)
    {   
        $query->when($filters['title'] ?? false, fn($query, $title) =>
            $query->where('title', 'LIKE', "%$title%")
        );

        $query->when($filters['borrowed'] ?? false, fn($query, $borrowed) =>
            $query->where('borrowed', (bool) $borrowed)
        );

        $query->when($filters['publisher_name'] ?? false, fn($query, $publisher_name) =>
            $query->whereHas('publisher', fn($query) => (
                $query->where('name', 'LIKE', "%$publisher_name%")
            ))
        );

        $query->when($filters['author_name'] ?? false, fn($query, $author_name) => (
            $query->whereHas('authors', fn($query) => (
                $query->where('name', 'LIKE', "%$author_name%")
            ))
        ));
    }

    /**
     * Get the publisher that owns the book.
     */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    /**
     * Get the category that owns the book.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Authors that belong to the book.
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'book_authors');
    }

    /**
     * Users that borrowed the book.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'borrows');
    }
}
