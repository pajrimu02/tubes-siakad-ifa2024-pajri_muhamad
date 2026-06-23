<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'mahasiswa']);

        for ($i = 1; $i <= 50; $i++) {

            $user = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'),
            ]);

            $user->assignRole('mahasiswa');

            Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => fake()->unique()->numerify('2023######'),
                'nama' => $user->name,
                'jk' => fake()->randomElement(['L','P']),
                'alamat' => fake()->address(),
                'no_hp' => fake()->phoneNumber(),
                'angkatan' => fake()->numberBetween(2019, 2025),
            ]);
        }
    }
}