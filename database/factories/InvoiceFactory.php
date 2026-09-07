<?php

namespace Database\Factories;

use App\Models\CaseFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        $case = CaseFile::factory();
        $status = fake()->randomElement(['draft', 'sent', 'paid', 'paid', 'overdue']);

        return [
            'case_id' => $case,
            'client_id' => fn(array $attrs) => CaseFile::find($attrs['case_id'])?->client_id,
            'accountant_id' => User::factory()->accountant(),
            'amount' => fake()->randomFloat(2, 150, 5000),
            'status' => $status,
            'description' => fake()->sentence(8),
            'due_date' => fake()->dateTimeBetween('-1 month', '+2 months'),
            'paid_at' => $status === 'paid' ? fake()->dateTimeBetween('-1 month', 'now') : null,
        ];
    }

    public function forCase(CaseFile $case): static
    {
        return $this->state(fn() => ['case_id' => $case->id, 'client_id' => $case->client_id]);
    }

    public function paid(): static
    {
        return $this->state(fn() => ['status' => 'paid', 'paid_at' => now()]);
    }

    public function overdue(): static
    {
        return $this->state(fn() => [
            'status' => 'overdue',
            'due_date' => fake()->dateTimeBetween('-2 months', '-1 week'),
            'paid_at' => null,
        ]);
    }
}
