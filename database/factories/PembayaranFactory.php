<?php

namespace Database\Factories;

use App\Models\Pembayaran;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pembayaran>
 */
class PembayaranFactory extends Factory
{
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        $status = $faker->randomElement([
            'lunas',
            'belum_lunas',
        ]);

        return [
            'mahasiswa_id' => Mahasiswa::inRandomOrder()->first()?->id,

            'semester' => $faker->numberBetween(1, 8),

            // biaya UKT kampus Indonesia
            'tagihan' => $faker->randomElement([
                1500000,
                2000000,
                2500000,
                3000000,
                3500000,
            ]),

            'status' => $status,

            // hanya lunas kalau status lunas
            'tanggal_bayar' => $status === 'lunas'
                ? $faker->dateTimeBetween('-1 year', 'now')
                : null,
        ];
    }
}