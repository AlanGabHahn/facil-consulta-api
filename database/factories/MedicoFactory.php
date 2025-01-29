<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cidade;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medico>
 */
class MedicoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->randomElement(['Dr.', 'Dra.']) . ' ' . $this->faker->name,
            'especialidade' => $this->faker->randomElement(['Cardiologia', 'Pediatria', 'Dermatologia', 'Ortopedia']),
            'cidade_id' => Cidade::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
