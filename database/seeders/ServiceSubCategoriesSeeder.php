<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ServiceSubCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'id' => 1,
                'name' => 'Haircut & Styling',
                'slug' => 'haircut-styling',
                'service_category_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'Hair Coloring',
                'slug' => 'hair-coloring',
                'service_category_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'Box Braids & Twists',
                'slug' => 'box-braids-twists',
                'service_category_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'name' => 'Weaves & Wigs',
                'slug' => 'weaves-wigs',
                'service_category_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'name' => 'Fades & Shaves',
                'slug' => 'fades-shaves',
                'service_category_id' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'name' => 'Manicure',
                'slug' => 'manicure',
                'service_category_id' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'name' => 'Pedicure',
                'slug' => 'pedicure',
                'service_category_id' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'name' => 'Event & Bridal Makeup',
                'slug' => 'event-bridal-makeup',
                'service_category_id' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'name' => 'Facial Treatments',
                'slug' => 'facial-treatments',
                'service_category_id' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'name' => 'Full Body Massage',
                'slug' => 'full-body-massage',
                'service_category_id' => 7,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore => safe to re-run (explicit ids, duplicates are skipped)
        DB::table('service_sub_categories')->insertOrIgnore($rows);
    }
}
