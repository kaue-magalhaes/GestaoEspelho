<?php

namespace Database\Factories;

use App\Models\GrupoPromotoria;
use App\Models\Municipio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GrupoPromotoria>
 */
class GrupoPromotoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome'         => fake()->name(),
            'municipio_id' => Municipio::inRandomOrder()->first()->id,
        ];
    }
}
