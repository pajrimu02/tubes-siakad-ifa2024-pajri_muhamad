<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Default password reusable
     */
    protected static ?string $password = null;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        return [
            // nama Indonesia
            'name' => $faker->name(),

            // email tetap safe + unik
            'email' => $faker->unique()->safeEmail(),

            'email_verified_at' => now(),

            'password' => static::$password ??= Hash::make('password'),

            'remember_token' => Str::random(10),
        ];
    }

    /**
     * User belum verifikasi email
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * State khusus untuk user mahasiswa (opsional tapi keren)
     */
    public function mahasiswa(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => fake()->name(),
        ]);
    }
}