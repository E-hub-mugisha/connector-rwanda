<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@jobportal.test',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'), // default password
                'remember_token' => Str::random(10),
                'utype' => 'ADM', // Admin
                'phone' => '+250780000001',
                'address' => 'Kigali, Rwanda',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Eric Mugisha',
                'email' => 'eric@serviceprovider.test',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'utype' => 'SVP', // Service Provider
                'phone' => '+250780000002',
                'address' => 'Huye, Rwanda',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'jane@client.test',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'utype' => 'CST', // Customer/Client
                'phone' => '+250780000003',
                'address' => 'Musanze, Rwanda',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'John Smith',
                'email' => 'john@client.test',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'utype' => 'CST',
                'phone' => '+250780000004',
                'address' => 'Rubavu, Rwanda',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Claudine Uwase',
                'email' => 'claudine@provider.test',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'utype' => 'SVP',
                'phone' => '+250780000005',
                'address' => 'Kigali, Rwanda',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
