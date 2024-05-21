<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Espelho>
 */
class EspelhoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'periodo_inicio' => $this->faker->dateTime(),
            'periodo_fim'    => $this->faker->dateTime(),
            'created_at'     => now(),
            'updated_at'     => now(),
        ];
    }
}
