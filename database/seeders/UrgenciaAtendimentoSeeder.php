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
        for ($i = 0; $i < 2; $i++) {
            UrgenciaAtendimento::factory()->create();
        }
    }
}
