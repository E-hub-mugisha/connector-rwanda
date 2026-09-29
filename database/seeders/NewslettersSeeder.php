<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class NewslettersSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'id' => 1,
                'name' => 'Kevine Ishimwe',
                'email' => 'news.kevine.ishimwe@example.com',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'Yvonne Uwineza',
                'email' => 'news.yvonne.uwineza@example.com',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'Didier Nshimiyimana',
                'email' => 'news.didier.nshimiyimana@example.com',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'name' => 'Bella Kamikazi',
                'email' => 'news.bella.kamikazi@example.com',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'name' => 'Christian Mugisha',
                'email' => 'news.christian.mugisha@example.com',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'name' => 'Alice Mutesi',
                'email' => 'news.alice.mutesi@example.com',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'name' => 'Joseph Kagabo',
                'email' => 'news.joseph.kagabo@example.com',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'name' => 'Nadine Uwitonze',
                'email' => 'news.nadine.uwitonze@example.com',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'name' => 'Prince Rukundo',
                'email' => 'news.prince.rukundo@example.com',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'name' => 'Elyse Umuhoza',
                'email' => 'news.elyse.umuhoza@example.com',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore => safe to re-run (explicit ids, duplicates are skipped)
        DB::table('newsletters')->insertOrIgnore($rows);
    }
}
