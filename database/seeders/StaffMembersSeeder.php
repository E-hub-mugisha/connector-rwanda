<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

/**
 * Staff i (user 12+i-1) works for provider i and is assigned to service i.
 */
class StaffMembersSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'id' => 1,
                'user_id' => 12,
                'service_provider_id' => 1,
                'staff_service_id' => 1,
                'phone' => '+250788000100',
                'address' => 'Kimironko, Kigali',
                'role' => 'manager',
                'status' => 'available',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'user_id' => 13,
                'service_provider_id' => 2,
                'staff_service_id' => 2,
                'phone' => '+250788000101',
                'address' => 'Remera, Kigali',
                'role' => 'staff',
                'status' => 'available',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'user_id' => 14,
                'service_provider_id' => 3,
                'staff_service_id' => 3,
                'phone' => '+250788000102',
                'address' => 'Kicukiro, Kigali',
                'role' => 'staff',
                'status' => 'available',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'user_id' => 15,
                'service_provider_id' => 4,
                'staff_service_id' => 4,
                'phone' => '+250788000103',
                'address' => 'Nyarutarama, Kigali',
                'role' => 'manager',
                'status' => 'available',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'user_id' => 16,
                'service_provider_id' => 5,
                'staff_service_id' => 5,
                'phone' => '+250788000104',
                'address' => 'Kacyiru, Kigali',
                'role' => 'staff',
                'status' => 'unavailable',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'user_id' => 17,
                'service_provider_id' => 6,
                'staff_service_id' => 6,
                'phone' => '+250788000105',
                'address' => 'Kibagabaga, Kigali',
                'role' => 'staff',
                'status' => 'available',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'user_id' => 18,
                'service_provider_id' => 7,
                'staff_service_id' => 7,
                'phone' => '+250788000106',
                'address' => 'Nyamirambo, Kigali',
                'role' => 'manager',
                'status' => 'available',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'user_id' => 19,
                'service_provider_id' => 8,
                'staff_service_id' => 8,
                'phone' => '+250788000107',
                'address' => 'Gikondo, Kigali',
                'role' => 'staff',
                'status' => 'available',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'user_id' => 20,
                'service_provider_id' => 9,
                'staff_service_id' => 9,
                'phone' => '+250788000108',
                'address' => 'Gisozi, Kigali',
                'role' => 'admin',
                'status' => 'available',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'user_id' => 21,
                'service_provider_id' => 10,
                'staff_service_id' => 10,
                'phone' => '+250788000109',
                'address' => 'Kanombe, Kigali',
                'role' => 'staff',
                'status' => 'available',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore => safe to re-run (explicit ids, duplicates are skipped)
        DB::table('staff_members')->insertOrIgnore($rows);
    }
}
