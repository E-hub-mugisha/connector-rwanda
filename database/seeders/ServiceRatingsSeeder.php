<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ServiceRatingsSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'id' => 1,
                'user_id' => 22,
                'service_id' => 1,
                'rating' => 5,
                'comment' => 'Loved the cut, my hair felt amazing all week.',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'user_id' => 23,
                'service_id' => 2,
                'rating' => 5,
                'comment' => 'Braids were neat and lightweight. Worth the time.',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'user_id' => 24,
                'service_id' => 3,
                'rating' => 5,
                'comment' => 'Best fade in Kicukiro, always consistent.',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'user_id' => 25,
                'service_id' => 4,
                'rating' => 4,
                'comment' => 'Beautiful finish, lasted 2 weeks with no chips.',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'user_id' => 26,
                'service_id' => 5,
                'rating' => 5,
                'comment' => 'Makeup looked flawless in photos.',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'user_id' => 27,
                'service_id' => 6,
                'rating' => 4,
                'comment' => 'My skin feels so fresh and clean.',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'user_id' => 28,
                'service_id' => 7,
                'rating' => 5,
                'comment' => 'Very relaxing, the therapist was excellent.',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'user_id' => 29,
                'service_id' => 8,
                'rating' => 4,
                'comment' => 'A little painful but professional and hygienic.',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'user_id' => 30,
                'service_id' => 9,
                'rating' => 5,
                'comment' => 'Perfect bridal look, everyone complimented it.',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'user_id' => 31,
                'service_id' => 10,
                'rating' => 3,
                'comment' => 'Lashes looked natural but the wait was long.',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore => safe to re-run (explicit ids, duplicates are skipped)
        DB::table('service_ratings')->insertOrIgnore($rows);
    }
}
