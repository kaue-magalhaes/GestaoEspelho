<?php

namespace Database\Seeders;

use App\Models\GrupoPromotoria;
use App\Models\Municipio;
use Illuminate\Database\Seeder;

class GrupoPromotoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
            $municipio            = Municipio::inRandomOrder()->first();
            $grupoPromotoriasNome = $grupoPromotoriasNomes[array_rand($grupoPromotoriasNomes)];

            if ($municipio->nome === 'Macapá' || $municipio->nome === 'Santana') {
                GrupoPromotoria::factory()->create([
                    'nome'         => "Promotorias de $grupoPromotoriasNome",
                    'municipio_id' => $municipio->id,
                ]);
            } else {
                GrupoPromotoria::factory()->create([
                    'nome'         => "$municipio->nome",
                    'municipio_id' => $municipio->id,
                ]);
            }

        }
    }
}
