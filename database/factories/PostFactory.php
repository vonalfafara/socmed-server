<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

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
            'user_id' => fake()->randomElement(User::pluck('id')),
            'body' => fake()->paragraph(),
            'media' => fake()->randomElement(['1696830215.jpg', '1696920599.png', '1696920734.png', '']),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
