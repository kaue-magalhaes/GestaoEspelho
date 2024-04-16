<?php

namespace Database\Factories\Historico;

use App\Models\Historico\Historico;
use App\Models\Historico\HistoricoEspelho;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HistoricoEspelho>
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
            'titulo'         => $this->faker->sentence,
            'periodo_inicio' => $this->faker->date(),
            'periodo_fim'    => $this->faker->date(),
            'usuario_id'     => User::factory(),
            'historico_id'   => Historico::factory(),
        ];
    }
}
