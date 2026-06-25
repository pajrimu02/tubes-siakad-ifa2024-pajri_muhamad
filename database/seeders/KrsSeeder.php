<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use App\Models\Jadwal;
use App\Models\Krs;

class KrsSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Mahasiswa::all() as $mhs) {

            $jadwals = Jadwal::inRandomOrder()->take(5)->get();

            foreach ($jadwals as $jadwal) {
                Krs::create([
                    'mahasiswa_id' => $mhs->id,
                    'jadwal_id' => $jadwal->id,
                    'semester' => 'Ganjil',
                    'tahun_akademik' => '2025/2026',
                ]);
            }
        }
    }
}