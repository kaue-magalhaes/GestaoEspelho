<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promotor>
 */
class PromotorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome'          => $this->faker->name(),
            'is_substituto' => random_int(0, 1),
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }
}
