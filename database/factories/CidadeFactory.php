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
        $cidades = [
            'São Paulo', 'Rio de Janeiro', 'Belo Horizonte', 'Brasília', 'Curitiba',
            'Salvador', 'Fortaleza', 'Manaus', 'Recife', 'Porto Alegre',
            'Goiânia', 'Belém', 'Guarulhos', 'Campinas', 'São Luís'
        ];

        return [
            'nome' => $this->faker->randomElement($cidades),
            'estado' => strtoupper($this->faker->randomElement(['SP', 'RJ', 'MG', 'BA', 'RS', 'PR'])),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
