<?php

namespace Database\Seeders;

use App\Models\Promotoria;
use Illuminate\Database\Seeder;

class PromotoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 30; $i++) {
            $promotoria = Promotoria::factory()->make();
            $promotoria->save();
        }
    }
}
