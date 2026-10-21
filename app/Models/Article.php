<?php

namespace App\Models;

use App\Models\Author;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Override;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'excerpt',
        'content',
        'author_id',
        'slug',
    ];

    #[Override]
    protected static function booted()
    {
        static::creating(function(Article $article){
            if (filled($article->slug)) {
                return;
            }

            $name = Str::slug($article->title);
            $article->slug = $name . $article->author;
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}