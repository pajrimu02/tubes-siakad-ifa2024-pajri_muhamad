<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nilai;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswas = Mahasiswa::all();
        $matkuls = Matakuliah::all();

        if ($mahasiswas->isEmpty() || $matkuls->isEmpty()) {
            return;
        }

        foreach ($mahasiswas as $mhs) {
            foreach ($matkuls->take(3) as $mk) {

                Nilai::create([
                    'mahasiswa_id' => $mhs->id,
                    'matakuliah_id' => $mk->id,
                    'semester' => '1',
                    'nilai' => collect(['A', 'B', 'C'])->random(),
                    'angka' => rand(70, 95),
                    'keterangan' => 'Nilai otomatis seed',
                ]);
            }
        }
    }
}