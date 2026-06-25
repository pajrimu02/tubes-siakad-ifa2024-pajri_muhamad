<?php

namespace Database\Factories;

use App\Models\Nilai;
use App\Models\Krs;
use Illuminate\Database\Eloquent\Factories\Factory;

class NilaiFactory extends Factory
{
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        $krs = Krs::inRandomOrder()->first();

        $grade = $faker->randomElement(['A', 'B', 'C', 'D', 'E']);

        return [
            'mahasiswa_id' => $krs?->mahasiswa_id,
            'matakuliah_id' => $krs?->jadwal?->mata_kuliah_id ?? null,

            'semester' => $faker->numberBetween(1, 8),

            'nilai' => $grade,

            'angka' => match ($grade) {
                'A' => $faker->numberBetween(85, 100),
                'B' => $faker->numberBetween(75, 84),
                'C' => $faker->numberBetween(65, 74),
                'D' => $faker->numberBetween(50, 64),
                'E' => $faker->numberBetween(0, 49),
            },

            'keterangan' => 'Nilai otomatis dari KRS',
        ];
    }
}