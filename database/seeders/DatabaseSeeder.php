<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Seeds the beauty booking platform (10 records per table).
 * Run: php artisan db:seed
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            ServiceCategoriesSeeder::class,
            ServiceSubCategoriesSeeder::class,
            ServiceProvidersSeeder::class,
            WorkingHoursSeeder::class,
            ServicesSeeder::class,
            ServiceMediaSeeder::class,
            StaffMembersSeeder::class,
            ServiceStaffSeeder::class,
            ServiceBookingsSeeder::class,
            StaffBookingsSeeder::class,
            ServicePaymentsSeeder::class,
            OrdersSeeder::class,
            PromotionsSeeder::class,
            ServiceRatingsSeeder::class,
            ServiceProviderRatingsSeeder::class,
            FeedbackSeeder::class,
            PortfoliosSeeder::class,
            SlidersSeeder::class,
            PartnerLogosSeeder::class,
            ContactsSeeder::class,
            NewslettersSeeder::class,
            BlogsSeeder::class,
            CommentsSeeder::class,
            JobsSeeder::class,
            JobApplicationsSeeder::class,
        ]);
    }
}
