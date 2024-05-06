<?php

namespace Database\Seeders;

use App\Models\InternalSystemUser;
use Illuminate\Database\Seeder;

class InternalSystemUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InternalSystemUser::query()->create([
            'nome'           => 'Admin',
            'login_intranet' => 'admin',
            'senha_intranet' => bcrypt('admin'),
        ]);
    }
}
