<?php

namespace Database\Seeders;

use App\Models\UrgenciaAtendimento;
use Illuminate\Database\Seeder;

class UrgenciaAtendimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $urgenciaAtendimento = UrgenciaAtendimento::factory()->make();
            $urgenciaAtendimento->save();
        }
    }
}
