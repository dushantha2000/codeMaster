<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Snippet>
 */
class SnippetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'title' => $this->faker->sentence(),
        'description' => $this->faker->paragraph(),
        'language' => $this->faker->randomElement(['PHP', 'Laravel', 'JS', 'Python']),
        'user_id' => \App\Models\User::all()->random()->id,
    ];
}
}
