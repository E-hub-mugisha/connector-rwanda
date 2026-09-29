<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class JobApplicationsSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            [
                'id' => 1,
                'job_id' => 1,
                'user_id' => 25,
                'cover_letter' => 'I am excited to apply for the Hair Stylist role and would love to join your team.',
                'resume' => 'uploads/resumes/applicant-1.pdf',
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'job_id' => 2,
                'user_id' => 26,
                'cover_letter' => 'I am excited to apply for the Braider role and would love to join your team.',
                'resume' => 'uploads/resumes/applicant-2.pdf',
                'status' => 'reviewed',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'job_id' => 3,
                'user_id' => 27,
                'cover_letter' => 'I am excited to apply for the Barber role and would love to join your team.',
                'resume' => 'uploads/resumes/applicant-3.pdf',
                'status' => 'accepted',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'job_id' => 4,
                'user_id' => 28,
                'cover_letter' => 'I am excited to apply for the Nail Technician role and would love to join your team.',
                'resume' => 'uploads/resumes/applicant-4.pdf',
                'status' => 'rejected',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'job_id' => 5,
                'user_id' => 29,
                'cover_letter' => 'I am excited to apply for the Junior Makeup Artist role and would love to join your team.',
                'resume' => 'uploads/resumes/applicant-5.pdf',
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'job_id' => 6,
                'user_id' => 30,
                'cover_letter' => 'I am excited to apply for the Skincare Therapist role and would love to join your team.',
                'resume' => 'uploads/resumes/applicant-6.pdf',
                'status' => 'reviewed',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'job_id' => 7,
                'user_id' => 31,
                'cover_letter' => 'I am excited to apply for the Massage Therapist role and would love to join your team.',
                'resume' => 'uploads/resumes/applicant-7.pdf',
                'status' => 'accepted',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'job_id' => 8,
                'user_id' => 22,
                'cover_letter' => 'I am excited to apply for the Beauty Receptionist role and would love to join your team.',
                'resume' => 'uploads/resumes/applicant-8.pdf',
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'job_id' => 9,
                'user_id' => 23,
                'cover_letter' => 'I am excited to apply for the Bridal Styling Assistant role and would love to join your team.',
                'resume' => 'uploads/resumes/applicant-9.pdf',
                'status' => 'reviewed',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'job_id' => 10,
                'user_id' => 24,
                'cover_letter' => 'I am excited to apply for the Lash Technician Trainee role and would love to join your team.',
                'resume' => 'uploads/resumes/applicant-10.pdf',
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // insertOrIgnore => safe to re-run (explicit ids, duplicates are skipped)
        DB::table('job_applications')->insertOrIgnore($rows);
    }
}
