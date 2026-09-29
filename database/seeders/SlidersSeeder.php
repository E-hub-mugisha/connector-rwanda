<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SlidersSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'id' => 1,
                'title' => 'Look Good. Feel Great.',
                'image' => 'uploads/sliders/slide-1.jpg',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'title' => 'Book Trusted Beauty Pros in Kigali',
                'image' => 'uploads/sliders/slide-2.jpg',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'title' => 'Braids, Weaves & Protective Styles',
                'image' => 'uploads/sliders/slide-3.jpg',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'title' => 'Bridal Beauty Made Easy',
                'image' => 'uploads/sliders/slide-4.jpg',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'title' => 'Relax with a Spa Day',
                'image' => 'uploads/sliders/slide-5.jpg',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'title' => 'Glowing Skin Starts Here',
                'image' => 'uploads/sliders/slide-6.jpg',
                'status' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'title' => 'Sharp Cuts at the Barbershop',
                'image' => 'uploads/sliders/slide-7.jpg',
                'status' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'title' => 'Nails Done Right',
                'image' => 'uploads/sliders/slide-8.jpg',
                'status' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'title' => 'Lashes & Brows Perfected',
                'image' => 'uploads/sliders/slide-9.jpg',
                'status' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'title' => 'Exclusive Offers This Month',
                'image' => 'uploads/sliders/slide-10.jpg',
                'status' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore => safe to re-run (explicit ids, duplicates are skipped)
        DB::table('sliders')->insertOrIgnore($rows);
    }
}
