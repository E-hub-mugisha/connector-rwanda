<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Job;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call([
            UsersTableSeeder::class,
            ServiceProvidersTableSeeder::class,
            ServiceCategorySeeder::class,
            JobsTableSeeder::class
        ]);
        \App\Models\Service::factory(20)->create();
        \App\Models\Category::factory(6)->create();
        \App\Models\Product::factory(22)->create();
    }
}
