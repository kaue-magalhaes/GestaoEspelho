<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
        $promotoriaWords = [
            'Promotoria de Justiça',
            'Promotoria de Defesa do Consumidor',
            'Promotoria de Justiça de Família',
            'Promotoria de Justiça de Meio Ambiente',
            'Promotoria de Justiça de Direitos Humanos',
            'Promotoria de Justiça de Cidadania',
            'Promotoria de Justiça de Infância e Juventude',
            'Promotoria de Justiça de Combate à Violência Doméstica',
            'Promotoria de Justiça de Combate à Corrupção',
            'Promotoria de Justiça de Combate ao Crime Organizado',
        ];

        $municipioWords = [
            'Macapá',
            'Santana',
            'Laranjal do Jari',
            'Oiapoque',
            'Mazagão',
            'Porto Grande',
            'Ferreira Gomes',
        ];

        return [
            'nome'        => $this->faker->unique()->randomElement($promotoriaWords),
            'municipio'   => $this->faker->randomElement($municipioWords),
            'promotor_id' => \App\Models\Promotor::factory(),
        ];
    }
}
