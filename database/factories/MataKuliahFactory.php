<?php

namespace Database\Factories;

use App\Models\MataKuliah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MataKuliah>
 */
class MataKuliahFactory extends Factory
{
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        return [
            // kode MK lebih realistis kampus Indonesia
            'kode_mk' => $this->generateKodeMK(),

            'nama_mk' => $faker->randomElement([
                'Struktur Data',
                'Algoritma Pemrograman',
                'Pemrograman Web',
                'Basis Data',
                'Jaringan Komputer',
                'Sistem Operasi',
                'Object Oriented Programming',
                'Mobile Programming',
                'Kecerdasan Buatan',
                'Rekayasa Perangkat Lunak',
                'Analisis dan Desain Sistem',
                'Keamanan Jaringan',
                'Pemrograman Java',
                'Pemrograman Python',
                'Cloud Computing'
            ]),

            // SKS realistis
            'sks' => $faker->randomElement([2, 3, 4]),

            // semester diperluas (lebih realistis kampus 1–8)
            'semester' => $faker->numberBetween(1, 8),
        ];
    }

    /**
     * Generate kode mata kuliah ala kampus Indonesia
     * Contoh: MKP101, MKB205, MKJ302
     */
    private function generateKodeMK(): string
    {
        $prefix = ['MKA', 'MKB', 'MKP', 'MKJ', 'MKS'];

        return $prefix[array_rand($prefix)] .
               rand(100, 499);
    }
}