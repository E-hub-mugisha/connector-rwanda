<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PortfoliosSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'id' => 1,
                'tag' => 'Hair',
                'image' => 'uploads/portfolio/hair-1.jpg',
                'service_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'tag' => 'Braids',
                'image' => 'uploads/portfolio/braids-2.jpg',
                'service_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'tag' => 'Barbershop',
                'image' => 'uploads/portfolio/barbershop-3.jpg',
                'service_id' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'tag' => 'Nails',
                'image' => 'uploads/portfolio/nails-4.jpg',
                'service_id' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'tag' => 'Makeup',
                'image' => 'uploads/portfolio/makeup-5.jpg',
                'service_id' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'tag' => 'Skincare',
                'image' => 'uploads/portfolio/skincare-6.jpg',
                'service_id' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'tag' => 'Spa',
                'image' => 'uploads/portfolio/spa-7.jpg',
                'service_id' => 7,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'tag' => 'Waxing',
                'image' => 'uploads/portfolio/waxing-8.jpg',
                'service_id' => 8,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'tag' => 'Bridal',
                'image' => 'uploads/portfolio/bridal-9.jpg',
                'service_id' => 9,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'tag' => 'Lashes',
                'image' => 'uploads/portfolio/lashes-10.jpg',
                'service_id' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore => safe to re-run (explicit ids, duplicates are skipped)
        DB::table('portfolios')->insertOrIgnore($rows);
    }
}
