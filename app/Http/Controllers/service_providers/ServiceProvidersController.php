<?php

namespace App\Http\Controllers\service_providers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailInquiry;
use App\Models\Feedback;
use App\Models\Portfolio;
use App\Models\Rating;
use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\WorkingHour;
use Carbon\Carbon;
use App\Models\Promotion;

class ServiceProvidersController extends Controller
{
    public function serviceProviders(Request $request)
    {
        $query = ServiceProvider::query()
            ->with('category', 'user')
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

            $query->whereHas(
                'category',
                function ($q) use ($request) {

                    $q->where(
                        'slug',
                        $request->input('category')
                    );
                }
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Location
    |--------------------------------------------------------------------------
    */

        if ($request->filled('location')) {

            $location = $request->input('location');

            $query->where(function ($q) use ($location) {

                $q->where(
                    'service_locations',
                    $location
                )

                    ->orWhere(
                        'service_locations',
                        $location
                    );
            });
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

        return view('service_provider.serviceProviders', compact(
            'sproviders',
            'categories',
            'locations'
        ));
    }
    /**
     * Display service provider profile.
     */
    public function profile($sprovider_id)
    {
        $sprovider = ServiceProvider::query()
            ->with([
                'user',
                'category',

                'services' => function ($query) {
                    $query
                        ->with([
                            'subcategory',
                            'portfolios',
                            'promotions' => function ($promotionQuery) {
                                $promotionQuery
                                    ->whereDate('end_date', '>=', now())
                                    ->latest('end_date')
                                    ->with([
                                        'category',
                                    ]);
                            },
                        ])
                        ->latest('created_at');
                },

                'workingHours',

                'feedback' => function ($query) {
                    $query
                        ->where('approved', true)
                        ->latest('created_at');
                },

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
            ? round((float) $ratings->avg('rating'), 1)
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

        $totalSales = (int) $sprovider->completed_jobs_count;

        /*
    |--------------------------------------------------------------------------
    | Services
    |--------------------------------------------------------------------------
    */

        $services = $sprovider->services;

        $serviceCount = $services->count();

        /*
    |--------------------------------------------------------------------------
    | Group services by subcategory
    |--------------------------------------------------------------------------
    */

        $groupedServices = $services->groupBy(function ($service) {
            return optional($service->subcategory)->name
                ?: 'Other services';
        });

        /*
    |--------------------------------------------------------------------------
    | Portfolios
    |--------------------------------------------------------------------------
    */

        $portfolios = $services
            ->flatMap(function ($service) {
                return $service->portfolios->map(function ($portfolio) use ($service) {
                    $portfolio->service = $service;

                    return $portfolio;
                });
            })
            ->values();

        $portfolioCount = $portfolios->count();

        /*
    |--------------------------------------------------------------------------
    | Promotions
    |--------------------------------------------------------------------------
    |
    | Promotions belong to Service, not ServiceProvider.
    |
    */

        $activePromotions = $services
            ->flatMap(function ($service) {
                return $service->promotions->map(function ($promotion) use ($service) {
                    $promotion->service = $service;

                    return $promotion;
                });
            })
            ->sortByDesc(function ($promotion) {
                return $promotion->end_date;
            })
            ->values();

        /*
    |--------------------------------------------------------------------------
    | Reviews + Feedback
    |--------------------------------------------------------------------------
    */

        $reviewsAndFeedbackCount =
            $ratingCount + $feedback->count();

        /*
    |--------------------------------------------------------------------------
    | About section
    |--------------------------------------------------------------------------
    */

        $hasAboutContent =
            filled($sprovider->about)
            || filled($sprovider->skills)
            || filled($sprovider->qualification)
            || filled($sprovider->experience);

        /*
    |--------------------------------------------------------------------------
    | View
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
    public function sendEmailInquiry(Request $request)
    {
        $mailData = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'proEmail' => $request->get('proEmail'),
            'phone' => $request->get('phone'),
            'subject' => $request->get('subject'),
            'message' => $request->get('message'),
        ];

        Mail::to($mailData['proEmail'])
            ->send(new EmailInquiry($mailData));

        alert()->success('Thank You', 'Your message have been sent successfully.');
        return redirect()->back();
    }
    public function ProviderByLocation($location)
    {
        $sproviders = ServiceProvider::where('service_locations', $location)->paginate(9);
        return view('service_provider.serviceProviderByLocation', compact('sproviders'));
    }
    public function serviceProviderByCategory($service_category_name)
    {
        $scategory = ServiceCategory::where('slug', $service_category_name)->first();
        $sproviders = ServiceProvider::where('service_category_id', $scategory->id)->paginate(9);
        return view('service_provider.serviceProviderByCategory', compact('sproviders'));
    }
}
