<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            EspelhoSeeder::class,
            PromotorSeeder::class,
            MunicipioSeeder::class,
            GrupoPromotoriaSeeder::class,
            PromotoriaSeeder::class,
            EventoSeeder::class,
            UrgenciaAtendimentoSeeder::class,
            UserSeeder::class,
        ]);
    }
}
