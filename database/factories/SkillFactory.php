<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skill>
 */
class SkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word,
            'img' => 'https://picsum.photos/200/300',
            'description' => $this->faker->sentence,
            'url' => 'https://www.google.com',
            'level' => $this->faker->randomElement(['beginner', 'intermediate', 'advanced', 'expert']),
        ];
    }
}
