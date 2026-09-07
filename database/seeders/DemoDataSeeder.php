<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\CaseFile;
use App\Models\Document;
use App\Models\Invoice;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        $admin = User::factory()->admin()->create([
            'name' => 'Mona Hanieh',
            'email' => 'mona.hanieh@whitfieldcole.com',
            'password' => Hash::make('password'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | ACCOUNTANT
        |--------------------------------------------------------------------------
        */

        $accountant = User::factory()->accountant()->create([
            'name' => 'Rania Sayegh',
            'email' => 'billing@whitfieldcole.com',
            'password' => Hash::make('password'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | LAWYERS
        |--------------------------------------------------------------------------
        */

        $lawyerMarwan = User::factory()->lawyer()->create([
            'name' => 'Marwan Mohammed',
            'email' => 'marwan.mohammed@whitfieldcole.com',
            'password' => Hash::make('password'),
            'specialization' => 'Criminal Law',
            'experience_years' => 12,
            'billing_rate' => 150,
        ]);

        $lawyerSara = User::factory()->lawyer()->create([
            'name' => 'Sara Haddad',
            'email' => 'sara.haddad@whitfieldcole.com',
            'password' => Hash::make('password'),
            'specialization' => 'Civil Law',
            'experience_years' => 8,
            'billing_rate' => 120,
        ]);

        /*
        |--------------------------------------------------------------------------
        | CLIENTS
        |--------------------------------------------------------------------------
        */

        $clientAhmad = User::factory()->client()->create([
            'name' => 'Ahmad Ismail',
            'email' => 'ahmad.ismail@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $clientLayla = User::factory()->client()->create([
            'name' => 'Layla Odeh',
            'email' => 'layla.odeh@gmail.com',
            'password' => Hash::make('password'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | MORE LAWYERS
        |--------------------------------------------------------------------------
        */

        $moreLawyers = User::factory()
            ->lawyer()
            ->count(4)
            ->create();

        /*
        |--------------------------------------------------------------------------
        | MORE CLIENTS
        |--------------------------------------------------------------------------
        */

        $moreClients = User::factory()
            ->client()
            ->count(15)
            ->create();

        /*
        |--------------------------------------------------------------------------
        | BANNED CLIENT
        |--------------------------------------------------------------------------
        */

        User::factory()
            ->client()
            ->banned()
            ->create([
                'name' => 'Disputed Client',
                'email' => 'flagged.client@example.com',
            ]);

        /*
        |--------------------------------------------------------------------------
        | COLLECTIONS
        |--------------------------------------------------------------------------
        */

        $allLawyers = collect([
            $lawyerMarwan,
            $lawyerSara,
        ])->merge($moreLawyers);

        $allClients = collect([
            $clientAhmad,
            $clientLayla,
        ])->merge($moreClients);

        /*
        |--------------------------------------------------------------------------
        | MAIN CASE - MARWAN
        |--------------------------------------------------------------------------
        */

        $caseCrim = CaseFile::create([
            'case_number' => '2025255-CRIM',
            'client_id' => $clientAhmad->id,
            'lawyer_id' => $lawyerMarwan->id,
            'case_type' => 'Criminal Law',
            'description' => 'Client is contesting a civil dispute regarding a commercial lease agreement signed on 12 January 2024. Initial filing includes the original lease, correspondence with the landlord, and a notice of breach dated 30 April 2025.',
            'status' => 'opened',
            'start_date' => '2025-05-08',
            'end_date' => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | MAIN CASE - SARA
        |--------------------------------------------------------------------------
        */

        $caseCivil = CaseFile::create([
            'case_number' => '20251047-CIVL',
            'client_id' => $clientLayla->id,
            'lawyer_id' => $lawyerSara->id,
            'case_type' => 'Civil Law',
            'description' => 'Civil case involving a contractual dispute between the client and another party.',
            'status' => 'opened',
            'start_date' => '2025-05-09',
            'end_date' => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | CASE COLLECTION
        |--------------------------------------------------------------------------
        */

        $cases = collect([
            $caseCrim,
            $caseCivil,
        ]);

        /*
        |--------------------------------------------------------------------------
        | ADD MORE CASES
        |--------------------------------------------------------------------------
        */

        $allClients->each(function ($client) use ($allLawyers, &$cases) {

            $lawyer = $allLawyers->random();

            $numberOfCases = fake()->numberBetween(1, 3);

            for ($i = 0; $i < $numberOfCases; $i++) {

                $case = CaseFile::create([
                    'case_number' => strtoupper(
                        fake()->unique()->numerify('2026####-CASE')
                    ),

                    'client_id' => $client->id,

                    'lawyer_id' => $lawyer->id,

                    'case_type' => fake()->randomElement([
                        'Criminal Law',
                        'Civil Law',
                        'Family Law',
                        'Corporate Law',
                        'Property Law',
                    ]),

                    'description' => fake()->paragraph(3),

                    /*
                    |--------------------------------------------------------------------------
                    | IMPORTANT
                    | cases.status ONLY accepts opened / closed
                    |--------------------------------------------------------------------------
                    */

                    'status' => fake()->randomElement([
                        'opened',
                        'closed',
                    ]),

                    'start_date' => fake()
                        ->dateTimeBetween('-1 year', 'now')
                        ->format('Y-m-d'),

                    'end_date' => null,
                ]);

                $cases->push($case);
            }
        });

        /*
        |--------------------------------------------------------------------------
        | APPOINTMENTS
        |--------------------------------------------------------------------------
        */

        $cases->each(function (CaseFile $case) {

            $numberOfAppointments = fake()->numberBetween(1, 3);

            for ($i = 0; $i < $numberOfAppointments; $i++) {

                Appointment::create([
                    'case_id' => $case->id,

                    'client_id' => $case->client_id,

                    'lawyer_id' => $case->lawyer_id,

                    'appointment_date' => fake()
                        ->dateTimeBetween('now', '+30 days')
                        ->format('Y-m-d'),

                    'appointment_time' => fake()->randomElement([
                        '09:00:00',
                        '10:00:00',
                        '11:00:00',
                        '12:00:00',
                        '14:00:00',
                        '15:00:00',
                        '16:00:00',
                    ]),

                    'meeting_location' => fake()->randomElement([
                        'Law Firm Office',
                        'Conference Room A',
                        'Conference Room B',
                        'Online Meeting',
                    ]),

                    'note' => fake()->sentence(),

                    /*
                    |--------------------------------------------------------------------------
                    | appointments.status accepts:
                    | pending / scheduled / completed / rejected
                    |--------------------------------------------------------------------------
                    */

                    'status' => fake()->randomElement([
                        'pending',
                        'scheduled',
                        'completed',
                        'rejected',
                    ]),

                    'response' => null,

                    'is_new' => true,
                ]);
            }
        });

        /*
        |--------------------------------------------------------------------------
        | MESSAGES
        |--------------------------------------------------------------------------
        */

        $cases->each(function (CaseFile $case) {

            /*
            | Client -> Lawyer
            */

            Message::create([
                'case_id' => $case->id,

                'sender_id' => $case->client_id,

                'receiver_id' => $case->lawyer_id,

                'subject' => 'Case Update Request',

                'content' => 'Could you give me an update on where things stand with this case?',

                'is_new' => true,
            ]);

            /*
            | Lawyer -> Client
            */

            Message::create([
                'case_id' => $case->id,

                'sender_id' => $case->lawyer_id,

                'receiver_id' => $case->client_id,

                'subject' => 'Case Update',

                'content' => "I've reviewed the filing — we're on track. I'll follow up by end of week.",

                'is_new' => true,
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | DOCUMENTS
        |--------------------------------------------------------------------------
        */

        $cases->each(function (CaseFile $case) {

            $numberOfDocuments = fake()->numberBetween(1, 3);

            for ($i = 0; $i < $numberOfDocuments; $i++) {

                Document::create([
                    'case_id' => $case->id,

                    'uploaded_by' => $case->lawyer_id,

                    'title' => fake()->randomElement([
                        'Case Agreement',
                        'Court Document',
                        'Client Statement',
                        'Evidence Document',
                        'Legal Notice',
                    ]),

                    'file_path' => 'documents/demo-document.pdf',

                    'mime_type' => 'application/pdf',

                    'size_bytes' => fake()->numberBetween(
                        50000,
                        5000000
                    ),
                ]);
            }
        });

        /*
        |--------------------------------------------------------------------------
        | INVOICES
        |--------------------------------------------------------------------------
        |
        | invoices.status ONLY accepts:
        |
        | draft
        | sent
        | paid
        | overdue
        | void
        |
        |--------------------------------------------------------------------------
        */

        $cases->each(function (CaseFile $case) use ($accountant) {

            /*
            | Create invoices for approximately 70% of cases.
            */

            if (fake()->boolean(70)) {

                Invoice::create([
                    'case_id' => $case->id,

                    'client_id' => $case->client_id,

                    'accountant_id' => $accountant->id,

                    'amount' => fake()->randomFloat(
                        2,
                        300,
                        5000
                    ),

                    'status' => fake()->randomElement([
                        'draft',
                        'sent',
                        'paid',
                        'overdue',
                        'void',
                    ]),

                    'description' => 'Legal services invoice for case ' .
                        $case->case_number,

                    'due_date' => fake()
                        ->dateTimeBetween('now', '+60 days')
                        ->format('Y-m-d'),

                    'paid_at' => null,
                ]);
            }
        });

        /*
        |--------------------------------------------------------------------------
        | SEEDER OUTPUT
        |--------------------------------------------------------------------------
        */

        $this->command->info('');

        $this->command->info(
            '=============================================='
        );

        $this->command->info(
            '       DEMO DATA SEEDED SUCCESSFULLY'
        );

        $this->command->info(
            '=============================================='
        );

        $this->command->info('');

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT IDS
        |--------------------------------------------------------------------------
        */

        $this->command->info(
            "Admin ID: {$admin->id}"
        );

        $this->command->info(
            "Accountant ID: {$accountant->id}"
        );

        $this->command->info(
            "Marwan ID: {$lawyerMarwan->id}"
        );

        $this->command->info(
            "Sara ID: {$lawyerSara->id}"
        );

        $this->command->info('');

        /*
        |--------------------------------------------------------------------------
        | MARWAN DATA CHECK
        |--------------------------------------------------------------------------
        */

        $this->command->info(
            'Marwan Cases: ' .
            CaseFile::where(
                'lawyer_id',
                $lawyerMarwan->id
            )->count()
        );

        $this->command->info(
            'Marwan Opened Cases: ' .
            CaseFile::where(
                'lawyer_id',
                $lawyerMarwan->id
            )
                ->where('status', 'opened')
                ->count()
        );

        $this->command->info(
            'Marwan Appointments: ' .
            Appointment::where(
                'lawyer_id',
                $lawyerMarwan->id
            )->count()
        );

        $this->command->info(
            'Marwan Pending Appointments: ' .
            Appointment::where(
                'lawyer_id',
                $lawyerMarwan->id
            )
                ->where('status', 'pending')
                ->count()
        );

        $this->command->info(
            'Marwan Messages: ' .
            Message::where('sender_id', $lawyerMarwan->id)
                ->orWhere('receiver_id', $lawyerMarwan->id)
                ->count()
        );

        $this->command->info(
            'Marwan Documents: ' .
            Document::whereHas(
                'case',
                function ($query) use ($lawyerMarwan) {
                    $query->where(
                        'lawyer_id',
                        $lawyerMarwan->id
                    );
                }
            )->count()
        );

        $this->command->info(
            'Marwan Invoices: ' .
            Invoice::whereHas(
                'case',
                function ($query) use ($lawyerMarwan) {
                    $query->where(
                        'lawyer_id',
                        $lawyerMarwan->id
                    );
                }
            )->count()
        );

        $this->command->info('');

        /*
        |--------------------------------------------------------------------------
        | LOGIN INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->command->line(
            'ADMIN:'
        );

        $this->command->line(
            'mona.hanieh@whitfieldcole.com / password'
        );

        $this->command->info('');

        $this->command->line(
            'ACCOUNTANT:'
        );

        $this->command->line(
            'billing@whitfieldcole.com / password'
        );

        $this->command->info('');

        $this->command->line(
            'LAWYER 1:'
        );

        $this->command->line(
            'marwan.mohammed@whitfieldcole.com / password'
        );

        $this->command->info('');

        $this->command->line(
            'LAWYER 2:'
        );

        $this->command->line(
            'sara.haddad@whitfieldcole.com / password'
        );

        $this->command->info('');

        $this->command->line(
            'CLIENT:'
        );

        $this->command->line(
            'ahmad.ismail@gmail.com / password'
        );

        $this->command->info('');
    }
}