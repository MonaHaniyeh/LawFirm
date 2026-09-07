<?php

namespace Database\Factories;

use App\Models\CaseFile;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    public function definition(): array
    {
        $case = CaseFile::factory();
        $title = fake()->randomElement([
            'Lease Agreement',
            'Breach Notice',
            'Power of Attorney',
            'Response Draft',
            'Evidence Summary',
            'Court Filing',
            'Client Statement',
            'Settlement Offer',
        ]) . '.' . fake()->randomElement(['pdf', 'docx']);

        return [
            'case_id' => $case,
            'uploaded_by' => fn(array $attrs) => CaseFile::find($attrs['case_id'])?->client_id,
            'title' => $title,
            // NOT a real uploaded file — seeded rows point at a path that
            // doesn't exist on disk. Fine for UI/demo purposes (lists,
            // tables); download links will 404 until a real file is
            // uploaded through the actual form. Don't seed fake storage
            // paths into a production database.
            'file_path' => 'seed-placeholder/' . fake()->uuid() . '.' . pathinfo($title, PATHINFO_EXTENSION),
            'mime_type' => str_ends_with($title, '.pdf') ? 'application/pdf'
                : 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'size_bytes' => fake()->numberBetween(20_000, 4_500_000),
        ];
    }

    public function forCase(CaseFile $case): static
    {
        return $this->state(fn() => ['case_id' => $case->id, 'uploaded_by' => $case->client_id]);
    }
}
