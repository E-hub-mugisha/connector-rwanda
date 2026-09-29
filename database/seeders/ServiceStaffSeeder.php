<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ServiceStaffSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'id' => 1,
                'staff_member_id' => 1,
                'service_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'staff_member_id' => 2,
                'service_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'staff_member_id' => 3,
                'service_id' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'staff_member_id' => 4,
                'service_id' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'staff_member_id' => 5,
                'service_id' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'staff_member_id' => 6,
                'service_id' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'staff_member_id' => 7,
                'service_id' => 7,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'staff_member_id' => 8,
                'service_id' => 8,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'staff_member_id' => 9,
                'service_id' => 9,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'staff_member_id' => 10,
                'service_id' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore => safe to re-run (explicit ids, duplicates are skipped)
        DB::table('service_staff')->insertOrIgnore($rows);
    }
}
