<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ServiceMediaSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'id' => 1,
                'service_id' => 1,
                'file_path' => 'uploads/service-media/signature-cut-blow-dry-gallery.jpg',
                'type' => 'image',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'service_id' => 2,
                'file_path' => 'uploads/service-media/knotless-box-braids-demo.mp4',
                'type' => 'video',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'service_id' => 3,
                'file_path' => 'uploads/service-media/classic-fade-beard-trim-gallery.jpg',
                'type' => 'image',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'service_id' => 4,
                'file_path' => 'uploads/service-media/gel-manicure-gallery.jpg',
                'type' => 'image',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'service_id' => 5,
                'file_path' => 'uploads/service-media/bridal-event-makeup-gallery.jpg',
                'type' => 'image',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'service_id' => 6,
                'file_path' => 'uploads/service-media/deep-cleansing-facial-gallery.jpg',
                'type' => 'image',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'service_id' => 7,
                'file_path' => 'uploads/service-media/full-body-relaxation-massage-demo.mp4',
                'type' => 'video',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'service_id' => 8,
                'file_path' => 'uploads/service-media/full-body-waxing-gallery.jpg',
                'type' => 'image',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'service_id' => 9,
                'file_path' => 'uploads/service-media/bridal-hair-makeup-package-gallery.jpg',
                'type' => 'image',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'service_id' => 10,
                'file_path' => 'uploads/service-media/classic-lash-extensions-gallery.jpg',
                'type' => 'image',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore => safe to re-run (explicit ids, duplicates are skipped)
        DB::table('service_media')->insertOrIgnore($rows);
    }
}
