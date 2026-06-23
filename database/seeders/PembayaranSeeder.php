<?php

namespace Database\Seeders;
use App\Models\Pembayaran;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class PembayaranSeeder extends Seeder
{
    public function run(): void
    {
        $mhs = Mahasiswa::first();

        if ($mhs) {
            Pembayaran::create([
                'mahasiswa_id' => $mhs->id,
                'semester' => '1',
                'tagihan' => 2500000,
                'status' => 'lunas',
                'tanggal_bayar' => now(),
            ]);

            Pembayaran::create([
                'mahasiswa_id' => $mhs->id,
                'semester' => '2',
                'tagihan' => 2500000,
                'status' => 'belum_lunas',
                'tanggal_bayar' => null,
            ]);
        }
    }
}