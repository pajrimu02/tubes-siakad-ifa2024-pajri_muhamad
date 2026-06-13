<?php

namespace Database\Factories;

use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Jadwal>
 */
class JadwalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
{
    return [
        'dosen_id' => \App\Models\Dosen::inRandomOrder()->first()->id,
        'mata_kuliah_id' => \App\Models\MataKuliah::inRandomOrder()->first()->id,
        'hari' => fake()->randomElement(['Senin','Selasa','Rabu','Kamis','Jumat']),
        'jam_mulai' => '08:00:00',
        'jam_selesai' => '10:00:00',
        'kelas' => fake()->randomElement(['A','B','C']),
        'ruangan' => 'Ruang ' . fake()->numberBetween(101, 305),
    ];
}
}
