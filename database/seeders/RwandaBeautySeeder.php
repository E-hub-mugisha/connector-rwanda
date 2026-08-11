<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * Seeds the "connector_laravel" beauty-services marketplace with a
 * realistic Rwandan dataset: salons/spas, staff, bookings, reviews,
 * blog content, promotions, and more.
 *
 * Safe to re-run: every insert is keyed off a natural unique value
 * (slug/email/transaction id) via updateOrInsert, so running the
 * seeder twice will not create duplicates.
 *
 * Usage: php artisan db:seed --class=Database\\Seeders\\RwandaBeautySeeder
 * or add RwandaBeautySeeder::class to DatabaseSeeder::run().
 */
class RwandaBeautySeeder extends Seeder
{
    /** @var array<string,int> */
    private array $categoryIds = [];

    /** @var array<string,int> */
    private array $userIds = [];

    /** @var array<string,int> */
    private array $providerIds = [];

    /** @var array<string,int> */
    private array $serviceIds = [];

    /** @var array<string,int> */
    private array $staffIds = [];

    /** @var array<string,int> */
    private array $bookingIds = [];

    /** @var array<string,int> */
    private array $blogIds = [];

    public function run(): void
    {
        $this->command?->info('Seeding Rwandan beauty-sector demo data...');

        $this->seedCategories();
        $this->seedSubCategories();
        $this->seedUsers();
        $this->seedServiceProviders();
        $this->seedServices();
        $this->seedStaffMembers();
        $this->seedServiceStaff();
        $this->seedWorkingHours();
        $this->seedPortfolios();
        $this->seedPromotions();
        $this->seedServiceBookings();
        $this->seedServicePayments();
        $this->seedRatings();
        $this->seedBlogsAndComments();
        $this->seedFeedback();
        $this->seedSliders();
        $this->seedPartnerLogos();
        $this->seedNewsletter();
        $this->seedJobs();

        $this->command?->info('Rwandan beauty marketplace seeded successfully.');
    }

    /* -----------------------------------------------------------------
     | Categories & sub-categories (kept identical to the existing dump
     | so foreign keys already referenced elsewhere stay valid).
     |------------------------------------------------------------------*/

    private function seedCategories(): void
    {
        $now = Carbon::parse('2026-06-05 15:14:58');

        $rows = [
            1 => ['name' => 'Hair Services', 'slug' => 'hair-services', 'image' => 'assets/images/categories/hair-services.jpg', 'featured' => 1],
            2 => ['name' => 'Nail Services', 'slug' => 'nail-services', 'image' => 'assets/images/categories/nail-services.jpg', 'featured' => 1],
            3 => ['name' => 'Facial & Skincare', 'slug' => 'facial-skincare', 'image' => 'assets/images/categories/facial-skincare.jpg', 'featured' => 0],
            4 => ['name' => 'Makeup Services', 'slug' => 'makeup-services', 'image' => 'assets/images/categories/makeup-services.jpg', 'featured' => 1],
            5 => ['name' => 'Eyebrows & Eyelashes', 'slug' => 'eyebrows-eyelashes', 'image' => 'assets/images/categories/eyebrows-eyelashes.jpg', 'featured' => 1],
            6 => ['name' => 'Massage & Spa', 'slug' => 'massage-spa', 'image' => 'assets/images/categories/massage-spa.jpg', 'featured' => 0],
            7 => ['name' => 'Waxing & Hair Removal', 'slug' => 'waxing-hair-removal', 'image' => 'assets/images/categories/waxing-hair-removal.jpg', 'featured' => 0],
            8 => ['name' => 'Body Treatments', 'slug' => 'body-treatments', 'image' => 'assets/images/categories/body-treatments.jpg', 'featured' => 1],
            9 => ['name' => 'Beauty Consultations', 'slug' => 'beauty-consultations', 'image' => 'assets/images/categories/beauty-consultations.jpg', 'featured' => 1],
            10 => ['name' => 'Men Grooming', 'slug' => 'men-grooming', 'image' => 'assets/images/categories/men-grooming.jpg', 'featured' => 1],
        ];

        foreach ($rows as $id => $data) {
            DB::table('service_categories')->updateOrInsert(
                ['id' => $id],
                array_merge($data, ['created_at' => $now, 'updated_at' => $now])
            );
            $this->categoryIds[$data['slug']] = $id;
        }
    }

    private function seedSubCategories(): void
    {
        $now = Carbon::parse('2026-06-05 15:14:59');

        $rows = [
            1 => ['name' => 'Haircut', 'slug' => 'haircut', 'cat' => 1],
            2 => ['name' => 'Hair Styling', 'slug' => 'hair-styling', 'cat' => 1],
            3 => ['name' => 'Hair Coloring', 'slug' => 'hair-coloring', 'cat' => 1],
            4 => ['name' => 'Hair Extensions', 'slug' => 'hair-extensions', 'cat' => 1],
            5 => ['name' => 'Hair Treatment', 'slug' => 'hair-treatment', 'cat' => 1],
            6 => ['name' => 'Braiding', 'slug' => 'braiding', 'cat' => 1],
            7 => ['name' => 'Manicure', 'slug' => 'manicure', 'cat' => 2],
            8 => ['name' => 'Pedicure', 'slug' => 'pedicure', 'cat' => 2],
            9 => ['name' => 'Gel Nails', 'slug' => 'gel-nails', 'cat' => 2],
            10 => ['name' => 'Acrylic Nails', 'slug' => 'acrylic-nails', 'cat' => 2],
            11 => ['name' => 'Nail Art', 'slug' => 'nail-art', 'cat' => 2],
            12 => ['name' => 'Nail Repair', 'slug' => 'nail-repair', 'cat' => 2],
            13 => ['name' => 'Classic Facial', 'slug' => 'classic-facial', 'cat' => 3],
            14 => ['name' => 'Hydrating Facial', 'slug' => 'hydrating-facial', 'cat' => 3],
            15 => ['name' => 'Acne Treatment', 'slug' => 'acne-treatment', 'cat' => 3],
            16 => ['name' => 'Anti-Aging Facial', 'slug' => 'anti-aging-facial', 'cat' => 3],
            17 => ['name' => 'Chemical Peel', 'slug' => 'chemical-peel', 'cat' => 3],
            18 => ['name' => 'Microdermabrasion', 'slug' => 'microdermabrasion', 'cat' => 3],
            19 => ['name' => 'Bridal Makeup', 'slug' => 'bridal-makeup', 'cat' => 4],
            20 => ['name' => 'Party Makeup', 'slug' => 'party-makeup', 'cat' => 4],
            21 => ['name' => 'Photoshoot Makeup', 'slug' => 'photoshoot-makeup', 'cat' => 4],
            22 => ['name' => 'Natural Makeup', 'slug' => 'natural-makeup', 'cat' => 4],
            23 => ['name' => 'Airbrush Makeup', 'slug' => 'airbrush-makeup', 'cat' => 4],
            24 => ['name' => 'Fashion Makeup', 'slug' => 'fashion-makeup', 'cat' => 4],
            25 => ['name' => 'Eyebrow Shaping', 'slug' => 'eyebrow-shaping', 'cat' => 5],
            26 => ['name' => 'Eyebrow Tinting', 'slug' => 'eyebrow-tinting', 'cat' => 5],
            27 => ['name' => 'Microblading', 'slug' => 'microblading', 'cat' => 5],
            28 => ['name' => 'Eyelash Extensions', 'slug' => 'eyelash-extensions', 'cat' => 5],
            29 => ['name' => 'Lash Lift', 'slug' => 'lash-lift', 'cat' => 5],
            30 => ['name' => 'Lash Tinting', 'slug' => 'lash-tinting', 'cat' => 5],
            31 => ['name' => 'Swedish Massage', 'slug' => 'swedish-massage', 'cat' => 6],
            32 => ['name' => 'Deep Tissue Massage', 'slug' => 'deep-tissue-massage', 'cat' => 6],
            33 => ['name' => 'Hot Stone Massage', 'slug' => 'hot-stone-massage', 'cat' => 6],
            34 => ['name' => 'Aromatherapy Massage', 'slug' => 'aromatherapy-massage', 'cat' => 6],
            35 => ['name' => 'Body Scrub', 'slug' => 'body-scrub', 'cat' => 6],
            36 => ['name' => 'Spa Package', 'slug' => 'spa-package', 'cat' => 6],
            37 => ['name' => 'Face Waxing', 'slug' => 'face-waxing', 'cat' => 7],
            38 => ['name' => 'Leg Waxing', 'slug' => 'leg-waxing', 'cat' => 7],
            39 => ['name' => 'Arm Waxing', 'slug' => 'arm-waxing', 'cat' => 7],
            40 => ['name' => 'Brazilian Wax', 'slug' => 'brazilian-wax', 'cat' => 7],
            41 => ['name' => 'Laser Hair Removal', 'slug' => 'laser-hair-removal', 'cat' => 7],
            42 => ['name' => 'Threading', 'slug' => 'threading', 'cat' => 7],
            43 => ['name' => 'Body Polish', 'slug' => 'body-polish', 'cat' => 8],
            44 => ['name' => 'Body Wrap', 'slug' => 'body-wrap', 'cat' => 8],
            45 => ['name' => 'Cellulite Treatment', 'slug' => 'cellulite-treatment', 'cat' => 8],
            46 => ['name' => 'Detox Treatment', 'slug' => 'detox-treatment', 'cat' => 8],
            47 => ['name' => 'Skin Brightening', 'slug' => 'skin-brightening', 'cat' => 8],
            48 => ['name' => 'Back Treatment', 'slug' => 'back-treatment', 'cat' => 8],
            49 => ['name' => 'Skincare Consultation', 'slug' => 'skincare-consultation', 'cat' => 9],
            50 => ['name' => 'Hair Consultation', 'slug' => 'hair-consultation', 'cat' => 9],
            51 => ['name' => 'Makeup Consultation', 'slug' => 'makeup-consultation', 'cat' => 9],
            52 => ['name' => 'Bridal Beauty Planning', 'slug' => 'bridal-beauty-planning', 'cat' => 9],
            53 => ['name' => 'Beauty Coaching', 'slug' => 'beauty-coaching', 'cat' => 9],
            54 => ['name' => 'Men Haircut', 'slug' => 'men-haircut', 'cat' => 10],
            55 => ['name' => 'Beard Trim', 'slug' => 'beard-trim', 'cat' => 10],
            56 => ['name' => 'Shaving', 'slug' => 'shaving', 'cat' => 10],
            57 => ['name' => 'Men Facial', 'slug' => 'men-facial', 'cat' => 10],
            58 => ['name' => 'Hair Coloring (Men)', 'slug' => 'hair-coloring-men', 'cat' => 10],
            59 => ['name' => 'Scalp Treatment', 'slug' => 'scalp-treatment', 'cat' => 10],
        ];

        foreach ($rows as $id => $r) {
            DB::table('service_sub_categories')->updateOrInsert(
                ['id' => $id],
                [
                    'name' => $r['name'],
                    'slug' => $r['slug'],
                    'service_category_id' => $r['cat'],
                    'service_id' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }

    /* -----------------------------------------------------------------
     | Users: 7 salon/spa owners (SVP) + 8 customers (CST)
     |------------------------------------------------------------------*/

    private function seedUsers(): void
    {
        $now = Carbon::parse('2026-07-10 09:00:00');
        $pwd = Hash::make('password123');

        $owners = [
            'owner_isoni'        => ['Uwase Diane', 'diane.uwase@isonibeauty.rw', '+250788112233', 'Kimironko, Gasabo, Kigali'],
            'owner_bella'        => ['Keza Aline', 'aline.keza@bellakigalispa.rw', '+250788223344', 'Kacyiru, Gasabo, Kigali'],
            'owner_ineza'        => ['Iradukunda Solange', 'solange.iradukunda@inezaskin.rw', '+250788334455', 'Ngoma, Huye'],
            'owner_prince'       => ['Ishimwe Patrick', 'patrick.ishimwe@princebarbershop.rw', '+250788445566', 'Muhoza, Musanze'],
            'owner_gisubizo'     => ['Umutoni Grace', 'grace.umutoni@gisubizonails.rw', '+250788556677', 'Gisenyi, Rubavu'],
            'owner_glowmakeup'   => ['Nkurunziza David', 'david.nkurunziza@glowmakeupstudio.rw', '+250788667788', 'Nyamirambo, Nyarugenge, Kigali'],
            'owner_sanawellness' => ['Mukamana Josiane', 'josiane.mukamana@sanawellness.rw', '+250788778899', 'Muhanga Town, Muhanga'],
        ];

        foreach ($owners as $key => [$name, $email, $phone, $address]) {
            $id = $this->upsertUser($name, $email, $phone, $address, 'SVP', $pwd, $now);
            $this->userIds[$key] = $id;
        }

        $customers = [
            'cust_aline'    => ['Umuhoza Aline', 'aline.umuhoza@gmail.com', '+250788901122', 'Remera, Gasabo, Kigali'],
            'cust_eric'     => ['Ndayisenga Eric', 'eric.ndayisenga@gmail.com', '+250788901123', 'Kicukiro, Kigali'],
            'cust_grace'    => ['Uwimana Grace', 'grace.uwimana@yahoo.com', '+250788901124', 'Nyamagabe, Huye'],
            'cust_jeandedieu' => ['Habimana Jean de Dieu', 'jdhabimana@gmail.com', '+250788901125', 'Muhoza, Musanze'],
            'cust_sandrine' => ['Mutesi Sandrine', 'sandrine.mutesi@gmail.com', '+250788901126', 'Gisenyi, Rubavu'],
            'cust_alexis'   => ['Bizimana Alexis', 'alexis.bizimana@gmail.com', '+250788901127', 'Nyarugenge, Kigali'],
            'cust_divine'   => ['Teta Divine', 'divine.teta@gmail.com', '+250788901128', 'Muhanga Town, Muhanga'],
            'cust_yves'     => ['Nshimiyimana Yves', 'yves.nshimiyimana@gmail.com', '+250788901129', 'Rwamagana Town, Rwamagana'],
        ];

        foreach ($customers as $key => [$name, $email, $phone, $address]) {
            $id = $this->upsertUser($name, $email, $phone, $address, 'CST', $pwd, $now);
            $this->userIds[$key] = $id;
        }
    }

    private function upsertUser(string $name, string $email, string $phone, string $address, string $utype, string $pwd, Carbon $now): int
    {
        DB::table('users')->updateOrInsert(
            ['email' => $email],
            [
                'name' => $name,
                'email_verified_at' => $now,
                'password' => $pwd,
                'remember_token' => Str::random(10),
                'utype' => $utype,
                'phone' => $phone,
                'address' => $address,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        return DB::table('users')->where('email', $email)->value('id');
    }

    /* -----------------------------------------------------------------
     | Service providers (salons / spas / individual beauty pros)
     |------------------------------------------------------------------*/

    private function seedServiceProviders(): void
    {
        $now = Carbon::parse('2026-07-11 10:00:00');

        $providers = [
            'isoni' => [
                'user' => 'owner_isoni',
                'name' => 'Isoni Beauty Salon',
                'email' => 'contact@isonibeauty.rw',
                'image' => 'providers/isoni_beauty.png',
                'about' => 'A full-service hair salon in Kimironko known for protective styling, braiding, and modern colour work for Kigali women.',
                'skills' => 'Haircutting, Box Braids, Balayage, Keratin Treatment, Hair Styling',
                'qualification' => 'Certified Hairstylist, Rwanda Polytechnic - Hairdressing',
                'experience' => '6 years running a hair salon in Kigali',
                'city' => 'Kigali',
                'category' => 'hair-services',
                'locations' => 'Kimironko, Remera, Kacyiru, Kigali',
                'status' => 'approved',
            ],
            'bella_kigali' => [
                'user' => 'owner_bella',
                'name' => 'Bella Kigali Spa',
                'email' => 'hello@bellakigalispa.rw',
                'image' => 'providers/bella_kigali_spa.png',
                'about' => 'A calm, plant-filled spa in Kacyiru offering massage and full-day spa packages for relaxation and recovery.',
                'skills' => 'Swedish Massage, Hot Stone Therapy, Aromatherapy, Body Scrubs',
                'qualification' => 'Diploma in Spa Therapy, Kigali Institute of Wellness',
                'experience' => '5 years in professional massage therapy',
                'city' => 'Kigali',
                'category' => 'massage-spa',
                'locations' => 'Kacyiru, Kimihurura, Kigali',
                'status' => 'approved',
            ],
            'ineza' => [
                'user' => 'owner_ineza',
                'name' => 'Ineza Skincare Clinic',
                'email' => 'info@inezaskin.rw',
                'image' => 'providers/ineza_skincare.png',
                'about' => 'A skincare clinic in Huye focused on facials and treatments suited to a range of African skin tones and Rwanda\'s climate.',
                'skills' => 'Facials, Chemical Peels, Acne Treatment, Skin Analysis',
                'qualification' => 'Certified Esthetician, BSc in Cosmetic Science',
                'experience' => '4 years in professional skincare',
                'city' => 'Huye',
                'category' => 'facial-skincare',
                'locations' => 'Huye, Nyamagabe',
                'status' => 'approved',
            ],
            'prince_barbershop' => [
                'user' => 'owner_prince',
                'name' => 'Prince Barbershop',
                'email' => 'book@princebarbershop.rw',
                'image' => 'providers/prince_barbershop.png',
                'about' => 'A modern barbershop in Musanze offering sharp fades, beard grooming, and hot towel shaves for men.',
                'skills' => 'Fades, Beard Grooming, Hot Towel Shave, Hair Design',
                'qualification' => 'Certified Barber, Musanze Vocational Training Centre',
                'experience' => '7 years as a professional barber',
                'city' => 'Musanze',
                'category' => 'men-grooming',
                'locations' => 'Muhoza, Musanze Town',
                'status' => 'approved',
            ],
            'gisubizo' => [
                'user' => 'owner_gisubizo',
                'name' => 'Gisubizo Nails & Lashes',
                'email' => 'studio@gisubizonails.rw',
                'image' => 'providers/gisubizo_nails.png',
                'about' => 'A nail and lash studio in Rubavu, popular for gel manicures, nail art, and lash extensions with a lake view.',
                'skills' => 'Gel Nails, Acrylics, Nail Art, Eyelash Extensions',
                'qualification' => 'Certified Nail Technician',
                'experience' => '3 years in nail care and lash artistry',
                'city' => 'Rubavu',
                'category' => 'nail-services',
                'locations' => 'Gisenyi, Rubavu Town',
                'status' => 'approved',
            ],
            'glow_makeup' => [
                'user' => 'owner_glowmakeup',
                'name' => 'Glow Makeup Studio',
                'email' => 'bookings@glowmakeupstudio.rw',
                'image' => 'providers/glow_makeup_studio.png',
                'about' => 'A bridal and event makeup studio in Nyamirambo trusted for weddings, photoshoots, and traditional Rwandan ceremonies.',
                'skills' => 'Bridal Makeup, Airbrush Makeup, Gusaba/Wedding Looks, Photoshoot Makeup',
                'qualification' => 'Professional Makeup Artistry Certificate',
                'experience' => '5 years as a professional makeup artist',
                'city' => 'Kigali',
                'category' => 'makeup-services',
                'locations' => 'Nyamirambo, Nyarugenge, Kigali',
                'status' => 'approved',
            ],
            'sana_wellness' => [
                'user' => 'owner_sanawellness',
                'name' => 'Sana Wellness Spa',
                'email' => 'care@sanawellness.rw',
                'image' => 'providers/sana_wellness.png',
                'about' => 'A body-treatment focused wellness spa in Muhanga offering detox wraps and skin brightening programmes.',
                'skills' => 'Body Wraps, Detox Treatments, Cellulite Therapy, Skin Brightening',
                'qualification' => 'Certificate in Body Therapy',
                'experience' => '4 years in body treatment services',
                'city' => 'Muhanga',
                'category' => 'body-treatments',
                'locations' => 'Muhanga Town, Ruhango',
                'status' => 'pending',
            ],
        ];

        foreach ($providers as $key => $p) {
            DB::table('service_providers')->updateOrInsert(
                ['proEmail' => $p['email']],
                [
                    'user_id' => $this->userIds[$p['user']],
                    'sprovider_name' => $p['name'],
                    'image' => $p['image'],
                    'about' => $p['about'],
                    'skills' => $p['skills'],
                    'qualification' => $p['qualification'],
                    'experience' => $p['experience'],
                    'city' => $p['city'],
                    'service_category_id' => $this->categoryIds[$p['category']],
                    'service_locations' => $p['locations'],
                    'status' => $p['status'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
            $this->providerIds[$key] = DB::table('service_providers')->where('proEmail', $p['email'])->value('id');
        }
    }

    /* -----------------------------------------------------------------
     | Services offered by each provider
     |------------------------------------------------------------------*/

    private function seedServices(): void
    {
        $now = Carbon::parse('2026-07-12 09:00:00');

        // [provider key, name, sub_category_id, price, discount, discount_type, duration, featured, description]
        $services = [
            ['isoni', 'Classic Women\'s Haircut', 1, 5000, null, null, '45 mins', 0, 'A precision haircut and blow-dry finish tailored to your face shape.'],
            ['isoni', 'Box Braids', 6, 15000, 2000, 'fixed', '3 hrs', 1, 'Neat, long-lasting box braids using premium synthetic hair, gentle on the scalp.'],
            ['isoni', 'Balayage Colour', 3, 35000, null, null, '2 hrs 30 mins', 0, 'Hand-painted colour technique for a soft, sun-kissed look.'],
            ['isoni', 'Keratin Hair Treatment', 5, 40000, null, null, '2 hrs', 0, 'Smoothing keratin treatment that reduces frizz and strengthens hair.'],

            ['bella_kigali', 'Swedish Massage', 31, 25000, null, null, '1 hr', 1, 'A relaxing full-body massage using long, flowing strokes to ease tension.'],
            ['bella_kigali', 'Hot Stone Massage', 33, 30000, null, null, '1 hr 15 mins', 0, 'Warm basalt stones combined with massage to melt away deep muscle tension.'],
            ['bella_kigali', 'Full Day Spa Package', 36, 60000, 5000, 'fixed', '4 hrs', 1, 'Massage, facial, and body scrub bundled into a full relaxation day.'],
            ['bella_kigali', 'Coffee Body Scrub', 35, 20000, null, null, '45 mins', 0, 'An exfoliating scrub using locally sourced Rwandan coffee grounds.'],

            ['ineza', 'Hydrating Facial', 14, 18000, null, null, '1 hr', 0, 'Deeply hydrating facial for dry or dehydrated skin.'],
            ['ineza', 'Acne Treatment Facial', 15, 22000, null, null, '1 hr', 0, 'Targeted treatment to clear breakouts and calm inflammation.'],
            ['ineza', 'Chemical Peel', 17, 28000, null, null, '50 mins', 0, 'A gentle peel to brighten skin tone and improve texture.'],
            ['ineza', 'Anti-Aging Facial', 16, 32000, null, null, '1 hr 15 mins', 0, 'Firming facial that targets fine lines and restores elasticity.'],

            ['prince_barbershop', 'Men\'s Skin Fade', 54, 3000, null, null, '30 mins', 0, 'A sharp, clean skin fade finished with line-up detailing.'],
            ['prince_barbershop', 'Beard Trim & Shape', 55, 2000, null, null, '20 mins', 0, 'Beard trimming and shaping for a neat, defined look.'],
            ['prince_barbershop', 'Hot Towel Shave', 56, 1500, null, null, '20 mins', 0, 'A traditional hot towel shave for a smooth, clean finish.'],
            ['prince_barbershop', 'Men\'s Facial', 57, 10000, null, null, '40 mins', 0, 'A refreshing facial designed for men\'s skincare needs.'],

            ['gisubizo', 'Gel Manicure', 9, 8000, null, null, '45 mins', 0, 'Long-lasting gel polish manicure in your choice of colour.'],
            ['gisubizo', 'Acrylic Full Set', 10, 12000, null, null, '1 hr 15 mins', 0, 'Durable acrylic nail extensions shaped to your preference.'],
            ['gisubizo', 'Custom Nail Art', 11, 10000, null, null, '1 hr', 0, 'Hand-painted nail art designs, from minimal to bold.'],
            ['gisubizo', 'Classic Eyelash Extensions', 28, 15000, null, null, '1 hr 30 mins', 0, 'Natural-looking lash extensions applied one by one.'],

            ['glow_makeup', 'Bridal Makeup', 19, 120000, 12000, 'fixed', '2 hrs', 1, 'Full bridal makeup application including trial consultation.'],
            ['glow_makeup', 'Party Makeup', 20, 35000, null, null, '1 hr', 0, 'Glam makeup look for parties and special occasions.'],
            ['glow_makeup', 'Photoshoot Makeup', 21, 45000, null, null, '1 hr 30 mins', 0, 'Camera-ready makeup optimised for photography lighting.'],
            ['glow_makeup', 'Airbrush Makeup', 23, 50000, null, null, '1 hr 30 mins', 0, 'Long-wear airbrush foundation for a flawless, matte finish.'],

            ['sana_wellness', 'Detox Body Wrap', 44, 25000, null, null, '1 hr', 0, 'A mineral-rich wrap that detoxifies and softens the skin.'],
            ['sana_wellness', 'Cellulite Treatment', 45, 30000, null, null, '1 hr', 0, 'A targeted massage treatment to smooth the appearance of cellulite.'],
            ['sana_wellness', 'Full Body Detox Programme', 46, 28000, null, null, '1 hr 15 mins', 0, 'A restorative programme designed to refresh and re-energise the body.'],
            ['sana_wellness', 'Skin Brightening Treatment', 47, 20000, null, null, '50 mins', 0, 'A brightening treatment that evens out skin tone.'],
        ];

        foreach ($services as [$providerKey, $name, $subCatId, $price, $discount, $discountType, $duration, $featured, $desc]) {
            $providerId = $this->providerIds[$providerKey];
            $slug = Str::slug($name . '-' . $providerKey);
            $catId = DB::table('service_sub_categories')->where('id', $subCatId)->value('service_category_id');
            $city = DB::table('service_providers')->where('id', $providerId)->value('city');

            DB::table('services')->updateOrInsert(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'service_category_id' => $catId,
                    'service_provider_id' => $providerId,
                    'price' => $price,
                    'discount' => $discount,
                    'discount_type' => $discountType,
                    'image' => 'services/' . $slug . '.jpg',
                    'description' => $desc,
                    'inclusion' => 'Consultation, service delivery, aftercare tips',
                    'exclusion' => 'Products for home use are not included',
                    'duration' => $duration,
                    'status' => 1,
                    'featured' => $featured,
                    'location' => $city,
                    'sub_category_id' => $subCatId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );

            $key = $providerKey . '_' . Str::slug($name);
            $this->serviceIds[$key] = DB::table('services')->where('slug', $slug)->value('id');
        }
    }

    /* -----------------------------------------------------------------
     | Staff members per salon
     |------------------------------------------------------------------*/

    private function seedStaffMembers(): void
    {
        $now = Carbon::parse('2026-07-13 09:00:00');

        $staff = [
            ['isoni', 'Furaha Belyse', 'belyse.furaha@isonibeauty.rw', '+250788012345', 'Senior Hairstylist'],
            ['isoni', 'Nizeyimana Eric', 'eric.nizeyimana@isonibeauty.rw', '+250788012346', 'Braiding Specialist'],
            ['bella_kigali', 'Uwera Sandra', 'sandra.uwera@bellakigalispa.rw', '+250788012347', 'Massage Therapist'],
            ['bella_kigali', 'Habyarimana Aime', 'aime.habyarimana@bellakigalispa.rw', '+250788012348', 'Spa Therapist'],
            ['ineza', 'Mukashema Alice', 'alice.mukashema@inezaskin.rw', '+250788012349', 'Esthetician'],
            ['ineza', 'Niyibizi Claude', 'claude.niyibizi@inezaskin.rw', '+250788012350', 'Skincare Specialist'],
            ['prince_barbershop', 'Rugamba Fabrice', 'fabrice.rugamba@princebarbershop.rw', '+250788012351', 'Senior Barber'],
            ['prince_barbershop', 'Ntwali Serge', 'serge.ntwali@princebarbershop.rw', '+250788012352', 'Junior Barber'],
            ['gisubizo', 'Ingabire Vanessa', 'vanessa.ingabire@gisubizonails.rw', '+250788012353', 'Nail Technician'],
            ['gisubizo', 'Umulisa Christelle', 'christelle.umulisa@gisubizonails.rw', '+250788012354', 'Lash Artist'],
            ['glow_makeup', 'Karangwa Yvette', 'yvette.karangwa@glowmakeupstudio.rw', '+250788012355', 'Lead Makeup Artist'],
            ['glow_makeup', 'Uwamahoro Divine', 'divine.uwamahoro@glowmakeupstudio.rw', '+250788012356', 'Makeup Assistant'],
            ['sana_wellness', 'Mahoro Patrick', 'patrick.mahoro@sanawellness.rw', '+250788012357', 'Wellness Therapist'],
            ['sana_wellness', 'Kwizera Olive', 'olive.kwizera@sanawellness.rw', '+250788012358', 'Body Treatment Specialist'],
        ];

        foreach ($staff as $i => [$providerKey, $name, $email, $phone, $role]) {
            $providerId = $this->providerIds[$providerKey];
            $address = DB::table('service_providers')->where('id', $providerId)->value('city');

            DB::table('staff_members')->updateOrInsert(
                ['email' => $email],
                [
                    'service_provider_id' => $providerId,
                    'staff_service_id' => null,
                    'name' => $name,
                    'phone' => $phone,
                    'address' => $address,
                    'role' => $role,
                    'status' => 'available',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );

            $this->staffIds[$providerKey . '_' . $i] = DB::table('staff_members')->where('email', $email)->value('id');
        }
    }

    /* -----------------------------------------------------------------
     | service_staff pivot: which staff perform which services
     |------------------------------------------------------------------*/

    private function seedServiceStaff(): void
    {
        $now = Carbon::now();

        $pairs = [
            ['isoni_0', 'isoni_classic-womens-haircut'],
            ['isoni_1', 'isoni_box-braids'],
            ['bella_kigali_2', 'bella_kigali_swedish-massage'],
            ['bella_kigali_3', 'bella_kigali_hot-stone-massage'],
            ['ineza_4', 'ineza_hydrating-facial'],
            ['ineza_5', 'ineza_chemical-peel'],
            ['prince_barbershop_6', 'prince_barbershop_mens-skin-fade'],
            ['prince_barbershop_7', 'prince_barbershop_beard-trim-shape'],
            ['gisubizo_8', 'gisubizo_gel-manicure'],
            ['gisubizo_9', 'gisubizo_classic-eyelash-extensions'],
            ['glow_makeup_10', 'glow_makeup_bridal-makeup'],
            ['glow_makeup_11', 'glow_makeup_party-makeup'],
            ['sana_wellness_12', 'sana_wellness_detox-body-wrap'],
            ['sana_wellness_13', 'sana_wellness_skin-brightening-treatment'],
        ];

        foreach ($pairs as [$staffKey, $serviceKey]) {
            if (!isset($this->staffIds[$staffKey], $this->serviceIds[$serviceKey])) {
                continue;
            }
            DB::table('service_staff')->updateOrInsert(
                [
                    'staff_member_id' => $this->staffIds[$staffKey],
                    'service_id' => $this->serviceIds[$serviceKey],
                ],
                ['created_at' => $now, 'updated_at' => $now]
            );
        }
    }

    /* -----------------------------------------------------------------
     | Working hours per provider (Mon-Sat open, Sun closed/limited)
     |------------------------------------------------------------------*/

    private function seedWorkingHours(): void
    {
        $now = Carbon::now();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($this->providerIds as $key => $providerId) {
            foreach ($days as $day) {
                $isSunday = $day === 'Sunday';
                $isSpa = in_array($key, ['bella_kigali', 'sana_wellness'], true);

                if ($isSunday && !$isSpa) {
                    $start = null;
                    $end = null;
                    $closed = 1;
                } elseif ($isSunday && $isSpa) {
                    $start = '10:00:00';
                    $end = '15:00:00';
                    $closed = 0;
                } else {
                    $start = '08:00:00';
                    $end = '18:00:00';
                    $closed = 0;
                }

                DB::table('working_hours')->updateOrInsert(
                    ['sprovider_id' => $providerId, 'day' => $day],
                    [
                        'start_time' => $start,
                        'end_time' => $end,
                        'is_closed' => $closed,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        }
    }

    /* -----------------------------------------------------------------
     | Portfolio images per provider
     |------------------------------------------------------------------*/

    private function seedPortfolios(): void
    {
        $now = Carbon::now();

        $items = [
            ['isoni', 'Box Braids Transformation', 'isoni_box-braids'],
            ['isoni', 'Balayage Before & After', 'isoni_balayage-colour'],
            ['bella_kigali', 'Relaxation Suite', null],
            ['bella_kigali', 'Hot Stone Session', 'bella_kigali_hot-stone-massage'],
            ['ineza', 'Glow-Up Facial Results', 'ineza_hydrating-facial'],
            ['prince_barbershop', 'Clean Skin Fade', 'prince_barbershop_mens-skin-fade'],
            ['gisubizo', 'Nail Art Showcase', 'gisubizo_custom-nail-art'],
            ['gisubizo', 'Lash Extension Close-Up', 'gisubizo_classic-eyelash-extensions'],
            ['glow_makeup', 'Kigali Bridal Look', 'glow_makeup_bridal-makeup'],
            ['glow_makeup', 'Editorial Photoshoot Makeup', 'glow_makeup_photoshoot-makeup'],
            ['sana_wellness', 'Detox Wrap Session', 'sana_wellness_detox-body-wrap'],
        ];

        foreach ($items as [$providerKey, $tag, $serviceKey]) {
            $providerId = $this->providerIds[$providerKey];
            $serviceId = $serviceKey ? ($this->serviceIds[$serviceKey] ?? null) : null;
            $image = 'portfolios/' . Str::slug($providerKey . '-' . $tag) . '.jpg';

            DB::table('portfolios')->updateOrInsert(
                ['image' => $image],
                [
                    'tag' => $tag,
                    'service_id' => $serviceId,
                    'service_provider_id' => $providerId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }

    /* -----------------------------------------------------------------
     | Promotions
     |------------------------------------------------------------------*/

    private function seedPromotions(): void
    {
        $now = Carbon::now();
        $start = Carbon::parse('2026-08-01');
        $end = Carbon::parse('2026-09-15');

        $promos = [
            ['isoni', 'isoni_box-braids', 'hair-services', 'Umuganura Braids Special', 'Get 15% off box braids to celebrate the Umuganura harvest season.', 15.00],
            ['bella_kigali', 'bella_kigali_full-day-spa-package', 'massage-spa', 'New Client Spa Discount', 'First-time clients save on the Full Day Spa Package.', 10.00],
            ['glow_makeup', 'glow_makeup_bridal-makeup', 'makeup-services', 'Wedding Season Offer', 'Book your bridal makeup trial in August and save.', 12.00],
            ['gisubizo', 'gisubizo_gel-manicure', 'nail-services', 'Lake Kivu Glow Promo', 'Discounted gel manicures for visitors booking in Rubavu.', 20.00],
            ['ineza', 'ineza_chemical-peel', 'facial-skincare', 'Skin Reset Week', 'A limited-time discount on chemical peel treatments.', 18.00],
        ];

        foreach ($promos as [$providerKey, $serviceKey, $catKey, $title, $desc, $discount]) {
            DB::table('promotions')->updateOrInsert(
                ['title' => $title, 'service_provider_id' => $this->providerIds[$providerKey]],
                [
                    'service_id' => $this->serviceIds[$serviceKey],
                    'category_id' => $this->categoryIds[$catKey],
                    'description' => $desc,
                    'discount' => $discount,
                    'start_date' => $start->toDateString(),
                    'end_date' => $end->toDateString(),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }

    /* -----------------------------------------------------------------
     | Service bookings by customers
     |------------------------------------------------------------------*/

    private function seedServiceBookings(): void
    {
        $bookings = [
            ['cust_aline', 'isoni', 'isoni_box-braids', 'isoni_1', 'completed', '2026-07-20', '10:00 AM', 'paid'],
            ['cust_eric', 'prince_barbershop', 'prince_barbershop_mens-skin-fade', 'prince_barbershop_6', 'completed', '2026-07-22', '2:00 PM', 'paid'],
            ['cust_grace', 'ineza', 'ineza_hydrating-facial', 'ineza_4', 'completed', '2026-07-25', '11:30 AM', 'paid'],
            ['cust_jeandedieu', 'gisubizo', 'gisubizo_gel-manicure', 'gisubizo_8', 'approved', '2026-08-14', '9:00 AM', 'unpaid'],
            ['cust_sandrine', 'bella_kigali', 'bella_kigali_swedish-massage', 'bella_kigali_2', 'approved', '2026-08-15', '3:00 PM', 'unpaid'],
            ['cust_alexis', 'glow_makeup', 'glow_makeup_party-makeup', 'glow_makeup_11', 'pending', '2026-08-20', '5:00 PM', 'unpaid'],
            ['cust_divine', 'sana_wellness', 'sana_wellness_detox-body-wrap', 'sana_wellness_12', 'pending', '2026-08-22', '1:00 PM', 'unpaid'],
            ['cust_yves', 'prince_barbershop', 'prince_barbershop_beard-trim-shape', 'prince_barbershop_7', 'canceled', '2026-07-18', '4:00 PM', 'unpaid'],
            ['cust_aline', 'glow_makeup', 'glow_makeup_bridal-makeup', 'glow_makeup_10', 'approved', '2026-09-05', '8:00 AM', 'unpaid'],
            ['cust_grace', 'gisubizo', 'gisubizo_classic-eyelash-extensions', 'gisubizo_9', 'completed', '2026-07-28', '10:30 AM', 'paid'],
        ];

        $now = Carbon::now();

        foreach ($bookings as $i => [$custKey, $providerKey, $serviceKey, $staffKey, $status, $date, $time, $paymentStatus]) {
            $userId = $this->userIds[$custKey];
            $providerId = $this->providerIds[$providerKey];
            $serviceId = $this->serviceIds[$serviceKey];
            $staffId = $this->staffIds[$staffKey] ?? null;
            $price = DB::table('services')->where('id', $serviceId)->value('price');
            $name = DB::table('users')->where('id', $userId)->value('name');
            $email = DB::table('users')->where('id', $userId)->value('email');
            $phone = DB::table('users')->where('id', $userId)->value('phone');
            $location = DB::table('service_providers')->where('id', $providerId)->value('city');

            $bookingKey = 'booking_' . $i;

            DB::table('service_bookings')->updateOrInsert(
                [
                    'user_id' => $userId,
                    'service_id' => $serviceId,
                    'date' => $date,
                    'time' => $time,
                ],
                [
                    'status' => $status,
                    'service_provider_id' => $providerId,
                    'total' => $price,
                    'payment_mode' => 'MTN Mobile Money',
                    'names' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'location' => $location,
                    'notes' => null,
                    'staff_id' => $staffId,
                    'payment_status' => $paymentStatus,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );

            $this->bookingIds[$bookingKey] = DB::table('service_bookings')
                ->where('user_id', $userId)->where('service_id', $serviceId)
                ->where('date', $date)->where('time', $time)->value('id');
        }
    }

    /* -----------------------------------------------------------------
     | Payments for completed / approved bookings
     |------------------------------------------------------------------*/

    private function seedServicePayments(): void
    {
        $now = Carbon::now();
        $methods = ['MTN Mobile Money', 'Airtel Money', 'Cash'];

        $paidBookings = DB::table('service_bookings')
            ->whereIn('payment_status', ['paid'])
            ->get(['id', 'user_id', 'total']);

        foreach ($paidBookings as $i => $booking) {
            $txn = 'RW-TXN-' . strtoupper(Str::random(8));

            DB::table('service_payments')->updateOrInsert(
                ['booking_id' => $booking->id],
                [
                    'user_id' => $booking->user_id,
                    'amount' => $booking->total,
                    'payment_method' => $methods[$i % count($methods)],
                    'transaction_id' => $txn,
                    'status' => 'successful',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }

    /* -----------------------------------------------------------------
     | Reviews: public ratings, per-service ratings, per-provider ratings
     |------------------------------------------------------------------*/

    private function seedRatings(): void
    {
        $now = Carbon::now();

        $publicReviews = [
            ['Umuhoza Aline', 'aline.umuhoza@gmail.com', 'isoni', 5, 'My braids from Isoni Beauty Salon lasted over two months and looked neat the whole time.'],
            ['Ndayisenga Eric', 'eric.ndayisenga@gmail.com', 'prince_barbershop', 5, 'Best fade I have had in Musanze. Fabrice is precise and friendly.'],
            ['Uwimana Grace', 'grace.uwimana@gmail.com', 'ineza', 4, 'The hydrating facial left my skin so soft, will definitely come back before the dry season.'],
            ['Mutesi Sandrine', 'sandrine.mutesi@gmail.com', 'bella_kigali', 5, 'Bella Kigali Spa is the perfect place to unwind after a long work week.'],
            ['Bizimana Alexis', 'alexis.bizimana@gmail.com', 'glow_makeup', 5, 'Glow Makeup Studio did an amazing job for my sister\'s introduction ceremony.'],
        ];

        foreach ($publicReviews as [$name, $email, $providerKey, $rating, $message]) {
            DB::table('ratings')->updateOrInsert(
                ['email' => $email, 'service_provider_id' => $this->providerIds[$providerKey]],
                [
                    'name' => $name,
                    'rating' => $rating,
                    'message' => $message,
                    'approved' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $serviceRatings = [
            ['cust_grace', 'gisubizo_classic-eyelash-extensions', 5, 'Very gentle application, my lashes look natural and last long.'],
            ['cust_aline', 'isoni_box-braids', 5, 'Neat parting and comfortable tension, no headaches afterwards.'],
            ['cust_eric', 'prince_barbershop_mens-skin-fade', 5, 'Sharp lines every single time I visit.'],
        ];

        foreach ($serviceRatings as [$custKey, $serviceKey, $rating, $comment]) {
            DB::table('service_ratings')->updateOrInsert(
                ['user_id' => $this->userIds[$custKey], 'service_id' => $this->serviceIds[$serviceKey]],
                ['rating' => $rating, 'comment' => $comment, 'status' => 1, 'created_at' => $now, 'updated_at' => $now]
            );
        }

        $providerRatings = [
            ['cust_grace', 'gisubizo', 5, 'Friendly staff and a spotless studio right by the lake.'],
            ['cust_aline', 'isoni', 5, 'Always on time and my hair is treated with care.'],
            ['cust_alexis', 'glow_makeup', 5, 'Professional, punctual, and talented makeup team.'],
        ];

        foreach ($providerRatings as [$custKey, $providerKey, $rating, $comment]) {
            DB::table('service_provider_ratings')->updateOrInsert(
                ['user_id' => $this->userIds[$custKey], 'service_provider_id' => $this->providerIds[$providerKey]],
                ['rating' => $rating, 'comment' => $comment, 'status' => 1, 'created_at' => $now, 'updated_at' => $now]
            );
        }
    }

    /* -----------------------------------------------------------------
     | Blog posts and comments
     |------------------------------------------------------------------*/

    private function seedBlogsAndComments(): void
    {
        $now = Carbon::now();
        $adminId = DB::table('users')->where('utype', 'ADM')->value('id') ?? $this->userIds['owner_isoni'];

        $posts = [
            [
                'title' => 'Five Natural Skincare Tips Using Shea Butter',
                'category' => 'Skincare',
                'sub' => 'facial-skincare',
                'content' => "Shea butter is a staple in many Rwandan skincare routines because it is rich, affordable, and locally available. Warm a small amount between your palms before applying so it melts into the skin rather than sitting on top. Pair it with a gentle exfoliation once a week to prevent buildup, and always apply to slightly damp skin for the best absorption. During Kigali's dry season, a light layer at night can make a noticeable difference by morning. Finish with sunscreen during the day since shea butter alone is not enough sun protection.",
                'featured' => 1,
            ],
            [
                'title' => 'Caring for Braided Hairstyles in Rwanda\'s Climate',
                'category' => 'Hair Care',
                'sub' => 'hair-services',
                'content' => "Braided styles like box braids and cornrows are popular across Rwanda, but they need a bit of extra care to last. Wrap your hair at night with a satin scarf to reduce friction and frizz. A light oil spray on the scalp every few days keeps things from feeling dry without weighing the braids down. Avoid leaving braids in for more than eight weeks to protect your natural hair underneath. If you notice itching, a diluted apple cider vinegar rinse can help refresh the scalp between salon visits.",
                'featured' => 1,
            ],
            [
                'title' => 'Bridal Makeup Trends for Rwandan Weddings in 2026',
                'category' => 'Makeup',
                'sub' => 'makeup-services',
                'content' => "This year, Rwandan brides are leaning toward soft, dewy makeup that photographs well in both traditional Gusaba ceremonies and church weddings. Bold gold eyeliner is having a moment as a nod to traditional Imigongo-inspired patterns, paired with a neutral lip so the focus stays on the eyes. Long-wear airbrush foundation remains popular given Kigali's warm afternoons. Booking a trial session at least a month before the big day gives your makeup artist time to perfect your look.",
                'featured' => 0,
            ],
            [
                'title' => 'Modern Barbershop Trends for Men in Kigali',
                'category' => 'Men\'s Grooming',
                'sub' => 'men-grooming',
                'content' => "Kigali's barbershops have become social hubs as much as grooming spots. Skin fades paired with sharp line-ups remain the most requested cut, while beard sculpting is growing fast as more men experiment with facial hair shapes. Hot towel shaves are also seeing a resurgence for special occasions. A good barber will always check in about your hair growth pattern before committing to a style, so don't be afraid to ask questions during your visit.",
                'featured' => 0,
            ],
            [
                'title' => 'Affordable Self-Care: Spa Days Around Rwanda',
                'category' => 'Wellness',
                'sub' => 'massage-spa',
                'content' => "You don't need to travel far in Rwanda to find a relaxing spa day. Many wellness spas now offer half-day packages that combine a massage with a facial or body scrub at a fraction of the cost of a full retreat. Booking on a weekday morning often means shorter wait times and a quieter atmosphere. Bringing your own water bottle and arriving fifteen minutes early to settle in can make the whole experience feel more restorative.",
                'featured' => 0,
            ],
        ];

        foreach ($posts as $p) {
            $slug = Str::slug($p['title']);
            DB::table('blogs')->updateOrInsert(
                ['slug' => $slug],
                [
                    'title' => $p['title'],
                    'blog_category' => $p['category'],
                    'image' => 'blogs/' . $slug . '.jpg',
                    'thumbnail' => 'blogs/thumbs/' . $slug . '.jpg',
                    'content' => $p['content'],
                    'status' => 'published',
                    'user_id' => $adminId,
                    'views' => rand(40, 800),
                    'sub_category' => $p['sub'],
                    'featured' => $p['featured'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
            $this->blogIds[$slug] = DB::table('blogs')->where('slug', $slug)->value('id');
        }

        $comments = [
            [Str::slug('Five Natural Skincare Tips Using Shea Butter'), 'cust_grace', 'This actually worked for my dry skin, thank you for sharing!'],
            [Str::slug('Five Natural Skincare Tips Using Shea Butter'), 'cust_sandrine', 'Which local brand of shea butter would you recommend?'],
            [Str::slug('Caring for Braided Hairstyles in Rwanda\'s Climate'), 'cust_aline', 'The satin scarf tip changed my braids routine completely.'],
            [Str::slug('Bridal Makeup Trends for Rwandan Weddings in 2026'), 'cust_alexis', 'Booking my trial with Glow Makeup Studio after reading this!'],
        ];

        foreach ($comments as [$slug, $custKey, $body]) {
            DB::table('comments')->updateOrInsert(
                [
                    'blog_id' => $this->blogIds[$slug],
                    'user_id' => $this->userIds[$custKey],
                    'comment_body' => $body,
                ],
                ['created_at' => $now, 'updated_at' => $now]
            );
        }
    }

    /* -----------------------------------------------------------------
     | General feedback about the platform / providers
     |------------------------------------------------------------------*/

    private function seedFeedback(): void
    {
        $now = Carbon::now();

        $feedback = [
            ['Umuhoza Aline', 'aline.umuhoza@gmail.com', 'isoni', 'The online booking made it so easy to plan my braids appointment around work.'],
            ['Ndayisenga Eric', 'eric.ndayisenga@gmail.com', 'prince_barbershop', 'Would love to see loyalty discounts for regular customers.'],
            ['Uwimana Grace', 'grace.uwimana@gmail.com', 'ineza', 'Reminder messages before my appointment would be a great addition.'],
        ];

        foreach ($feedback as [$name, $email, $providerKey, $message]) {
            DB::table('feedback')->updateOrInsert(
                ['email' => $email, 'Service_Provider_ID' => $this->providerIds[$providerKey]],
                ['name' => $name, 'message' => $message, 'approved' => 1, 'created_at' => $now, 'updated_at' => $now]
            );
        }
    }

    /* -----------------------------------------------------------------
     | Homepage sliders, partner logos, newsletter data
     |------------------------------------------------------------------*/

    private function seedSliders(): void
    {
        $now = Carbon::now();

        $sliders = [
            ['Book Your Bridal Glow Package Today', 'sliders/bridal-glow-banner.jpg'],
            ['Discover Rwanda\'s Best Nail Artists', 'sliders/nail-artists-banner.jpg'],
            ['Relax at Kigali\'s Top-Rated Spas', 'sliders/spa-banner.jpg'],
            ['Fresh Fades, Every Time - Men\'s Grooming', 'sliders/mens-grooming-banner.jpg'],
        ];

        foreach ($sliders as $i => [$title, $image]) {
            DB::table('sliders')->updateOrInsert(
                ['image' => $image],
                ['title' => $title, 'status' => 1, 'created_at' => $now, 'updated_at' => $now]
            );
        }
    }

    private function seedPartnerLogos(): void
    {
        $now = Carbon::now();

        $partners = [
            ['Kigali Wellness Network', 'partners/kigali-wellness-network.png'],
            ['AmaSeed Beauty Supplies', 'partners/amaseed-beauty-supplies.png'],
            ['Made in Rwanda Cosmetics Guild', 'partners/made-in-rwanda-cosmetics.png'],
            ['RwandaPay Mobile Payments', 'partners/rwandapay.png'],
        ];

        foreach ($partners as [$name, $image]) {
            DB::table('partner_logos')->updateOrInsert(
                ['name' => $name],
                ['image' => $image, 'created_at' => $now, 'updated_at' => $now]
            );
        }
    }

    private function seedNewsletter(): void
    {
        $now = Carbon::now();

        DB::table('newsletters')->updateOrInsert(
            ['email' => 'newsletter@rwandabeautyhub.rw'],
            ['name' => 'Rwanda Beauty Hub Newsletter', 'created_at' => $now, 'updated_at' => $now]
        );

        $subscribers = [
            'aline.umuhoza@gmail.com',
            'sandrine.mutesi@gmail.com',
            'divine.teta@gmail.com',
            'yves.nshimiyimana@gmail.com',
        ];

        foreach ($subscribers as $email) {
            DB::table('newsletter_subscriptions')->updateOrInsert(
                ['email' => $email],
                ['created_at' => $now, 'updated_at' => $now]
            );
        }
    }

    /* -----------------------------------------------------------------
     | A couple of beauty-industry job postings, since service_providers
     | double as companies in the jobs table.
     |------------------------------------------------------------------*/

    private function seedJobs(): void
    {
        $now = Carbon::now();

        $jobs = [
            [
                'title' => 'Junior Hairstylist',
                'company' => 'isoni',
                'location' => 'Kigali',
                'type' => 'Full-time',
                'description' => 'Isoni Beauty Salon is looking for a junior hairstylist to join our growing team in Kimironko.',
                'requirements' => 'At least 1 year of salon experience, certificate in hairdressing preferred.',
                'responsibilities' => 'Assist senior stylists, perform haircuts and blow-dries, maintain a clean station.',
                'deadline' => '2026-09-30',
            ],
            [
                'title' => 'Licensed Massage Therapist',
                'company' => 'bella_kigali',
                'location' => 'Kigali',
                'type' => 'Full-time',
                'description' => 'Bella Kigali Spa is hiring a licensed massage therapist for our Kacyiru location.',
                'requirements' => 'Diploma in spa therapy or equivalent, 2+ years of experience.',
                'responsibilities' => 'Deliver massage and spa treatments, maintain client records, uphold hygiene standards.',
                'deadline' => '2026-09-15',
            ],
        ];

        foreach ($jobs as $job) {
            DB::table('jobs')->updateOrInsert(
                ['title' => $job['title'], 'company_id' => $this->providerIds[$job['company']]],
                [
                    'description' => $job['description'],
                    'location' => $job['location'],
                    'type' => $job['type'],
                    'requirements' => $job['requirements'],
                    'responsibilities' => $job['responsibilities'],
                    'deadline' => $job['deadline'],
                    'status' => 'open',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $jobId = DB::table('jobs')->where('title', 'Junior Hairstylist')->value('id');
        if ($jobId) {
            DB::table('job_applications')->updateOrInsert(
                ['job_id' => $jobId, 'user_id' => $this->userIds['cust_divine']],
                [
                    'cover_letter' => 'I have trained at a local salon in Muhanga and I am excited to grow my career with Isoni Beauty Salon.',
                    'resume' => 'resumes/teta-divine-cv.pdf',
                    'status' => 'pending',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
