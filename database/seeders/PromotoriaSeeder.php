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
        $numeroDosNomesGerados = [];
        for ($i = 0; $i < 40; $i++) {
            $grupoPromotoria     = GrupoPromotoria::query()->inRandomOrder()->first();
            $nomeGrupoPromotoria = $grupoPromotoria->nome;
            $nomePromotoria      = str_replace("Promotorias de ", "", $nomeGrupoPromotoria);
            if (isset($numeroDosNomesGerados[$nomeGrupoPromotoria])) {
                $numeroDosNomesGerados[$nomeGrupoPromotoria]++;
            } else {
                $numeroDosNomesGerados[$nomeGrupoPromotoria] = 1;
            }

            Promotoria::factory()->create([
                'nome'                => "$numeroDosNomesGerados[$nomeGrupoPromotoria]" . "ª Promotoria de $nomePromotoria",
                'grupo_promotoria_id' => $grupoPromotoria->id,
            ]);
        }
    }
}
