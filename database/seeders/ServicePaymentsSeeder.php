<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ServicePaymentsSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'id' => 1,
                'booking_id' => 1,
                'user_id' => 22,
                'amount' => 10800,
                'payment_method' => 'MTN MoMo',
                'transaction_id' => 'TXN-2026-001001',
                'status' => 'successful',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'booking_id' => 2,
                'user_id' => 23,
                'amount' => 40000,
                'payment_method' => 'Airtel Money',
                'transaction_id' => 'TXN-2026-001002',
                'status' => 'successful',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'booking_id' => 3,
                'user_id' => 24,
                'amount' => 6000,
                'payment_method' => 'Cash',
                'transaction_id' => 'TXN-2026-001003',
                'status' => 'successful',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'booking_id' => 4,
                'user_id' => 25,
                'amount' => 13000,
                'payment_method' => 'MTN MoMo',
                'transaction_id' => 'TXN-2026-001004',
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'booking_id' => 5,
                'user_id' => 26,
                'amount' => 60000,
                'payment_method' => 'Card',
                'transaction_id' => 'TXN-2026-001005',
                'status' => 'successful',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'booking_id' => 6,
                'user_id' => 27,
                'amount' => 29750,
                'payment_method' => 'MTN MoMo',
                'transaction_id' => 'TXN-2026-001006',
                'status' => 'successful',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'booking_id' => 7,
                'user_id' => 28,
                'amount' => 40000,
                'payment_method' => 'Cash',
                'transaction_id' => 'TXN-2026-001007',
                'status' => 'failed',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'booking_id' => 8,
                'user_id' => 29,
                'amount' => 25000,
                'payment_method' => 'Airtel Money',
                'transaction_id' => 'TXN-2026-001008',
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'booking_id' => 9,
                'user_id' => 30,
                'amount' => 130000,
                'payment_method' => 'Card',
                'transaction_id' => 'TXN-2026-001009',
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'booking_id' => 10,
                'user_id' => 31,
                'amount' => 30000,
                'payment_method' => 'MTN MoMo',
                'transaction_id' => 'TXN-2026-001010',
                'status' => 'failed',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore => safe to re-run (explicit ids, duplicates are skipped)
        DB::table('service_payments')->insertOrIgnore($rows);
    }
}
