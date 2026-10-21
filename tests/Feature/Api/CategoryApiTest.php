<?php

namespace Tests\Feature\Api;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_categories(): void
    {
        Category::factory()->count(5)->create();

        $this->getJson('/api/categories')
            ->assertOk()
            ->assertJsonCount(5, 'data');
    }

    public function test_can_get_category_by_id(): void
    {
        $category = Category::factory()->create();

        $this->getJson("/api/categories/{$category->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $category->id);
    }

    public function test_can_get_category_by_slug(): void
    {
        $category = Category::factory()->create();

        $this->getJson("/api/categories/slug/{$category->slug}")
            ->assertOk()
            ->assertJsonPath('data.slug', $category->slug);
    }

    public function test_can_get_category_tree(): void
    {
        $parent = Category::factory()->create([
            'title' => 'Programming',
        ]);

        $child = Category::factory()->make([
            'title' => 'Backend',
        ]);

        $child->appendToNode($parent)->save();

        $this->getJson('/api/categories/tree')
            ->assertOk()
            ->assertJsonPath('data.0.id', $parent->id)
            ->assertJsonPath(
                'data.0.children.0.id',
                $child->id
            );
    }

    public function test_nested_set_is_valid(): void
    {
        $parent = Category::factory()->create();
        $child = Category::factory()->make();

        $child->appendToNode($parent)->save();

        $this->assertFalse(Category::isBroken());

        $this->assertEquals(
            $parent->id,
            $child->fresh()->parent_id
        );
    }

    public function test_category_articles_count(): void
    {
        $category = Category::factory()->create();

        $articles = Article::factory()
            ->count(3)
            ->create();

        $category->articles()->attach(
            $articles->pluck('id')->all()
        );

        $this->getJson("/api/categories/{$category->id}")
            ->assertOk()
            ->assertJsonPath('data.articles_count', 3);
    }

    public function test_returns_404_for_missing_category(): void
    {
        $this->getJson('/api/categories/999999')
            ->assertNotFound();
    }

    public function test_categories_are_paginated(): void
    {
        Category::factory()->count(25)->create();

        $this->getJson('/api/categories?per_page=10')
            ->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertJsonPath('meta.total', 25);
    }
}
