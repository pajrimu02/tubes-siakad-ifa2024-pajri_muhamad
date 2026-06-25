<?php

namespace Database\Factories;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Krs>
 */
class KrsFactory extends Factory
{
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        $mahasiswa = Mahasiswa::inRandomOrder()->first();
        $jadwal = Jadwal::inRandomOrder()->first();

        return [
            'mahasiswa_id' => $mahasiswa?->id,
            'jadwal_id' => $jadwal?->id,

            // lebih realistis
            'semester' => $faker->randomElement(['Ganjil', 'Genap']),

            // tahun akademik dinamis (biar gak kaku)
            'tahun_akademik' =>
                $faker->numberBetween(2023, 2025) . '/' .
                $faker->numberBetween(2024, 2026),
        ];
    }
}