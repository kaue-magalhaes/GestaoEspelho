<?php

namespace Database\Factories\Historico;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Historico\HistoricoEspelho>
 */
class HistoricoEspelhoFactory extends Factory
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
            'usuario_id'     => \App\Models\User::factory(),
            'historico_id'   => \App\Models\Historico\Historico::factory(),
        ];
    }
}
