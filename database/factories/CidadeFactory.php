<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cidade>
 */
class CidadeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->city,
            'estado' => strtoupper($this->faker->randomElement(['SP', 'RJ', 'MG', 'BA', 'RS', 'PR'])),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
