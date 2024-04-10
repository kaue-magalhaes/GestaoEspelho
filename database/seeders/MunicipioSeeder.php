<?php

namespace Database\Seeders;

use App\Models\Municipio;
use Illuminate\Database\Seeder;

class MunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupoPromotoriasNomes = [
            'Macapá',
            'Santana',
            'Mazagão',
            'Oiapoque',
            'Calçoene',
            'Amapá',
            'Ferreira Gomes',
            'Laranjal do Jari',
            'Porto Grande',
        ];
        foreach ($grupoPromotoriasNomes as $grupoPromotoriasNome) {
            Municipio::factory()->create([
                'nome' => $grupoPromotoriasNome,
            ]);
        }
    }
}
