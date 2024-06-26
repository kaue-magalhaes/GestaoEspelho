<?php

namespace Database\Factories;

use App\Models\Promotor;
use App\Models\UrgenciaAtendimento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UrgenciaAtendimento>
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
            'periodo_inicio'        => $this->faker->dateTime(),
            'periodo_fim'           => $this->faker->dateTime(),
            'promotor_designado_id' => Promotor::query()->inRandomOrder()->first()->id,
        ];
    }
}
