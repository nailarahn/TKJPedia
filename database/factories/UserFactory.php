<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $name = fake()->name();
        $base = strtolower(preg_replace('/[^a-z0-9]/i', '', explode(' ', $name)[0])) ?: 'user';

        return [
            'name'              => $name,
            'username'          => $base . fake()->unique()->numerify('###'),
            'email'             => fake()->unique()->safeEmail(),
            'jurusan'           => 'Teknik Komputer dan Jaringan',
            'role'              => 'Pelajar',
            'avatar'            => null,
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
