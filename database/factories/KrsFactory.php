<?php

namespace Database\Factories;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Factories\Factory;

class KrsFactory extends Factory
{
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        // ambil mahasiswa acak tapi stabil
        $mahasiswa = Mahasiswa::inRandomOrder()->first();

        // jadwal di-filter biar lebih masuk akal
        $jadwal = Jadwal::where('kelas', $mahasiswa->angkatan ?? 'A')
            ->inRandomOrder()
            ->first();

        // fallback kalau kosong
        if (!$jadwal) {
            $jadwal = Jadwal::inRandomOrder()->first();
        }

        return [
            'mahasiswa_id' => $mahasiswa?->id,
            'jadwal_id' => $jadwal?->id,

            'semester' => $faker->randomElement(['Ganjil', 'Genap']),

            'tahun_akademik' =>
                $faker->numberBetween(2023, 2025) . '/' .
                $faker->numberBetween(2024, 2026),
        ];
    }
}