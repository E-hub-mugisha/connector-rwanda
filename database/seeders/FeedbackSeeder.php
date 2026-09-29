<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class FeedbackSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'id' => 1,
                'name' => 'Kevine Ishimwe',
                'email' => 'kevine.ishimwe@example.com',
                'Service_Provider_ID' => 1,
                'message' => 'Great service, thank you for making me feel welcome.',
                'approved' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'Yvonne Uwineza',
                'email' => 'yvonne.uwineza@example.com',
                'Service_Provider_ID' => 2,
                'message' => 'Booking was easy and the braids came out perfect.',
                'approved' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'Didier Nshimiyimana',
                'email' => 'didier.nshimiyimana@example.com',
                'Service_Provider_ID' => 3,
                'message' => 'Very clean shop and friendly barbers.',
                'approved' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'name' => 'Bella Kamikazi',
                'email' => 'bella.kamikazi@example.com',
                'Service_Provider_ID' => 4,
                'message' => 'My nails are still perfect after two weeks.',
                'approved' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'name' => 'Christian Mugisha',
                'email' => 'christian.mugisha@example.com',
                'Service_Provider_ID' => 5,
                'message' => 'Thank you for the beautiful makeup on my graduation day.',
                'approved' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'name' => 'Alice Mutesi',
                'email' => 'alice.mutesi@example.com',
                'Service_Provider_ID' => 6,
                'message' => 'My skin has improved a lot since my first visit.',
                'approved' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'name' => 'Joseph Kagabo',
                'email' => 'joseph.kagabo@example.com',
                'Service_Provider_ID' => 7,
                'message' => 'The massage was exactly what I needed after a busy week.',
                'approved' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'name' => 'Nadine Uwitonze',
                'email' => 'nadine.uwitonze@example.com',
                'Service_Provider_ID' => 8,
                'message' => 'Quick, gentle and professional.',
                'approved' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'name' => 'Prince Rukundo',
                'email' => 'prince.rukundo@example.com',
                'Service_Provider_ID' => 9,
                'message' => 'Our bridal party looked stunning, thank you!',
                'approved' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'name' => 'Elyse Umuhoza',
                'email' => 'elyse.umuhoza@example.com',
                'Service_Provider_ID' => 10,
                'message' => 'Loved my lashes, will book again.',
                'approved' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore => safe to re-run (explicit ids, duplicates are skipped)
        DB::table('feedback')->insertOrIgnore($rows);
    }
}
