<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class StaffBookingsSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'id' => 1,
                'service_id' => 1,
                'staff_id' => 1,
                'status' => 'completed',
                'time' => '10:00',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'service_id' => 2,
                'staff_id' => 2,
                'status' => 'confirmed',
                'time' => '09:30',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'service_id' => 3,
                'staff_id' => 3,
                'status' => 'completed',
                'time' => '14:00',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'service_id' => 4,
                'staff_id' => 4,
                'status' => 'pending',
                'time' => '11:00',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'service_id' => 5,
                'staff_id' => 5,
                'status' => 'confirmed',
                'time' => '08:00',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'service_id' => 6,
                'staff_id' => 6,
                'status' => 'completed',
                'time' => '15:30',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'service_id' => 7,
                'staff_id' => 7,
                'status' => 'cancelled',
                'time' => '13:00',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'service_id' => 8,
                'staff_id' => 8,
                'status' => 'rescheduled',
                'time' => '16:00',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'service_id' => 9,
                'staff_id' => 9,
                'status' => 'pending',
                'time' => '07:00',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'service_id' => 10,
                'staff_id' => 10,
                'status' => 'cancelled',
                'time' => '12:30',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore => safe to re-run (explicit ids, duplicates are skipped)
        DB::table('staff_bookings')->insertOrIgnore($rows);
    }
}
