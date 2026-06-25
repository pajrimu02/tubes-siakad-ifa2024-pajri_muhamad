<?php

namespace Database\Factories;

use App\Models\Dosen;
use App\Models\MataKuliah;
use Illuminate\Database\Eloquent\Factories\Factory;

class JadwalFactory extends Factory
{
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        return [
            'dosen_id' => Dosen::inRandomOrder()->first()?->id,
            'mata_kuliah_id' => MataKuliah::inRandomOrder()->first()?->id,

            'hari' => $faker->randomElement([
                'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'
            ]),

            'jam_mulai' => $faker->randomElement([
                '07:30:00', '09:20:00', '13:00:00', '15:30:00'
            ]),

            'jam_selesai' => $faker->randomElement([
                '09:10:00', '10:50:00', '14:40:00', '17:00:00'
            ]),

            
            'kelas' => $faker->randomElement(['A', 'B', 'C', 'D']),

            'ruangan' => 'Ruang ' . $faker->numberBetween(101, 510),
        ];
    }
}