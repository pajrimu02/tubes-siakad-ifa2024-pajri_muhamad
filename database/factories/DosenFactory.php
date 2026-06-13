<?php

namespace Database\Factories;

use App\Models\Dosen;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Dosen>
 */
class DosenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
{
    return [
        'nidn' => fake()->unique()->numerify('10######'),
        'nama' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'no_hp' => fake()->phoneNumber(),
        'alamat' => fake()->address(),
    ];
}
}
