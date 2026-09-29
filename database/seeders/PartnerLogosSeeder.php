<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

/**
 * Sample/fictional partner names - replace with real partners before launch.
 */
class PartnerLogosSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'id' => 1,
                'name' => 'Kigali Beauty Academy',
                'image' => 'uploads/partners/partner-1.png',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'Rwanda Salon Association',
                'image' => 'uploads/partners/partner-2.png',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'Inyange Naturals',
                'image' => 'uploads/partners/partner-3.png',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'name' => 'Umucyo Skincare',
                'image' => 'uploads/partners/partner-4.png',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'name' => 'Amahoro Cosmetics',
                'image' => 'uploads/partners/partner-5.png',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'name' => 'Kivu Shea Co.',
                'image' => 'uploads/partners/partner-6.png',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'name' => 'Imena Hair Products',
                'image' => 'uploads/partners/partner-7.png',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'name' => 'Nyungwe Organics',
                'image' => 'uploads/partners/partner-8.png',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'name' => 'Mutuelle Wellness',
                'image' => 'uploads/partners/partner-9.png',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'name' => 'Rwanda Youth Beauty Network',
                'image' => 'uploads/partners/partner-10.png',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore => safe to re-run (explicit ids, duplicates are skipped)
        DB::table('partner_logos')->insertOrIgnore($rows);
    }
}
