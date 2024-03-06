<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evento>
 */
class EventoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo'                => $this->faker->sentence(1),
            'tipo'                  => $this->faker->randomElement(['Férias', 'Licença', 'Plantão', 'Reunião', 'Outros']),
            'periodo_inicio'        => $this->faker->date(),
            'periodo_fim'           => $this->faker->date(),
            'promotor_titular_id'   => \App\Models\Promotor::inRandomOrder()->first()->id,
            'promotor_designado_id' => \App\Models\Promotor::inRandomOrder()->first()->id,
            'created_at'            => now(),
            'updated_at'            => now(),
        ];
    }
}
