<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(5),
            'image' => null,
            'excerpt' => fake()->paragraph(),
            'content' => fake()->paragraphs(5, true),
            'author_id' => Author::factory(),
        ];
    }
}
