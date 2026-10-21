<?php

namespace Tests\Feature\Api;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_articles(): void
    {
        Article::factory()->count(5)->create();

        $this->getJson('/api/articles')
            ->assertOk()
            ->assertJsonCount(5, 'data');
    }

    public function test_can_get_article_by_id(): void
    {
        $article = Article::factory()->create();

        $this->getJson("/api/articles/{$article->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $article->id);
    }

    public function test_can_get_article_by_slug(): void
    {
        $article = Article::factory()->create();

        $this->getJson("/api/articles/slug/{$article->slug}")
            ->assertOk()
            ->assertJsonPath('data.slug', $article->slug);
    }

    public function test_can_search_articles_by_title(): void
    {
        Article::factory()->create([
            'title' => 'Laravel Basics',
        ]);

        Article::factory()->create([
            'title' => 'Python Basics',
        ]);

        $this->getJson('/api/articles?q=Laravel')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Laravel Basics');
    }

    public function test_can_filter_articles_by_author(): void
    {
        $author = Author::factory()->create();
        $otherAuthor = Author::factory()->create();

        Article::factory()->create([
            'author_id' => $author->id,
        ]);

        Article::factory()->create([
            'author_id' => $otherAuthor->id,
        ]);

        $this->getJson("/api/articles?author_id={$author->id}")
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.author.id', $author->id);
    }

    public function test_can_filter_articles_by_category(): void
    {
        $category = Category::factory()->create();
        $otherCategory = Category::factory()->create();

        $article = Article::factory()->create();
        $otherArticle = Article::factory()->create();

        $article->categories()->attach($category->id);
        $otherArticle->categories()->attach($otherCategory->id);

        $this->getJson(
            "/api/articles?category_id={$category->id}"
        )
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $article->id);
    }

    public function test_category_filter_includes_descendants(): void
    {
        $parent = Category::factory()->create();

        $child = Category::factory()->make();
        $child->appendToNode($parent)->save();

        $article = Article::factory()->create();
        $article->categories()->attach($child->id);

        $this->getJson(
            "/api/articles?category_id={$parent->id}"
        )
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $article->id);
    }

    public function test_search_prioritizes_exact_matches(): void
    {
        Article::factory()->create([
            'title' => 'Learning Laravel',
        ]);

        Article::factory()->create([
            'title' => 'Laravel Framework',
        ]);

        $exact = Article::factory()->create([
            'title' => 'Laravel',
        ]);

        $this->getJson('/api/articles?q=Laravel')
            ->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonPath('data.0.id', $exact->id);
    }

    public function test_articles_are_paginated(): void
    {
        Article::factory()->count(25)->create();

        $this->getJson('/api/articles?per_page=10')
            ->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertJsonPath('meta.total', 25);
    }

    public function test_can_sort_articles_by_title(): void
    {
        Article::factory()->create([
            'title' => 'ZZZ Article',
        ]);

        Article::factory()->create([
            'title' => 'AAA Article',
        ]);

        $this->getJson(
            '/api/articles?sort_by=title&sort_dir=asc'
        )
            ->assertOk()
            ->assertJsonPath('data.0.title', 'AAA Article');
    }

    public function test_invalid_per_page_returns_422(): void
    {
        $this->getJson('/api/articles?per_page=10000')
            ->assertUnprocessable();
    }

    public function test_missing_article_returns_404(): void
    {
        $this->getJson('/api/articles/999999')
            ->assertNotFound();
    }
}
