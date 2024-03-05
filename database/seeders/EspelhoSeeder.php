<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EspelhoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Espelho::factory()
            ->create();
    }
}
