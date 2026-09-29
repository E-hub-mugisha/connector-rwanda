<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ServiceProviderRatingsSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'id' => 1,
                'user_id' => 23,
                'service_provider_id' => 1,
                'rating' => 5,
                'comment' => 'Friendly team and a clean salon.',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'user_id' => 24,
                'service_provider_id' => 2,
                'rating' => 5,
                'comment' => 'Very skilled braiders, great communication.',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'user_id' => 25,
                'service_provider_id' => 3,
                'rating' => 4,
                'comment' => 'Professional and on time.',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'user_id' => 26,
                'service_provider_id' => 4,
                'rating' => 5,
                'comment' => 'Lovely nail bar with a calm vibe.',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'user_id' => 27,
                'service_provider_id' => 5,
                'rating' => 5,
                'comment' => 'Talented and kind artist.',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'user_id' => 28,
                'service_provider_id' => 6,
                'rating' => 4,
                'comment' => 'Knowledgeable about skin, gave good advice.',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'user_id' => 29,
                'service_provider_id' => 7,
                'rating' => 5,
                'comment' => 'Peaceful spa, will return.',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'user_id' => 30,
                'service_provider_id' => 8,
                'rating' => 4,
                'comment' => 'Hygienic and gentle.',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'user_id' => 31,
                'service_provider_id' => 9,
                'rating' => 5,
                'comment' => 'Made our wedding day stress-free.',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'user_id' => 22,
                'service_provider_id' => 10,
                'rating' => 3,
                'comment' => 'Good work, could improve scheduling.',
                'status' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore => safe to re-run (explicit ids, duplicates are skipped)
        DB::table('service_provider_ratings')->insertOrIgnore($rows);
    }
}
