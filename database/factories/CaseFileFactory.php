<?php

namespace Database\Factories;

use App\Models\CaseFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CaseFileFactory extends Factory
{
    protected $model = CaseFile::class;

    private const TYPE_CODES = [
        'Criminal Law' => 'CRIM',
        'Civil Law' => 'CIVL',
        'Family Law' => 'FAML',
        'Corporate Law' => 'CORP',
        'Bankruptcy Law' => 'BANK',
        'Employment Law' => 'EMPL',
        'Real Estate Law' => 'REAL',
        'Labor Law' => 'LABR',
        'Contract Law' => 'CNTR',
    ];

    public function definition(): array
    {
        $caseType = fake()->randomElement(array_keys(self::TYPE_CODES));
        $startDate = fake()->dateTimeBetween('-8 months', 'now');
        $status = fake()->randomElement(['opened', 'opened', 'opened', 'closed']); // weighted toward open

        return [
            'case_number' => $startDate->format('Y') . fake()->unique()->numberBetween(100000, 999999)
                . '-' . self::TYPE_CODES[$caseType],
            'client_id' => User::factory()->client(),
            'lawyer_id' => User::factory()->lawyer(),
            'case_type' => $caseType,
            'description' => fake()->paragraphs(2, true),
            'status' => $status,
            'start_date' => $startDate,
            'end_date' => $status === 'closed' ? fake()->dateTimeBetween($startDate, 'now') : null,
        ];
    }

    public function opened(): static
    {
        return $this->state(fn() => ['status' => 'opened', 'end_date' => null]);
    }

    public function closed(): static
    {
        return $this->state(fn(array $attrs) => [
            'status' => 'closed',
            'end_date' => fake()->dateTimeBetween($attrs['start_date'] ?? '-6 months', 'now'),
        ]);
    }

    /** Ties this case to a specific already-created client + lawyer pair. */
    public function between(User $client, User $lawyer): static
    {
        return $this->state(fn() => [
            'client_id' => $client->id,
            'lawyer_id' => $lawyer->id,
        ]);
    }
}
