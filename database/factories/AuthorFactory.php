<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('ru_RU');
        $gender = $faker->randomElement(['male', 'female']);

        $lastName = $faker->lastName($gender);
        $firstName = $faker->firstName($gender);
        $middleName = $faker->middleName($gender);

        return [
            'full_name' => "$lastName $firstName $middleName",
            'last_name' => $lastName,
            'avatar' => null,
            'birth_year' => $faker->numberBetween(1940, 2005),
            'biography' => $faker->paragraphs(3, true),
        ];
    }
}
