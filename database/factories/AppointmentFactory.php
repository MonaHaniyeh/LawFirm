<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\CaseFile;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        $case = CaseFile::factory();
        $status = fake()->randomElement(['pending', 'scheduled', 'scheduled', 'completed', 'rejected']);

        return [
            'case_id' => $case,
            'client_id' => fn(array $attrs) => CaseFile::find($attrs['case_id'])?->client_id
                ?? \App\Models\User::factory()->client(),
            'lawyer_id' => fn(array $attrs) => CaseFile::find($attrs['case_id'])?->lawyer_id
                ?? \App\Models\User::factory()->lawyer(),
            'appointment_date' => fake()->dateTimeBetween('-2 months', '+1 month'),
            'appointment_time' => fake()->time('H:i'),
            'meeting_location' => fake()->randomElement([null, 'Office — Main Branch', 'Video call', 'Client site']),
            'note' => fake()->boolean(40) ? fake()->sentence() : null,
            'status' => $status,
            'response' => in_array($status, ['scheduled', 'rejected']) ? fake()->sentence() : null,
            'is_new' => $status === 'pending',
        ];
    }

    /** The realistic path: build FROM an existing case so client/lawyer always match. */
    public function forCase(CaseFile $case): static
    {
        return $this->state(fn() => [
            'case_id' => $case->id,
            'client_id' => $case->client_id,
            'lawyer_id' => $case->lawyer_id,
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn() => ['status' => 'pending', 'response' => null, 'is_new' => true]);
    }

    public function scheduled(): static
    {
        return $this->state(fn() => ['status' => 'scheduled', 'is_new' => false]);
    }
}
