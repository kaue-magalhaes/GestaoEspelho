<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UrgenciaAtendimento>
 */
class UrgenciaAtendimentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'periodo_inicio' => $this->faker->date(),
            'periodo_fim'    => $this->faker->date(),
            'promotor_designado_id'    => \App\Models\Promotor::inRandomOrder()->first()->id,
        ];
    }
}
