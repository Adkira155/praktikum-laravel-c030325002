<?php

namespace Database\Factories;

use App\Models\Matakuliah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Matakuliah>
 */
class MatakuliahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
    {
        return [
            'kode_mk'  => fake()->unique()->bothify('MK-###'),
            'nama_mk'  => fake()->unique()->words(3, true),
            'sks'      => fake()->numberBetween(1, 4),
            'semester' => fake()->numberBetween(1, 8),
            'dosen_id' => \App\Models\User::inRandomOrder()->value('id'),
        ];
    }
}
