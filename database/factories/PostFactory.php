<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
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
        return [
            'image' => $this->faker->image(),
            'title' => $this->faker->text(100),
            'fragment' => $this->faker->text(),
            'content' => $this->faker->paragraphs(2, true)
        ];
    }
}
