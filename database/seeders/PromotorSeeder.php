<?php

namespace Database\Seeders;

use App\Models\Promotor;
use Illuminate\Database\Seeder;

class PromotorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promotor::factory()
            ->count(10)
            ->create();
    }
}
