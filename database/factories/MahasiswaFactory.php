<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        return [
            // ambil user dengan role mahasiswa (aman kalau kosong)
            'user_id' => User::role('mahasiswa')->inRandomOrder()->first()?->id,

            // NIM lebih realistis kampus Indonesia
            'nim' => '2025' . $faker->unique()->numerify('#######'),

            'nama' => $faker->name(),

            'jk' => $faker->randomElement(['L', 'P']),

            'alamat' => $faker->address(),

            // nomor HP Indonesia format 08xx
            'no_hp' => $this->generateIndoPhone($faker),

            // angkatan realistis
            'angkatan' => $faker->numberBetween(2019, 2025),
        ];
    }

    /**
     * Generate nomor HP Indonesia (operator real)
     */
    private function generateIndoPhone($faker): string
    {
        $prefix = $faker->randomElement([
            '0811', '0812', '0813',
            '0821', '0822',
            '0852', '0853',
            '0895', '0896', '0897', '0898', '0899'
        ]);

        return $prefix . $faker->numerify('#######');
    }
}