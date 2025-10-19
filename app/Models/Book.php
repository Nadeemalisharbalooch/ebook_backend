<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Book extends Model
{
    use SoftDeletes;
    //

    protected $fillable = [
        'user_id',
        'sub_category_id',
        'category_id',
        'title',
        'author',
        'slug',
        'description',
        'price',
        'discount_price',
        'cover_image',
        'images',
        'language',
        'isbn',
        'edition',
        'pages',
        'dimensions',
        'view_count',
        'type',
        'status',
        'stock_quantity',
        'is_active',
        'currency',
        'format',
        'tags',
        'published_at',
        'is_featured',


    ];

    protected $casts = [
        'images' => 'array',
    ];



    // App\Models\Book.php
public function subCategory()
{
    return $this->belongsTo(SubCategory::class, 'sub_category_id');
}

// App\Models\Book.php
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($book) {
            if (empty($book->slug)) {
                $book->slug = static::generateSlug($book->title);
            }
        });

        static::updating(function ($book) {
            if (empty($book->slug)) {
                $book->slug = static::generateSlug($book->title);
            }
        });
    }

    protected static function generateSlug($title)
    {
        $slug = Str::slug($title);
        $count = static::where('slug', 'like', "{$slug}%")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }
}
