<?php

namespace Database\Factories;

use App\Models\Nilai;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Nilai>
 */
class NilaiFactory extends Factory
{
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        $grade = $faker->randomElement(['A', 'B', 'C', 'D', 'E']);

        return [
            'mahasiswa_id' => Mahasiswa::inRandomOrder()->first()?->id,
            'matakuliah_id' => MataKuliah::inRandomOrder()->first()?->id,

            'semester' => $faker->numberBetween(1, 8),

            // nilai huruf A–E
            'nilai' => $grade,

            // angka sesuai grade
            'angka' => $this->generateAngka($grade, $faker),

            'keterangan' => 'Nilai otomatis (factory SIAKAD)',
        ];
    }

    private function generateAngka($grade, $faker): int
    {
        return match ($grade) {
            'A' => $faker->numberBetween(85, 100),
            'B' => $faker->numberBetween(75, 84),
            'C' => $faker->numberBetween(65, 74),
            'D' => $faker->numberBetween(50, 64),
            'E' => $faker->numberBetween(0, 49),
        };
    }
}