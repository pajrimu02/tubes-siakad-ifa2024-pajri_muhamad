<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nilai;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        // cek dulu biar aman
        if (\App\Models\Mahasiswa::count() == 0 || \App\Models\MataKuliah::count() == 0) {
            return;
        }

        // generate data nilai pakai factory
        Nilai::factory()
            ->count(100) // jumlah data nilai
            ->create();
    }
}