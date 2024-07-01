<?php

namespace Database\Seeders;

use App\Models\GrupoPromotoria;
use Illuminate\Database\Seeder;

class GrupoPromotoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $municipios = [
            'Macapá',
            'Macapá', // Duplicado
            'Macapá', // Duplicado
            'Santana',
            'Santana', // Duplicado
            'Santana', // Duplicado
            'Mazagão',
            'Oiapoque',
            'Calçoene',
            'Amapá',
            'Ferreira Gomes',
            'Laranjal do Jari',
            'Porto Grande',
        ];
        $grupoPromotoriasNomes = [
            'Justiça de Meio Ambiente',
            'Justiça de Direitos Humanos',
            'Justiça de Cidadania',
            'Justiça de Infância e Juventude',
            'Justiça de Combate à Violência Doméstica',
            'Justiça de Direito Constitucional',
            'Justiça de Direito do Consumidor',
            'Justiça de Direito Criminal',
            'Justiça de Direito da Mulher',
        ];
        for ($i = 0; $i < 20; $i++) {
            $municipio            = $municipios[array_rand($municipios)];
            $grupoPromotoriasNome = $grupoPromotoriasNomes[array_rand($grupoPromotoriasNomes)];

            if ($municipio === 'Macapá' || $municipio === 'Santana') {
                GrupoPromotoria::factory()->create([
                    'nome'      => "Promotorias de $grupoPromotoriasNome",
                    'municipio' => $municipio,
                ]);
            } else {
                GrupoPromotoria::factory()->create([
                    'nome'      => $municipio,
                    'municipio' => $municipio,
                ]);
            }

        }
    }
}
