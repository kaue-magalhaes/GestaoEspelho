<?php

namespace Database\Seeders;

use App\Models\Promotoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromotoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promotoria::factory()
            ->count(10)
            ->create();
    }
}
