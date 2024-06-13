<?php

namespace Database\Seeders;

use App\Models\Espelho;
use Illuminate\Database\Seeder;

class EspelhoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Espelho::factory()->create();
    }
}
