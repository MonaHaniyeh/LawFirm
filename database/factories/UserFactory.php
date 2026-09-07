<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // demo/staging only — never in production seeds
            'remember_token' => Str::random(10),
            'role' => 'client',
            'phone' => fake()->numerify('07########'), // Jordanian mobile format
            'language' => 'en',
            'status' => 'active',
        ];
    }

    /** php artisan tinker: User::factory()->client()->create() */
    public function client(): static
    {
        return $this->state(fn() => ['role' => 'client']);
    }

    public function lawyer(): static
    {
        return $this->state(fn() => [
            'role' => 'lawyer',
            'specialization' => fake()->randomElement([
                'Criminal Law',
                'Civil Law',
                'Family Law',
                'Corporate Law',
                'Real Estate Law',
                'Labor Law',
                'Contract Law',
            ]),
            'license_number' => 'JBA-' . fake()->unique()->numberBetween(10000, 99999),
            'experience_years' => fake()->numberBetween(1, 30),
            'bio' => fake()->paragraph(),
            'billing_rate' => fake()->randomElement([80, 100, 120, 150, 200]),
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn() => ['role' => 'admin']);
    }

    public function accountant(): static
    {
        return $this->state(fn() => ['role' => 'accountant']);
    }

    public function banned(): static
    {
        return $this->state(fn() => ['status' => 'banned']);
    }

    public function unverified(): static
    {
        return $this->state(fn() => ['email_verified_at' => null]);
    }
}
