<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceProvider;
use App\Models\ServiceSubCategory;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [

            // Hair Services
            'Haircut' => [
                ['Women Haircut', 25],
                ['Men Haircut', 15],
                ['Kids Haircut', 10],
                ['Luxury Haircut', 35],
            ],

            'Hair Styling' => [
                ['Blow Dry Styling', 20],
                ['Wedding Hair Styling', 60],
                ['Curl Styling', 25],
                ['Straightening Styling', 30],
            ],

            'Hair Coloring' => [
                ['Full Hair Color', 80],
                ['Root Touch Up', 40],
                ['Highlights', 70],
                ['Balayage', 120],
            ],

            'Hair Extensions' => [
                ['Tape-In Extensions', 150],
                ['Clip-In Extensions', 100],
            ],

            'Hair Treatment' => [
                ['Keratin Treatment', 120],
                ['Scalp Treatment', 50],
                ['Hair Repair Therapy', 65],
            ],

            // Nail Services
            'Manicure' => [
                ['Classic Manicure', 20],
                ['Luxury Manicure', 35],
            ],

            'Pedicure' => [
                ['Classic Pedicure', 25],
                ['Spa Pedicure', 45],
            ],

            'Gel Nails' => [
                ['Gel Nail Application', 35],
                ['Gel Nail Refill', 25],
            ],

            'Acrylic Nails' => [
                ['Full Acrylic Set', 50],
                ['Acrylic Refill', 35],
            ],

            'Nail Art' => [
                ['Custom Nail Art', 30],
                ['Premium Nail Design', 45],
            ],

            // Facial & Skincare
            'Classic Facial' => [
                ['Basic Facial Treatment', 40],
                ['Deep Cleansing Facial', 55],
            ],

            'Hydrating Facial' => [
                ['Hydration Boost Facial', 60],
                ['Premium Hydrating Facial', 75],
            ],

            'Acne Treatment' => [
                ['Acne Control Facial', 65],
                ['Advanced Acne Therapy', 90],
            ],

            'Anti-Aging Facial' => [
                ['Collagen Facial', 80],
                ['Anti-Aging Therapy', 110],
            ],

            // Makeup
            'Bridal Makeup' => [
                ['Bridal Makeup Package', 150],
                ['Luxury Bridal Makeup', 250],
            ],

            'Party Makeup' => [
                ['Evening Party Makeup', 60],
                ['Glam Party Makeup', 90],
            ],

            'Photoshoot Makeup' => [
                ['Studio Makeup', 80],
                ['Fashion Makeup', 120],
            ],

            // Brows & Lashes
            'Eyebrow Shaping' => [
                ['Eyebrow Threading', 10],
                ['Eyebrow Waxing', 12],
            ],

            'Microblading' => [
                ['Classic Microblading', 180],
                ['Premium Microblading', 250],
            ],

            'Eyelash Extensions' => [
                ['Classic Lash Extensions', 80],
                ['Volume Lash Extensions', 120],
            ],

            // Massage & Spa
            'Swedish Massage' => [
                ['60 Minute Swedish Massage', 70],
                ['90 Minute Swedish Massage', 95],
            ],

            'Deep Tissue Massage' => [
                ['60 Minute Deep Tissue Massage', 85],
                ['90 Minute Deep Tissue Massage', 120],
            ],

            'Hot Stone Massage' => [
                ['Hot Stone Therapy', 110],
            ],

            'Spa Package' => [
                ['Luxury Spa Package', 200],
                ['Couples Spa Package', 350],
            ],

            // Waxing
            'Face Waxing' => [
                ['Upper Lip Wax', 8],
                ['Full Face Wax', 30],
            ],

            'Leg Waxing' => [
                ['Half Leg Wax', 25],
                ['Full Leg Wax', 45],
            ],

            'Brazilian Wax' => [
                ['Brazilian Wax Treatment', 55],
            ],

            // Body Treatments
            'Body Polish' => [
                ['Full Body Polish', 65],
                ['Luxury Body Polish', 90],
            ],

            'Body Wrap' => [
                ['Detox Body Wrap', 75],
                ['Hydrating Body Wrap', 80],
            ],

            'Skin Brightening' => [
                ['Skin Brightening Therapy', 95],
            ],

            // Consultations
            'Skincare Consultation' => [
                ['Basic Skin Assessment', 20],
                ['Advanced Skin Consultation', 50],
            ],

            'Hair Consultation' => [
                ['Hair Health Assessment', 25],
            ],

            'Beauty Coaching' => [
                ['Personal Beauty Coaching', 75],
            ],

            // Men Grooming
            'Men Haircut' => [
                ['Classic Men Haircut', 15],
                ['Premium Men Haircut', 30],
            ],

            'Beard Trim' => [
                ['Basic Beard Trim', 10],
                ['Premium Beard Grooming', 20],
            ],

            'Shaving' => [
                ['Traditional Hot Towel Shave', 20],
            ],

            'Men Facial' => [
                ['Men Refresh Facial', 40],
                ['Premium Men Facial', 60],
            ],
        ];

        foreach ($services as $subCategoryName => $serviceList) {

            $subCategory = ServiceSubCategory::where(
                'name',
                $subCategoryName
            )->first();

            if (!$subCategory) {
                continue;
            }

            $providers = ServiceProvider::where(
                'service_category_id',
                $subCategory->service_category_id
            )->get();

            foreach ($serviceList as $serviceData) {

                $provider = $providers->random();

                Service::create([
                    'name' => $serviceData[0],

                    'service_category_id' =>
                        $subCategory->service_category_id,

                    'sub_category_id' =>
                        $subCategory->id,

                    'service_provider_id' =>
                        $provider->id,

                    'price' =>
                        $serviceData[1],

                    'discount' =>
                        rand(0, 20),

                    'discount_type' =>
                        'percent',

                    'location' =>
                        $provider->city,

                    'description' =>
                        'Professional ' .
                        strtolower($serviceData[0]) .
                        ' service provided by experienced beauty specialists.',

                    'duration' =>
                        rand(30, 180),

                    'status' =>
                        1,
                ]);
            }
        }
    }
}