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
        $prefixosPromotoria = [
            'Promotoria de ',
            'Promotorias de ',
        ];
        
        $promotoriasNomeGrupoWords = [
            'Justiça de Meio Ambiente',
            'Justiça de Direitos Humanos',
            'Justiça de Cidadania',
            'Justiça de Infância e Juventude',
            'Justiça de Combate à Violência Doméstica',
            'Justiça de Direito Constitucional',
            'Justiça de Direito do Consumidor',
        ];

        $municipioWords = [
            'Macapá',
            'Macapá', // duplicado
            'Macapá', // duplicado
            'Santana',
            'Santana', // duplicado
            'Santana', // duplicado
            'Laranjal do Jari',
            'Oiapoque',
            'Mazagão',
            'Ferreira Gomes',
        ];

        $municipio = $this->faker->randomElement($municipioWords);
         
        if ($municipio == 'Macapá' || $municipio == 'Santana') {
            $nomeGrupo        = $prefixosPromotoria[1] . $this->faker->randomElement($promotoriasNomeGrupoWords);
            $numeroPromotoria = \App\Models\Promotoria::where('nome_grupo', $nomeGrupo)->count() + 1;
        } else {
            $nomeGrupo        = $municipio;
            $numeroPromotoria = \App\Models\Promotoria::where('nome_grupo', $nomeGrupo)->count() + 1;
        }

        return [
            'nome'             => $numeroPromotoria . 'ª ' . $prefixosPromotoria[0] . $nomeGrupo,
            'nome_grupo'       => $nomeGrupo,
            'municipio'        => $municipio,
            'is_especializada' => $this->faker->boolean(),
            'promotor_id'      => \App\Models\Promotor::factory(),
        ];
    }
}
