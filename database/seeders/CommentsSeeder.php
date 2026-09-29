<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CommentsSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'id' => 1,
                'blog_id' => 1,
                'user_id' => 22,
                'comment_body' => 'Very helpful, thank you!',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'blog_id' => 2,
                'user_id' => 23,
                'comment_body' => 'I tried this and it worked well.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'blog_id' => 3,
                'user_id' => 24,
                'comment_body' => 'Great advice, sharing with my sister.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'blog_id' => 4,
                'user_id' => 25,
                'comment_body' => 'Which product do you recommend for this?',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'blog_id' => 5,
                'user_id' => 26,
                'comment_body' => 'Book marked for my wedding prep.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'blog_id' => 6,
                'user_id' => 27,
                'comment_body' => 'Love this routine.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'blog_id' => 7,
                'user_id' => 28,
                'comment_body' => 'Can you write one about hair growth?',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'blog_id' => 8,
                'user_id' => 29,
                'comment_body' => 'Very informative.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'blog_id' => 9,
                'user_id' => 30,
                'comment_body' => 'Needed this before my big day.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'blog_id' => 10,
                'user_id' => 31,
                'comment_body' => 'Thanks for the tips!',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore => safe to re-run (explicit ids, duplicates are skipped)
        DB::table('comments')->insertOrIgnore($rows);
    }
}
