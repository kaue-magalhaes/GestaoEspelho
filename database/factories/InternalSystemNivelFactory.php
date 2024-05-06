<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InternalSystemNivel>
 */
class InternalSystemNivelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'usuario_id' => $this->faker->numberBetween(1, 10),
            'sistema'    => $this->faker->word,
            'nivel'      => $this->faker->numberBetween(1, 10),
            'status'     => $this->faker->numberBetween(0, 1),
        ];
    }
}
