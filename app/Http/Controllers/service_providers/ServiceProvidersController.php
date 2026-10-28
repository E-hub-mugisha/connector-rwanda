<?php

namespace App\Http\Controllers\service_providers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\EmailInquiry;

use App\Models\ServiceProvider;
use App\Models\Feedback;
use App\Models\Portfolio;
use App\Models\Rating;
use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\WorkingHour;
use App\Models\Promotion;

class ServiceProvidersController extends Controller
{
    /**
     * Display approved service providers.
     */
    public function serviceProviders(Request $request)
    {
        $query = ServiceProvider::query()
            ->with([
                'category',
                'user',
            ])
            ->where('status', 'approved');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {

                $q->where(
                    'sprovider_name',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'service_locations',
                    'like',
                    "%{$search}%"
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category')) {

            $category = $request->input('category');

            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Location
        |--------------------------------------------------------------------------
        */

        if ($request->filled('location')) {

            $location = $request->input('location');

            $query->where(
                'service_locations',
                $location
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        switch ($request->input('sort', 'latest')) {

            case 'name':

                $query->orderBy(
                    'sprovider_name',
                    'asc'
                );

                break;

            case 'latest':
            default:

                $query->latest('created_at');

                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $sproviders = $query
            ->paginate(20)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = ServiceCategory::query()
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Locations
        |--------------------------------------------------------------------------
        */

        $locations = ServiceProvider::query()
            ->where('status', 'approved')
            ->whereNotNull('service_locations')
            ->where('service_locations', '!=', '')
            ->select('service_locations')
            ->distinct()
            ->orderBy('service_locations')
            ->pluck('service_locations');

        return view(
            'service_provider.serviceProviders',
            compact(
                'sproviders',
                'categories',
                'locations'
            )
        );
    }

    /**
     * Display service provider profile.
     */
    public function profile($sprovider_id)
    {
        /*
        |--------------------------------------------------------------------------
        | Service Provider
        |--------------------------------------------------------------------------
        */

        $sprovider = ServiceProvider::query()
            ->where('status', 'approved')
            ->with([
                /*
                |--------------------------------------------------------------
                | User
                |--------------------------------------------------------------
                */
                'user',

                /*
                |--------------------------------------------------------------
                | Provider Category
                |--------------------------------------------------------------
                */
                'category',

                /*
                |--------------------------------------------------------------
                | Services
                |--------------------------------------------------------------
                */
                'services' => function ($query) {

                    $query
                        ->with([
                            /*
                            | Service subcategory
                            */
                            'subcategory',

                            /*
                            | Service portfolios
                            */
                            'portfolios',

                            /*
                            | Service promotions
                            |
                            | IMPORTANT:
                            | Promotion belongs to Service.
                            | Promotion does NOT have category().
                            */
                            'promotions' => function ($promotionQuery) {

                                $promotionQuery
                                    ->whereDate(
                                        'end_date',
                                        '>=',
                                        now()
                                    )
                                    ->latest('end_date');
                            },
                        ])
                        ->latest('created_at');
                },

                /*
                |--------------------------------------------------------------
                | Working Hours
                |--------------------------------------------------------------
                */
                'workingHours',

                /*
                |--------------------------------------------------------------
                | Feedback
                |--------------------------------------------------------------
                */
                'feedback' => function ($query) {

                    $query
                        ->where('approved', true)
                        ->latest('created_at');
                },

                /*
                |--------------------------------------------------------------
                | Ratings
                |--------------------------------------------------------------
                */
                'ratings' => function ($query) {

                    $query
                        ->where('status', true)
                        ->latest('created_at');
                },
            ])
            ->findOrFail($sprovider_id);

        /*
        |--------------------------------------------------------------------------
        | Ratings
        |--------------------------------------------------------------------------
        */

        $ratings = $sprovider->ratings;

        $ratingCount = $ratings->count();

        $averageRating = $ratingCount > 0
            ? round(
                (float) $ratings->avg('rating'),
                1
            )
            : 0.0;

        /*
        |--------------------------------------------------------------------------
        | Feedback
        |--------------------------------------------------------------------------
        */

        $feedback = $sprovider->feedback;

        /*
        |--------------------------------------------------------------------------
        | Sales
        |--------------------------------------------------------------------------
        */

        $totalSales = (int) (
            $sprovider->completed_jobs_count ?? 0
        );

        /*
        |--------------------------------------------------------------------------
        | Services
        |--------------------------------------------------------------------------
        */

        $services = $sprovider->services;

        $serviceCount = $services->count();

        /*
        |--------------------------------------------------------------------------
        | Group Services By Subcategory
        |--------------------------------------------------------------------------
        */

        $groupedServices = $services->groupBy(function ($service) {

            return optional(
                $service->subcategory
            )->name ?: 'Other services';
        });

        /*
        |--------------------------------------------------------------------------
        | Portfolios
        |--------------------------------------------------------------------------
        */

        $portfolios = $services
            ->flatMap(function ($service) {

                return $service->portfolios->map(
                    function ($portfolio) use ($service) {

                        /*
                        | Attach service to portfolio
                        | so the Blade view can access:
                        |
                        | $portfolio->service
                        */
                        $portfolio->service = $service;

                        return $portfolio;
                    }
                );
            })
            ->values();

        $portfolioCount = $portfolios->count();

        /*
        |--------------------------------------------------------------------------
        | Active Promotions
        |--------------------------------------------------------------------------
        |
        | Promotions belong to Service.
        |
        | Structure:
        |
        | ServiceProvider
        |      ↓
        | Services
        |      ↓
        | Promotions
        |
        */

        $activePromotions = $services
            ->flatMap(function ($service) {

                return $service->promotions->map(
                    function ($promotion) use ($service) {

                        /*
                        | Attach service to promotion
                        |
                        | Blade can then use:
                        | $promotion->service
                        */
                        $promotion->service = $service;

                        return $promotion;
                    }
                );
            })
            ->sortByDesc(function ($promotion) {

                return $promotion->end_date;
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Reviews + Feedback Count
        |--------------------------------------------------------------------------
        */

        $reviewsAndFeedbackCount =
            $ratingCount + $feedback->count();

        /*
        |--------------------------------------------------------------------------
        | About Section
        |--------------------------------------------------------------------------
        */

        $hasAboutContent =
            filled($sprovider->about)
            || filled($sprovider->skills)
            || filled($sprovider->qualification)
            || filled($sprovider->experience);

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'service_provider.serviceProviderProfile',
            compact(
                'sprovider',
                'ratings',
                'feedback',
                'averageRating',
                'ratingCount',
                'totalSales',
                'groupedServices',
                'serviceCount',
                'portfolios',
                'portfolioCount',
                'reviewsAndFeedbackCount',
                'activePromotions',
                'hasAboutContent'
            )
        );
    }

    /**
     * Send email inquiry to service provider.
     */
    public function sendEmailInquiry(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'proEmail' => [
                'required',
                'email',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:50',
            ],

            'subject' => [
                'required',
                'string',
                'max:255',
            ],

            'message' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Mail Data
        |--------------------------------------------------------------------------
        */

        $mailData = [
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'proEmail' => $validated['proEmail'],
            'phone'    => $validated['phone'] ?? null,
            'subject'  => $validated['subject'],
            'message'  => $validated['message'],
        ];

        /*
        |--------------------------------------------------------------------------
        | Send Email
        |--------------------------------------------------------------------------
        */

        Mail::to($mailData['proEmail'])
            ->send(
                new EmailInquiry($mailData)
            );

        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        alert()->success(
            'Thank You',
            'Your message has been sent successfully.'
        );

        return redirect()->back();
    }

    /**
     * Display providers by location.
     */
    public function ProviderByLocation($location)
    {
        $sproviders = ServiceProvider::query()
            ->with([
                'user',
                'category',
            ])
            ->where('status', 'approved')
            ->where(
                'service_locations',
                $location
            )
            ->paginate(9);

        return view(
            'service_provider.serviceProviderByLocation',
            compact('sproviders')
        );
    }

    /**
     * Display providers by category.
     */
    public function serviceProviderByCategory($service_category_name)
    {
        $scategory = ServiceCategory::query()
            ->where(
                'slug',
                $service_category_name
            )
            ->firstOrFail();

        $sproviders = ServiceProvider::query()
            ->with([
                'user',
                'category',
            ])
            ->where('status', 'approved')
            ->where(
                'service_category_id',
                $scategory->id
            )
            ->paginate(9);

        return view(
            'service_provider.serviceProviderByCategory',
            compact(
                'sproviders',
                'scategory'
            )
        );
    }
}