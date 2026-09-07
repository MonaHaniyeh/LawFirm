<?php

namespace Database\Factories;

use App\Models\CaseFile;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'case_id' => CaseFile::factory(),
            'sender_id' => fn(array $attrs) => CaseFile::find($attrs['case_id'])?->client_id,
            'receiver_id' => fn(array $attrs) => CaseFile::find($attrs['case_id'])?->lawyer_id,
            'subject' => fake()->boolean(30) ? fake()->sentence(4) : null,
            'content' => fake()->paragraph(),
            'is_new' => fake()->boolean(25),
        ];
    }

    /** Build a realistic back-and-forth thread on one case. */
    public function forCase(CaseFile $case): static
    {
        return $this->state(fn() => ['case_id' => $case->id]);
    }

    public function fromClient(CaseFile $case): static
    {
        return $this->state(fn() => [
            'case_id' => $case->id,
            'sender_id' => $case->client_id,
            'receiver_id' => $case->lawyer_id,
        ]);
    }

    public function fromLawyer(CaseFile $case): static
    {
        return $this->state(fn() => [
            'case_id' => $case->id,
            'sender_id' => $case->lawyer_id,
            'receiver_id' => $case->client_id,
        ]);
    }
}
