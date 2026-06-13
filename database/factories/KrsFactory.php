<?php

namespace Database\Factories;

use App\Models\Krs;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Krs>
 */
class KrsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
{
    return [
        'mahasiswa_id' => \App\Models\Mahasiswa::inRandomOrder()->first()->id,
        'jadwal_id' => \App\Models\Jadwal::inRandomOrder()->first()->id,
        'semester' => 'Ganjil',
        'tahun_akademik' => '2025/2026',
    ];
}
}
