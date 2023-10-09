<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()->dateTime();
        return [
            'user_id' => 1,
            'body' => fake()->paragraph(),
            'media' => '1696830215.jpg',
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
