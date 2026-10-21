<?php

namespace App\Models;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'last_name',
        'avatar',
        'birth_year',
        'biography',
        'slug',
    ];

    protected static function booted(): void
    {
        static::creating(function (Author $author) {
            if (filled($author->slug)) {
                return;
            }

            $baseSlug = Str::slug($author->full_name);
            $slug = $baseSlug;
            $counter = 2;

            while (static::where('slug', $slug)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }

            $author->slug = $slug;
        });
    }


    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
