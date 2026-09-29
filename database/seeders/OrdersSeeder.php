<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

/**
 * Beauty product/gift orders. total = subtotal + RWF 2,000 delivery.
 */
class OrdersSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'id' => 1,
                'user_id' => 22,
                'status' => 'completed',
                'subtotal' => 18000,
                'total' => 20000,
                'payment_method' => 'MTN MoMo',
                'names' => 'Kevine Ishimwe',
                'email' => 'kevine.ishimwe@example.com',
                'phone' => '+250789110200',
                'location' => 'Kimironko, Kigali',
                'notes' => 'Gift set: shea butter + argan oil',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'user_id' => 23,
                'status' => 'completed',
                'subtotal' => 25000,
                'total' => 27000,
                'payment_method' => 'Airtel Money',
                'names' => 'Yvonne Uwineza',
                'email' => 'yvonne.uwineza@example.com',
                'phone' => '+250789110201',
                'location' => 'Remera, Kigali',
                'notes' => 'Hair care bundle',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'user_id' => 24,
                'status' => 'processing',
                'subtotal' => 32000,
                'total' => 34000,
                'payment_method' => 'Cash',
                'names' => 'Didier Nshimiyimana',
                'email' => 'didier.nshimiyimana@example.com',
                'phone' => '+250789110202',
                'location' => 'Kicukiro, Kigali',
                'notes' => 'Skincare starter kit',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'user_id' => 25,
                'status' => 'pending',
                'subtotal' => 9500,
                'total' => 11500,
                'payment_method' => 'MTN MoMo',
                'names' => 'Bella Kamikazi',
                'email' => 'bella.kamikazi@example.com',
                'phone' => '+250789110203',
                'location' => 'Nyarutarama, Kigali',
                'notes' => 'Nail polish set (3 colours)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'user_id' => 26,
                'status' => 'completed',
                'subtotal' => 45000,
                'total' => 47000,
                'payment_method' => 'Card',
                'names' => 'Christian Mugisha',
                'email' => 'christian.mugisha@example.com',
                'phone' => '+250789110204',
                'location' => 'Kacyiru, Kigali',
                'notes' => 'Bridal gift hamper',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'user_id' => 27,
                'status' => 'decline',
                'subtotal' => 12000,
                'total' => 14000,
                'payment_method' => 'MTN MoMo',
                'names' => 'Alice Mutesi',
                'email' => 'alice.mutesi@example.com',
                'phone' => '+250789110205',
                'location' => 'Kibagabaga, Kigali',
                'notes' => 'Lip & cheek tint duo',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'user_id' => 28,
                'status' => 'processing',
                'subtotal' => 27500,
                'total' => 29500,
                'payment_method' => 'Cash',
                'names' => 'Joseph Kagabo',
                'email' => 'joseph.kagabo@example.com',
                'phone' => '+250789110206',
                'location' => 'Nyamirambo, Kigali',
                'notes' => 'Body scrub + lotion',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'user_id' => 29,
                'status' => 'pending',
                'subtotal' => 8000,
                'total' => 10000,
                'payment_method' => 'Airtel Money',
                'names' => 'Nadine Uwitonze',
                'email' => 'nadine.uwitonze@example.com',
                'phone' => '+250789110207',
                'location' => 'Gikondo, Kigali',
                'notes' => 'Beard oil',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'user_id' => 30,
                'status' => 'completed',
                'subtotal' => 60000,
                'total' => 62000,
                'payment_method' => 'Card',
                'names' => 'Prince Rukundo',
                'email' => 'prince.rukundo@example.com',
                'phone' => '+250789110208',
                'location' => 'Gisozi, Kigali',
                'notes' => 'Makeup brush set',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'user_id' => 31,
                'status' => 'pending',
                'subtotal' => 15000,
                'total' => 17000,
                'payment_method' => 'MTN MoMo',
                'names' => 'Elyse Umuhoza',
                'email' => 'elyse.umuhoza@example.com',
                'phone' => '+250789110209',
                'location' => 'Kanombe, Kigali',
                'notes' => 'Lash serum',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore => safe to re-run (explicit ids, duplicates are skipped)
        DB::table('orders')->insertOrIgnore($rows);
    }
}
