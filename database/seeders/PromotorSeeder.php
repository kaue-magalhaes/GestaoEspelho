<?php

namespace Database\Seeders;

use App\Models\InternalSystemUser;
use Illuminate\Database\Seeder;

class PromotorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            InternalSystemUser::query()->create([
                'nome'           => fake()->name(),
                'login_intranet' => fake()->userName(),
                'senha_intranet' => bcrypt(fake()->password()),
                'matricula'      => '10' . fake()->randomNumber(4, true),
            ]);
        }
    }
}
