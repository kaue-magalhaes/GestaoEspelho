<?php

namespace Database\Factories;

use App\Models\Espelho;
use App\Models\GrupoPromotoria;
use App\Models\Model;
use App\Models\Promotor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class PromotoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome'                => fake()->name(),
            'is_especializada'    => rand(0, 1),
            'espelho_id'          => Espelho::query()->first()->id,
            'promotor_titular_id' => Promotor::query()->inRandomOrder()->first()->id,
            'grupo_promotoria_id' => GrupoPromotoria::query()->inRandomOrder()->first()->id,
        ];
    }
}
