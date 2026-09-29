<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ContactsSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'id' => 1,
                'name' => 'Kevine Ishimwe',
                'email' => 'kevine.ishimwe@example.com',
                'phone' => '+250789220300',
                'subject' => 'Partnership inquiry',
                'message' => 'We would like to list our salon on the platform. What are the steps?',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'Yvonne Uwineza',
                'email' => 'yvonne.uwineza@example.com',
                'phone' => '+250789220301',
                'subject' => 'Booking question',
                'message' => 'Can I reschedule my appointment to next week?',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'Didier Nshimiyimana',
                'email' => 'didier.nshimiyimana@example.com',
                'phone' => '+250789220302',
                'subject' => 'Provider application',
                'message' => 'How long does provider approval take?',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'name' => 'Bella Kamikazi',
                'email' => 'bella.kamikazi@example.com',
                'phone' => '+250789220303',
                'subject' => 'Payment issue',
                'message' => 'My MTN MoMo payment was deducted but the booking still shows pending.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'name' => 'Christian Mugisha',
                'email' => 'christian.mugisha@example.com',
                'phone' => '+250789220304',
                'subject' => 'Corporate bookings',
                'message' => 'Do you offer group bookings for a company event?',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'name' => 'Alice Mutesi',
                'email' => 'alice.mutesi@example.com',
                'phone' => '+250789220305',
                'subject' => 'Feedback',
                'message' => 'Great platform, would love to see more spa providers in Musanze.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'name' => 'Joseph Kagabo',
                'email' => 'joseph.kagabo@example.com',
                'phone' => '+250789220306',
                'subject' => 'Refund request',
                'message' => 'My stylist cancelled, how do I get a refund?',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'name' => 'Nadine Uwitonze',
                'email' => 'nadine.uwitonze@example.com',
                'phone' => '+250789220307',
                'subject' => 'Bridal packages',
                'message' => 'Do any providers offer packages for a full bridal party?',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'name' => 'Prince Rukundo',
                'email' => 'prince.rukundo@example.com',
                'phone' => '+250789220308',
                'subject' => 'Account help',
                'message' => 'I cannot log in to my account.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'name' => 'Elyse Umuhoza',
                'email' => 'elyse.umuhoza@example.com',
                'phone' => '+250789220309',
                'subject' => 'Advertising',
                'message' => 'What are the options for advertising my products here?',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore => safe to re-run (explicit ids, duplicates are skipped)
        DB::table('contacts')->insertOrIgnore($rows);
    }
}
