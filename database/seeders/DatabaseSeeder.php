<?php

namespace Database\Seeders;

use App\Models\{
    User,
    Cidade,
    Medico,
    Paciente
};
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Cidade::factory(10)->create();
        Medico::factory(10)->create();
        Paciente::factory(10)->create();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);
    }
}
