<?php

namespace Database\Factories;

use App\Models\Jadwal;
use App\Models\Dosen;
use App\Models\MataKuliah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Jadwal>
 */
class JadwalFactory extends Factory
{
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        $dosen = Dosen::inRandomOrder()->first();
        $mk = MataKuliah::inRandomOrder()->first();

        return [
            'dosen_id' => $dosen?->id,
            'mata_kuliah_id' => $mk?->id,

            'hari' => $faker->randomElement([
                'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'
            ]),

            // jam kuliah realistis kampus Indonesia
            'jam_mulai' => $faker->randomElement([
                '07:30:00',
                '08:00:00',
                '10:00:00',
                '13:00:00',
                '15:30:00'
            ]),

            'jam_selesai' => $faker->randomElement([
                '09:10:00',
                '10:50:00',
                '12:00:00',
                '14:50:00',
                '17:00:00'
            ]),

            'kelas' => $faker->randomElement(['A', 'B', 'C', 'D']),

            'ruangan' => 'Ruang ' . $faker->numberBetween(101, 510),
        ];
    }
}