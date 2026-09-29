<?php

namespace App\Http\Controllers\service_categories;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceMedia;
use App\Models\ServiceProvider;
use App\Models\ServiceSubCategory;
use Illuminate\Http\Request;

class ServiceCategoriesController extends Controller
{
    /**
     * All service categories.
     */
    public function AllCategories()
    {
        $sproviders = ServiceProvider::query()
            ->with('user')
            ->inRandomOrder()
            ->limit(6)
            ->get();

        $scategories = ServiceCategory::query()
            ->withCount('services')
            ->with([
                'subcategories:id,name,slug,service_category_id',
            ])
            ->orderBy('name')
            ->paginate(12);

        return view(
            'services.service-categories',
            compact('scategories', 'sproviders')
        );
    }

    /**
     * Services by category or subcategory.
     */
    public function ByCategories(
        string $category_slug,
        ?string $scategory_slug = null
    ) {
        $scategories = ServiceCategory::query()
            ->with([
                'subcategories:id,name,slug,service_category_id',
            ])
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Subcategory
        |--------------------------------------------------------------------------
        */

        if ($scategory_slug) {
            $scategory = ServiceSubCategory::query()
                ->where('slug', $scategory_slug)
                ->with([
                    'category',
                    'services' => function ($query) {
                        $query
                            ->with([
                                'category',
                                'subcategory',
                                'provider.user',
                                'promotions',
                            ])
                            ->latest('created_at');
                    },
                ])
                ->firstOrFail();

            return view(
                'services.service-by-category',
                compact('scategory', 'scategories')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        */

        $scategory = ServiceCategory::query()
            ->where('slug', $category_slug)
            ->with([
                'subcategories:id,name,slug,service_category_id',
                'services' => function ($query) {
                    $query
                        ->with([
                            'category',
                            'subcategory',
                            'provider.user',
                            'promotions',
                        ])
                        ->latest('created_at');
                },
            ])
            ->withCount('services')
            ->firstOrFail();

        return view(
            'services.service-by-category',
            compact('scategory', 'scategories')
        );
    }

    /**
     * All services.
     */
    public function AllServices()
    {
        $scategories = ServiceCategory::query()
            ->withCount('services')
            ->orderBy('name')
            ->get();

        $services = Service::query()
            ->with([
                'category',
                'subcategory',
                'provider.user',
            ])
            ->latest('created_at')
            ->paginate(9);

        return view(
            'services.services',
            compact('services', 'scategories')
        );
    }

    /**
     * Service detail.
     */
    public function ServiceDetail(string $service_slug)
    {
        $service = Service::query()
            ->where('slug', $service_slug)
            ->with([
                'category',
                'subcategory',
                'provider.user',
                'provider.workingHours',
                'provider.ratings',
                'promotions' => function ($query) {
                    $query
                        ->whereDate('end_date', '>=', now())
                        ->latest('end_date');
                },
                'portfolios',
                'media',
            ])
            ->firstOrFail();

        $medias = $service->media;

        $r_service = Service::query()
            ->where('service_category_id', $service->service_category_id)
            ->whereKeyNot($service->id)
            ->with([
                'category',
                'provider.user',
            ])
            ->inRandomOrder()
            ->first();

        return view(
            'services.service-details',
            compact(
                'service',
                'r_service',
                'medias'
            )
        );
    }

    /**
     * Services by location.
     */
    public function ByLocation(string $service_location)
    {
        $scategories = ServiceCategory::query()
            ->withCount('services')
            ->orderBy('name')
            ->get();

        $locations = Service::query()
            ->where('location', $service_location)
            ->with([
                'category',
                'subcategory',
                'provider.user',
            ])
            ->latest('created_at')
            ->paginate(9)
            ->withQueryString();

        return view(
            'services.service-by-location',
            compact(
                'locations',
                'scategories'
            )
        );
    }

    /**
     * Services by subcategory.
     */
    public function showServicesBySubcategory(
        string $subcategory_slug
    ) {
        $subcategory = ServiceSubCategory::query()
            ->where('slug', $subcategory_slug)
            ->with([
                'category',
                'services' => function ($query) {
                    $query
                        ->with([
                            'category',
                            'subcategory',
                            'provider.user',
                            'promotions',
                        ])
                        ->latest('created_at');
                },
            ])
            ->firstOrFail();

        $services = $subcategory->services;

        $scategories = ServiceCategory::query()
            ->with([
                'subcategories:id,name,slug,service_category_id',
            ])
            ->orderBy('name')
            ->get();

        return view(
            'services.service-by-subcategory',
            compact(
                'services',
                'subcategory',
                'scategories'
            )
        );
    }

    /**
     * Search services.
     */
    public function search(Request $request)
    {
        $request->validate([
            'name' => ['nullable', 'string', 'max:100'],
            'category_id' => ['nullable', 'integer'],
            'subcategory_id' => ['nullable', 'integer'],
            'location' => ['nullable', 'string', 'max:150'],
        ]);

        $categories = ServiceCategory::query()
            ->orderBy('name')
            ->get();

        $subcategories = ServiceSubCategory::query()
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Get locations without loading every Service model
        |--------------------------------------------------------------------------
        */

        $locations = Service::query()
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->select('location')
            ->distinct()
            ->orderBy('location')
            ->pluck('location');

        /*
        |--------------------------------------------------------------------------
        | Services query
        |--------------------------------------------------------------------------
        */

        $query = Service::query()
            ->with([
                'category',
                'subcategory',
                'provider.user',
            ]);

        if ($request->filled('name')) {
            $name = trim($request->input('name'));

            $query->where(
                'name',
                'like',
                "%{$name}%"
            );
        }

        if ($request->filled('category_id')) {
            $query->where(
                'service_category_id',
                $request->input('category_id')
            );
        }

        if ($request->filled('subcategory_id')) {
            $query->where(
                'sub_category_id',
                $request->input('subcategory_id')
            );
        }

        if ($request->filled('location')) {
            $query->where(
                'location',
                $request->input('location')
            );
        }

        $services = $query
            ->latest('created_at')
            ->paginate(12)
            ->withQueryString();

        return view(
            'services.search',
            compact(
                'services',
                'categories',
                'subcategories',
                'locations'
            )
        );
    }
}