<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PromotionsSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'id' => 1,
                'service_id' => 1,
                'title' => 'Weekday Blow-dry Special',
                'description' => 'Book a cut and blow-dry Monday to Thursday and save.',
                'discount' => 10.0,
                'start_date' => Carbon::now()->addDays(0)->toDateString(),
                'end_date' => Carbon::now()->addDays(30)->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'service_id' => 2,
                'title' => 'Braids Season Offer',
                'description' => 'Discount on knotless box braids all month.',
                'discount' => 15.0,
                'start_date' => Carbon::now()->addDays(-5)->toDateString(),
                'end_date' => Carbon::now()->addDays(25)->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'service_id' => 3,
                'title' => 'Father\'s Cut Combo',
                'description' => 'Fade and beard trim for dads and sons.',
                'discount' => 12.5,
                'start_date' => Carbon::now()->addDays(0)->toDateString(),
                'end_date' => Carbon::now()->addDays(14)->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'service_id' => 4,
                'title' => 'Gel Manicure Duo',
                'description' => 'Bring a friend and both get a discount.',
                'discount' => 10.0,
                'start_date' => Carbon::now()->addDays(2)->toDateString(),
                'end_date' => Carbon::now()->addDays(20)->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'service_id' => 5,
                'title' => 'Wedding Season Glam',
                'description' => 'Early-bird pricing for bridal and event makeup.',
                'discount' => 8.0,
                'start_date' => Carbon::now()->addDays(0)->toDateString(),
                'end_date' => Carbon::now()->addDays(60)->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'service_id' => 6,
                'title' => 'Glow Facial Month',
                'description' => 'Save on deep cleansing facials this month.',
                'discount' => 15.0,
                'start_date' => Carbon::now()->addDays(0)->toDateString(),
                'end_date' => Carbon::now()->addDays(30)->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'service_id' => 7,
                'title' => 'Relax & Recharge',
                'description' => 'Full-body massage discount for first-time guests.',
                'discount' => 20.0,
                'start_date' => Carbon::now()->addDays(1)->toDateString(),
                'end_date' => Carbon::now()->addDays(21)->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'service_id' => 8,
                'title' => 'Smooth Start Waxing',
                'description' => 'First-time waxing clients save on full-body sessions.',
                'discount' => 18.0,
                'start_date' => Carbon::now()->addDays(0)->toDateString(),
                'end_date' => Carbon::now()->addDays(45)->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'service_id' => 9,
                'title' => 'Bridal Package Early Bird',
                'description' => 'Book your bridal package 3 months ahead and save.',
                'discount' => 13.0,
                'start_date' => Carbon::now()->addDays(0)->toDateString(),
                'end_date' => Carbon::now()->addDays(90)->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'service_id' => 10,
                'title' => 'Lash Launch Offer',
                'description' => 'Introductory price on classic lash sets.',
                'discount' => 25.0,
                'start_date' => Carbon::now()->addDays(3)->toDateString(),
                'end_date' => Carbon::now()->addDays(30)->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore => safe to re-run (explicit ids, duplicates are skipped)
        DB::table('promotions')->insertOrIgnore($rows);
    }
}
