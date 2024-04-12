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
        foreach ($grupoPromotoriasNomes as $grupoPromotoriasNome) {
            Municipio::factory()->create([
                'nome' => $grupoPromotoriasNome,
            ]);
        }
    }
}
