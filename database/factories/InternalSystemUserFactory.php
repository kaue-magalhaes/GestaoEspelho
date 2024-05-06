<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InternalSystemUser>
 */
class InternalSystemUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome'           => $this->faker->name(),
            'login_intranet' => $this->faker->userName(),
            'senha_intranet' => $this->faker->password(),
        ];
    }
}
