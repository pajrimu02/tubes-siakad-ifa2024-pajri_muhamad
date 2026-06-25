<?php

namespace Database\Factories;

use App\Models\Dosen;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dosen>
 */
class DosenFactory extends Factory
{
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        return [
            'nidn' => $faker->unique()->numerify('10######'),
            'nama' => $faker->name(),
            'email' => $faker->unique()->safeEmail(),

            // nomor HP Indonesia (format 08xx realistis)
            'no_hp' => $this->generateIndoPhone($faker),

            'alamat' => $faker->address(),
        ];
    }

    /**
     * Generate nomor HP Indonesia yang realistis
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