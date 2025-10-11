<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ServiceProvidersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch all user IDs (assuming employers exist in 'users' table)
        $userIds = DB::table('users')->pluck('id')->toArray();

        if (empty($userIds)) {
            $this->command->warn('⚠️ No users found. Please seed the users table first.');
            return;
        }

        // Optional: fetch service category IDs if they exist
        $categoryIds = DB::table('service_categories')->pluck('id')->toArray();
        $hasCategories = !empty($categoryIds);

        $providers = [
            [
                'user_id' => $userIds[array_rand($userIds)],
                'sprovider_name' => 'Tech Solutions Ltd',
                'proEmail' => 'contact@techsolutions.rw',
                'image' => 'providers/tech_solutions.png',
                'about' => 'We are a Kigali-based IT firm specializing in custom web applications and digital transformation solutions.',
                'skills' => 'Laravel, React, Node.js, UX/UI Design',
                'qualification' => 'Certified Laravel Developer, BSc in Computer Science',
                'experience' => '5+ years in full-stack web development',
                'city' => 'Kigali',
                'service_category_id' => $hasCategories ? $categoryIds[array_rand($categoryIds)] : null,
                'service_locations' => 'Kigali, Huye, Musanze',
                'status' => 'approved',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $userIds[array_rand($userIds)],
                'sprovider_name' => 'Creative Studio Africa',
                'proEmail' => 'hello@creativestudio.africa',
                'image' => 'providers/creative_studio.png',
                'about' => 'A creative agency offering professional graphic design, branding, and animation services.',
                'skills' => 'Photoshop, Illustrator, After Effects, Branding',
                'qualification' => 'Diploma in Graphic Design',
                'experience' => '3 years of professional design experience',
                'city' => 'Huye',
                'service_category_id' => $hasCategories ? $categoryIds[array_rand($categoryIds)] : null,
                'service_locations' => 'Huye, Nyanza, Kigali',
                'status' => 'approved',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $userIds[array_rand($userIds)],
                'sprovider_name' => 'BuildRight Construction Co.',
                'proEmail' => 'info@buildright.rw',
                'image' => 'providers/buildright.png',
                'about' => 'Providing reliable construction and renovation services across Rwanda.',
                'skills' => 'Masonry, Carpentry, Project Management',
                'qualification' => 'Civil Engineering Certification',
                'experience' => '7 years of experience in construction and civil projects',
                'city' => 'Rubavu',
                'service_category_id' => $hasCategories ? $categoryIds[array_rand($categoryIds)] : null,
                'service_locations' => 'Rubavu, Musanze',
                'status' => 'approved',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $userIds[array_rand($userIds)],
                'sprovider_name' => 'GreenLeaf Landscaping',
                'proEmail' => 'contact@greenleaf.rw',
                'image' => 'providers/greenleaf.png',
                'about' => 'Experts in modern landscaping, garden design, and outdoor maintenance services.',
                'skills' => 'Landscaping, Garden Maintenance, Irrigation Systems',
                'qualification' => 'Certificate in Environmental Design',
                'experience' => '4 years in landscaping and outdoor projects',
                'city' => 'Musanze',
                'service_category_id' => $hasCategories ? $categoryIds[array_rand($categoryIds)] : null,
                'service_locations' => 'Musanze, Kigali',
                'status' => 'approved',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $userIds[array_rand($userIds)],
                'sprovider_name' => 'SafeHands Cleaning Services',
                'proEmail' => 'support@safehands.rw',
                'image' => 'providers/safehands.png',
                'about' => 'A professional cleaning service company dedicated to hygiene and customer satisfaction.',
                'skills' => 'Cleaning, Sanitation, Customer Care',
                'qualification' => 'Professional Cleaning Certification',
                'experience' => '3 years in industrial and residential cleaning',
                'city' => 'Kigali',
                'service_category_id' => $hasCategories ? $categoryIds[array_rand($categoryIds)] : null,
                'service_locations' => 'Kigali, Gicumbi',
                'status' => 'approved',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('service_providers')->insert($providers);
    }
}
