<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryIds = Category::pluck('id');

        Article::factory(5000)
            ->create()
            ->each(function (Article $article) use ($categoryIds) {
                $categories = $categoryIds
                    ->random(rand(1, 3))
                    ->all();
                $article->categories()->attach($categories);
            });
    }
}
