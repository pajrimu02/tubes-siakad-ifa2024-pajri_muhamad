<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // role mahasiswa
        Role::firstOrCreate(['name' => 'mahasiswa']);

        for ($i = 1; $i <= 500; $i++) {

            // 1 user = 1 mahasiswa (WAJIB sinkron)
            $user = User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
            ]);

            $user->assignRole('mahasiswa');

            Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $faker->unique()->numerify('2023######'),
                'nama' => $user->name,
                'jk' => $faker->randomElement(['L','P']),
                'alamat' => $faker->address(),
                'no_hp' => $faker->phoneNumber(),
                'angkatan' => $faker->numberBetween(2020, 2025),
            ]);
        }
    }
}