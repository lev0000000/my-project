<?php

namespace Tests\Feature\Api;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_authors(): void
    {
        Author::factory()->count(5)->create();

        $response = $this->getJson('/api/authors');

        $response->assertOk()
            ->assertJsonCount(5, 'data');
    }

    public function test_can_search_by_last_name(): void
    {
        Author::factory()->create([
            'full_name' => 'Иванов Иван Иванович',
            'last_name' => 'Иванов',
        ]);

        $response = $this->getJson(
            '/api/authors?last_name=Иванов'
        );

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.last_name', 'Иванов');
    }

    public function test_can_get_author_by_slug(): void
    {
        $author = Author::factory()->create();

        $response = $this->getJson(
            "/api/authors/slug/{$author->slug}"
        );

        $response->assertOk()
            ->assertJsonPath('data.id', $author->id);
    }

    public function test_returns_404_for_missing_author(): void
    {
        $response = $this->getJson('/api/authors/999999');

        $response->assertNotFound();
    }

    public function test_authors_are_paginated(): void
    {
        Author::factory()->count(25)->create();

        $response = $this->getJson(
            '/api/authors?per_page=10'
        );

        $response->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertJsonPath('meta.total', 25);
    }
}
