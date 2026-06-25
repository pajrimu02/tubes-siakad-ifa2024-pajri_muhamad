<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pembayaran;

class PembayaranSeeder extends Seeder
{
    public function run(): void
    {
        // cek data mahasiswa dulu
        if (\App\Models\Mahasiswa::count() == 0) {
            return;
        }

        // generate banyak data pembayaran otomatis
        Pembayaran::factory()
            ->count(30)
            ->create();
    }
}