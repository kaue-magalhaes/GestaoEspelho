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
            $grupoPromotoria     = GrupoPromotoria::query()->inRandomOrder()->first();
            $nomeGrupoPromotoria = $grupoPromotoria->nome;
            $nomePromotoria      = str_replace("Promotorias de ", "", $nomeGrupoPromotoria);
            Promotoria::factory()->create([
                'nome'                => "Promotoria de $nomePromotoria",
                'grupo_promotoria_id' => $grupoPromotoria->id,
            ]);
        }
    }
}
