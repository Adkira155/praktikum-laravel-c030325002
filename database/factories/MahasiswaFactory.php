<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nim' => fake()->unique()->numerify('2024##0###'),
            'nama' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'prodi' => fake()->randomElement(['Teknik Informatika','Sistem Informasi','Teknik Komputer']),
            'semester' => fake()->numberBetween(1, 8),
        ];
    }
}
