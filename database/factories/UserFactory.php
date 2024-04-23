<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
            'matricula'     => $this->faker->randomNumber(),
            'login_ecidade' => $this->faker->userName(),
            'senha_ecidade' => null,
            'login_urano' => 03447604212,
            'senha_urano' => $this->faker->password(),
            'login_ad' => $this->faker->userName(),
            'senha_ad' => null,
            'email' => $this->faker->email(),
            'cpf' => 03447604212,
            'rg' => $this->faker->randomNumber(),
            'id_urano' => $this->faker->randomNumber(),
            'id_ecidade' => $this->faker->randomNumber(),
            'status' => $this->faker->numberBetween(0, 1),
            'ultimo_acesso' => $this->faker->dateTime(),
            'ultimo_acesso_sistema' => 'Intranet',
        ];
    }
}
