<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends Factory<Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
   public function definition()
{
    return [
        'user_id' => \App\Models\User::factory(),
        'nim' => fake()->unique()->numerify('####0#####'),
        'nama' => fake()->name(),
        'jk' => fake()->randomElement(['L','P']),
        'alamat' => fake()->address(),
        'no_hp' => fake()->phoneNumber(),
        'angkatan' => fake()->numberBetween(2019, 2025),
    ];
}
}
