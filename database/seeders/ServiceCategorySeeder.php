<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [

            'Hair Services' => [
                'Haircut',
                'Hair Styling',
                'Hair Coloring',
                'Hair Extensions',
                'Hair Treatment',
                'Braiding'
            ],

            'Nail Services' => [
                'Manicure',
                'Pedicure',
                'Gel Nails',
                'Acrylic Nails',
                'Nail Art',
                'Nail Repair'
            ],

            'Facial & Skincare' => [
                'Classic Facial',
                'Hydrating Facial',
                'Acne Treatment',
                'Anti-Aging Facial',
                'Chemical Peel',
                'Microdermabrasion'
            ],

            'Makeup Services' => [
                'Bridal Makeup',
                'Party Makeup',
                'Photoshoot Makeup',
                'Natural Makeup',
                'Airbrush Makeup',
                'Fashion Makeup'
            ],

            'Eyebrows & Eyelashes' => [
                'Eyebrow Shaping',
                'Eyebrow Tinting',
                'Microblading',
                'Eyelash Extensions',
                'Lash Lift',
                'Lash Tinting'
            ],

            'Massage & Spa' => [
                'Swedish Massage',
                'Deep Tissue Massage',
                'Hot Stone Massage',
                'Aromatherapy Massage',
                'Body Scrub',
                'Spa Package'
            ],

            'Waxing & Hair Removal' => [
                'Face Waxing',
                'Leg Waxing',
                'Arm Waxing',
                'Brazilian Wax',
                'Laser Hair Removal',
                'Threading'
            ],

            'Body Treatments' => [
                'Body Polish',
                'Body Wrap',
                'Cellulite Treatment',
                'Detox Treatment',
                'Skin Brightening',
                'Back Treatment'
            ],

            'Beauty Consultations' => [
                'Skincare Consultation',
                'Hair Consultation',
                'Makeup Consultation',
                'Bridal Beauty Planning',
                'Beauty Coaching'
            ],

            'Men Grooming' => [
                'Men Haircut',
                'Beard Trim',
                'Shaving',
                'Men Facial',
                'Hair Coloring',
                'Scalp Treatment'
            ],

        ];

        foreach ($categories as $categoryName => $subcategories) {

            $category = ServiceCategory::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'image' => 'assets/images/categories/' . Str::slug($categoryName) . '.jpg',
                'featured' => rand(0, 1),
            ]);

            foreach ($subcategories as $subcategoryName) {
                ServiceSubCategory::create([
                    'service_category_id' => $category->id,
                    'name' => $subcategoryName,
                    'slug' => Str::slug($subcategoryName),
                ]);
            }
        }
    }
}