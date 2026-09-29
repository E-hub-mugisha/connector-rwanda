<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ServiceCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'id' => 1,
                'name' => 'Hair Styling',
                'slug' => 'hair-styling',
                'image' => 'uploads/categories/hair-styling.jpg',
                'featured' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'Braids & Weaves',
                'slug' => 'braids-weaves',
                'image' => 'uploads/categories/braids-weaves.jpg',
                'featured' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'Barbershop',
                'slug' => 'barbershop',
                'image' => 'uploads/categories/barbershop.jpg',
                'featured' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'name' => 'Nails',
                'slug' => 'nails',
                'image' => 'uploads/categories/nails.jpg',
                'featured' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'name' => 'Makeup',
                'slug' => 'makeup',
                'image' => 'uploads/categories/makeup.jpg',
                'featured' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'name' => 'Skincare & Facials',
                'slug' => 'skincare-facials',
                'image' => 'uploads/categories/skincare-facials.jpg',
                'featured' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'name' => 'Massage & Spa',
                'slug' => 'massage-spa',
                'image' => 'uploads/categories/massage-spa.jpg',
                'featured' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'name' => 'Waxing & Threading',
                'slug' => 'waxing-threading',
                'image' => 'uploads/categories/waxing-threading.jpg',
                'featured' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'name' => 'Bridal Beauty',
                'slug' => 'bridal-beauty',
                'image' => 'uploads/categories/bridal-beauty.jpg',
                'featured' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'name' => 'Lashes & Brows',
                'slug' => 'lashes-brows',
                'image' => 'uploads/categories/lashes-brows.jpg',
                'featured' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore => safe to re-run (explicit ids, duplicates are skipped)
        DB::table('service_categories')->insertOrIgnore($rows);
    }
}
