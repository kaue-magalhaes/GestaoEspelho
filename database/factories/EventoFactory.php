<?php

namespace Database\Factories;

use App\Models\Evento;
use App\Models\Promotor;
use App\Models\Promotoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Evento>
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
            'periodo_inicio'        => $this->faker->dateTime(),
            'periodo_fim'           => $this->faker->dateTime(),
            'promotor_titular_id'   => Promotoria::query()->inRandomOrder()->first()->promotor_titular_id,
            'promotor_designado_id' => Promotor::query()->inRandomOrder()->first()->id,
            'created_at'            => now(),
            'updated_at'            => now(),
        ];
    }
}
