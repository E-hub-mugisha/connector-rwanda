<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

/**
 * 10 rows: provider 1 has a full week, provider 2 has Mon/Sat/Sun. Add more days per provider as needed.
 */
class WorkingHoursSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'id' => 1,
                'service_provider_id' => 1,
                'day' => 'Monday',
                'start_time' => '08:00:00',
                'end_time' => '18:00:00',
                'is_closed' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'service_provider_id' => 1,
                'day' => 'Tuesday',
                'start_time' => '08:00:00',
                'end_time' => '18:00:00',
                'is_closed' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'service_provider_id' => 1,
                'day' => 'Wednesday',
                'start_time' => '08:00:00',
                'end_time' => '18:00:00',
                'is_closed' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'service_provider_id' => 1,
                'day' => 'Thursday',
                'start_time' => '08:00:00',
                'end_time' => '18:00:00',
                'is_closed' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'service_provider_id' => 1,
                'day' => 'Friday',
                'start_time' => '08:00:00',
                'end_time' => '18:00:00',
                'is_closed' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'service_provider_id' => 1,
                'day' => 'Saturday',
                'start_time' => '09:00:00',
                'end_time' => '16:00:00',
                'is_closed' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'service_provider_id' => 1,
                'day' => 'Sunday',
                'start_time' => null,
                'end_time' => null,
                'is_closed' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'service_provider_id' => 2,
                'day' => 'Monday',
                'start_time' => '07:30:00',
                'end_time' => '19:00:00',
                'is_closed' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'service_provider_id' => 2,
                'day' => 'Saturday',
                'start_time' => '07:30:00',
                'end_time' => '20:00:00',
                'is_closed' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'service_provider_id' => 2,
                'day' => 'Sunday',
                'start_time' => null,
                'end_time' => null,
                'is_closed' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore => safe to re-run (explicit ids, duplicates are skipped)
        DB::table('working_hours')->insertOrIgnore($rows);
    }
}
