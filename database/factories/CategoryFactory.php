<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
   static $uniqueFaker;
        if (! $uniqueFaker) {
            $uniqueFaker = $this->faker->unique();
        }

        $base = $uniqueFaker->word();

        return [
            'name'        => $base . '_' . Str::random(5),
            'description' => $this->faker->sentence(),
        ];
    }
}
