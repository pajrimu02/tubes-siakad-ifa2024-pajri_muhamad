<?php

namespace Database\Factories;

use App\Models\MataKuliah;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends Factory<MataKuliah>
 */
class MataKuliahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition()
{
    return [
        'kode_mk' => fake()->unique()->bothify('MK###'),
        'nama_mk' => fake()->randomElement([
            'Struktur Data',
            'Pemrograman Web',
            'Basis Data',
            'Jaringan Komputer',
            'AI',
            'Sistem Operasi',
            'OOP',
            'Mobile Programming',
        ]),
        'sks' => fake()->numberBetween(2,4),
        'semester' => fake()->numberBetween(1,6),
    ];
}
}
