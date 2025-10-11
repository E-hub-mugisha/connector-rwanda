<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class JobsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Example company IDs (must exist in service_providers table)
        $companyIds = DB::table('service_providers')->pluck('id')->toArray();

        if (empty($companyIds)) {
            $this->command->warn('No service providers found — please seed service_providers first.');
            return;
        }

        $jobs = [
            [
                'title' => 'Full Stack Web Developer',
                'description' => 'We are looking for a skilled full stack developer to join our team and build dynamic web applications.',
                'location' => 'Kigali, Rwanda',
                'type' => 'Full-time',
                'requirements' => "• Bachelor's degree in Computer Science or related field\n• Experience with Laravel, Vue.js\n• Strong understanding of REST APIs",
                'responsibilities' => "• Develop and maintain web applications\n• Collaborate with cross-functional teams\n• Write clean and testable code",
                'company_id' => $companyIds[array_rand($companyIds)],
                'deadline' => Carbon::now()->addDays(30),
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Graphic Designer',
                'description' => 'Creative designer needed to produce engaging visual content for our digital platforms.',
                'location' => 'Remote',
                'type' => 'Part-time',
                'requirements' => "• Proficiency in Adobe Photoshop, Illustrator\n• Portfolio demonstrating design skills\n• Ability to meet deadlines",
                'responsibilities' => "• Design marketing materials\n• Collaborate with marketing and dev teams\n• Ensure brand consistency",
                'company_id' => $companyIds[array_rand($companyIds)],
                'deadline' => Carbon::now()->addDays(20),
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Customer Support Specialist',
                'description' => 'We are seeking a friendly and detail-oriented support agent to assist our customers.',
                'location' => 'Huye, Rwanda',
                'type' => 'Contract',
                'requirements' => "• Excellent communication skills\n• Experience in customer service\n• Ability to resolve issues efficiently",
                'responsibilities' => "• Respond to customer inquiries\n• Track and report recurring issues\n• Collaborate with the technical team",
                'company_id' => $companyIds[array_rand($companyIds)],
                'deadline' => Carbon::now()->addDays(15),
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mobile App Developer',
                'description' => 'Join our growing team to build cross-platform mobile apps using Flutter.',
                'location' => 'Musanze, Rwanda',
                'type' => 'Full-time',
                'requirements' => "• Experience in Flutter or React Native\n• Strong knowledge of mobile architecture\n• Familiarity with RESTful APIs",
                'responsibilities' => "• Build and maintain mobile apps\n• Write efficient and maintainable code\n• Participate in code reviews",
                'company_id' => $companyIds[array_rand($companyIds)],
                'deadline' => Carbon::now()->addDays(40),
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Marketing Manager',
                'description' => 'Strategic thinker needed to lead our marketing initiatives and grow brand visibility.',
                'location' => 'Kigali, Rwanda',
                'type' => 'Full-time',
                'requirements' => "• Degree in Marketing or Business Administration\n• 3+ years experience in a similar role\n• Excellent communication skills",
                'responsibilities' => "• Develop and execute marketing campaigns\n• Manage content creation\n• Analyze and report on campaign performance",
                'company_id' => $companyIds[array_rand($companyIds)],
                'deadline' => Carbon::now()->addDays(25),
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('jobs')->insert($jobs);
    }
}
