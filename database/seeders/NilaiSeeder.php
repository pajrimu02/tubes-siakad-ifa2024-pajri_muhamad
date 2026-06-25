<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Krs;
use App\Models\Nilai;
use Faker\Factory as Faker;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        Krs::all()->each(function ($krs) use ($faker) {

            $grade = collect(['A','B','C','D','E'])->random();

            Nilai::create([
                'mahasiswa_id' => $krs->mahasiswa_id,
                'matakuliah_id' => $krs->jadwal->mata_kuliah_id ?? null,

                'semester' => $faker->numberBetween(1, 8),

                'nilai' => $grade,

                'angka' => match ($grade) {
                    'A' => $faker->numberBetween(85, 100),
                    'B' => $faker->numberBetween(75, 84),
                    'C' => $faker->numberBetween(65, 74),
                    'D' => $faker->numberBetween(50, 64),
                    'E' => $faker->numberBetween(0, 49),
                },

                'keterangan' => 'Nilai dari KRS',
            ]);
        });
    }
}