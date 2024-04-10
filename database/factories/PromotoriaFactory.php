<?php

namespace Database\Factories;

use App\Models\Espelho;
use App\Models\GrupoPromotoria;
use App\Models\Model;
use App\Models\Promotor;
use App\Models\Promotoria;
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
            'nome'                   => fake()->name(),
            'is_especializada'       => false,
            'espelho_id'             => Espelho::all()->first(),
            'promotor_titular_id'    => Promotor::inRandomOrder()->first()->id,
            'created_at'             => now(),
            'updated_at'             => now(),
        ];
    }
}
