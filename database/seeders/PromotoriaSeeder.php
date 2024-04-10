<?php

namespace Database\Seeders;

use App\Models\GrupoPromotoria;
use App\Models\Promotoria;
use Illuminate\Database\Seeder;

class PromotoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $nomeGrupoPromotoria = GrupoPromotoria::inRandomOrder()->first()->nome;
            $nomePromotoria = str_replace("Promotorias de ", "", $nomeGrupoPromotoria);
            Promotoria::factory()->create([
                'nome' => "Promotoria de $nomePromotoria",
                'is_especializada' => rand(0, 1),
            ]);
        }
    }
}
