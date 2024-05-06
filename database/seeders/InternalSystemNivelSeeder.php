<?php

namespace Database\Seeders;

use App\Models\InternalSystemNivel;
use Illuminate\Database\Seeder;

class InternalSystemNivelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nivels = [
            [
                'usuario_id' => 1,
                'sistema'    => 'SOL',
                'nivel'      => 5,
                'status'     => true,
            ],
        ];

        foreach ($nivels as $nivel) {
            InternalSystemNivel::create($nivel);
        }
    }
}
