<?php

namespace App\Http\Controllers\stadmin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceProvider;
use App\Models\Service;
use App\Models\User;
use App\Models\ServiceBooking;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StadminController extends Controller
{
    public function index()
    {
        $sprovider = ServiceProvider::query()
            ->with([
                'user:id,name,email',
                'category:id,name',

                'services' => fn ($query) => $query
                    ->latest()
                    ->with([
                        'category:id,name',
                        'promotions',
                    ]),

                'ratings',
                'feedback',
                'staffMembers',
                'workingHours',
            ])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Services
        |--------------------------------------------------------------------------
        */

        $services = $sprovider->services;

        $recentServices = $services
            ->take(5)
            ->values();

        $servicesByCategory = $services
            ->groupBy(fn ($service) =>
                $service->category?->name ?? 'Uncategorized'
            )
            ->map(fn ($items, $category) => [
                'category' => $category,
                'count' => $items->count(),
            ])
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Promotions
        |--------------------------------------------------------------------------
        | Promotions belong to services, not directly to the provider.
        |--------------------------------------------------------------------------
        */

        $promotions = $services
            ->flatMap(fn ($service) => $service->promotions)
            ->sortByDesc('created_at')
            ->values();

        $activePromotions = $promotions
            ->filter(fn ($promotion) =>
                (!$promotion->start_date ||
                    $promotion->start_date <= now()) &&
                (!$promotion->end_date ||
                    $promotion->end_date >= now())
            )
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Ratings
        |--------------------------------------------------------------------------
        */

        $ratings = $sprovider->ratings;

        /*
        |--------------------------------------------------------------------------
        | Profile Completion
        |--------------------------------------------------------------------------
        */

        $profileFields = collect([
            $sprovider->user?->name,
            $sprovider->user?->email,
            $sprovider->image,
            $sprovider->category?->name,
        ]);

        $profileCompletion = round(
            ($profileFields->filter()->count() / $profileFields->count()) * 100
        );

        /*
        |--------------------------------------------------------------------------
        | Dashboard Data
        |--------------------------------------------------------------------------
        */

        $stats = [
            'totalServices'     => $services->count(),
            'totalRatings'      => $ratings->count(),
            'averageRating'     => round((float) $ratings->avg('rating'), 1),
            'totalFeedback'     => $sprovider->feedback->count(),
            'totalStaff'        => $sprovider->staffMembers->count(),
            'totalWorkingHours' => $sprovider->workingHours->count(),
            'totalPromotions'   => $promotions->count(),
            'activePromotions'  => $activePromotions->count(),
        ];

        return view('stadmin.dashboard.index', [
            'sprovider'        => $sprovider,
            'services'         => $services,
            'recentServices'   => $recentServices,
            'servicesByCategory' => $servicesByCategory,

            'promotions'       => $promotions,
            'activePromotions' => $activePromotions,

            'profileCompletion' => $profileCompletion,

            ...$stats,
        ]);
    }


    public function ServiceOffering()
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        $offerings = Service::where('service_provider_id', $sprovider->id)->get();
        return view('stadmin.ServicePadminServices', compact('offerings'));
    }
    public function ServiceOfferingDetail($slug)
    {
        $details = Service::where('slug', $slug)->first();
        return view('stadmin.ServicePadminServiceDetail', compact('details'));
    }
    public function ServiceOfferingAddPage()
    {
        $categories = ServiceCategory::all();
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        return view('stadmin.ServicePadminAddService', compact('categories', 'sprovider'));
    }
    public function addService(Request $request)
    {
        $imagePath = $request->file('image');
        $image = $imagePath->store('images', 'public');
        $thumbnailPath = $request->file('thumbnail');
        $thumbnail = $thumbnailPath->store('thumbnails', 'public');

        $service = new Service();
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        $service->name = $request->input('name');
        $service->slug = $request->input('slug');
        $service->tagline = $request->input('tagline');
        $service->service_category_id = $request->input('service_category_id');
        $service->service_provider_id = $sprovider->id;
        $service->price = $request->input('price');
        $service->discount = $request->input('discount');
        $service->discount_type = $request->input('discount_type');
        $service->duration = $request->input('duration');
        $service->description = $request->input('description');
        $service->location = $request->input('location');
        $service->inclusion = str_replace("\n", '|', trim($request->input('inclusion')));
        $service->exclusion = str_replace("\n", '|', trim($request->input('exclusion')));
        $service->image = $image;

        if ($image = $request->file('image')) {
            $destinationPath = 'services/images/';
            $serviceImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $serviceImage);
            $input['image'] = "$serviceImage";
        }
        if ($thumbnail = $request->file('thumbnail')) {
            $destinationPath = 'services/thumbnails/';
            $serviceThumbnail = date('YmdHis') . "." . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $serviceThumbnail);
            $input['thumbnail'] = "$serviceThumbnail";
        }

        $service->save();

        alert()->success('SuccessAlert', 'Thank you for reaching out t0; we will get back to you soon');

        session()->flash('message', 'Service created successfully!');

        return redirect()->back();
    }
    public function ServiceBookings()
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        $orders = ServiceBooking::where('service_provider_id', $sprovider->id)->get();
        return view('stadmin.ServicePadminBooking', compact('orders'));
    }
    public function ServiceOrderDetail($id)
    {
        $orders = ServiceBooking::where('id', $id)->first();
        return view('stadmin.ServiceOrderDetail', compact('orders'));
    }

    public function ServiceEditDetail($id)
    {
        $service = Service::where('id', $id)->first();
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        return view('stadmin.ServicePadminEditService', compact('service', 'sprovider'));
    }

    public function updateService(Request $request, $id)
    {
        $imagePath = $request->file('image');
        $image = $imagePath->store('images', 'public');
        $thumbnailPath = $request->file('thumbnail');
        $thumbnail = $thumbnailPath->store('thumbnails', 'public');

        $service = Service::where('id', $id);
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        $service->name = $request->input('name');
        $service->slug = $request->input('slug');
        $service->tagline = $request->input('tagline');
        $service->service_category_id = $request->input('service_category_id');
        $service->service_provider_id = $sprovider->id;
        $service->price = $request->input('price');
        $service->discount = $request->input('discount');
        $service->discount_type = $request->input('discount_type');
        $service->duration = $request->input('duration');
        $service->description = $request->input('description');
        $service->location = $request->input('location');
        $service->inclusion = str_replace("\n", '|', trim($request->input('inclusion')));
        $service->exclusion = str_replace("\n", '|', trim($request->input('exclusion')));
        $service->image = $image;

        if ($image = $request->file('image')) {
            $destinationPath = 'services/images/';
            $serviceImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $serviceImage);
            $input['image'] = "$serviceImage";
        }
        if ($thumbnail = $request->file('thumbnail')) {
            $destinationPath = 'services/thumbnails/';
            $serviceThumbnail = date('YmdHis') . "." . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $serviceThumbnail);
            $input['thumbnail'] = "$serviceThumbnail";
        }

        $service->update();

        alert()->success('SuccessAlert', 'Thank you for reaching out t0; we will get back to you soon');

        session()->flash('message', 'Service created successfully!');

        return redirect()->back();
    }
    public function SClients()
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        $clients = ServiceBooking::where('service_provider_id', $sprovider->id)->get();
        return view('stadmin.customers.index', compact('clients'));
    }
    public function SClientDetail($user_id)
    {
        $clients = User::where('id', $user_id)
            ->first();
        $orders = ServiceBooking::where('user_id', $clients->id)
            ->get();
        return view('stadmin.customers.show', compact('clients', 'orders'));
    }
}
