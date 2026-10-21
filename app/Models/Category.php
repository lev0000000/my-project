<?php

namespace App\Models;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = [
        'title',
        'image',
        'description',
        'slug',
        'parent_id',
    ];

    protected static function booted(): void{
        static::creating(function (Category $category) {
            if (filled($category->slug)) {
                return;
            }

            $base = Str::slug($category->title) ?: 'category';
            $slug = $base;
            $counter = 2;

            while (static::where('slug', $slug)->exists()) {
                $slug = "{$base}" . $counter++;
            }

            $category->slug = $slug;
        });
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}