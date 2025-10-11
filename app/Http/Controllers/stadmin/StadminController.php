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
    public function SDashboard()
{
    $sprovider = ServiceProvider::where('user_id', Auth::id())->first();

    if (!$sprovider) {
        return view('stadmin.ServicePadminDashboard')->with([
            'sprovider' => null,
            'orders' => collect([]),
            'revenueByServiceType' => collect([]),
            'percentage' => 0,
            'percentageRating' => 0,
            'totalService' => 0,
            'totalAmount' => 0,
            'totalRating' => collect([]),
            'ordersGraph' => collect([]),
            'locationData' => collect([]),
            'showModal' => false,
            'monthsPerformance' => [],
            'monthlyRevenueData' => [],
            'months' => [],
            'monthlyOrders' => [],
            'monthsRevenue' => [],
            'datasets' => [],
        ]);
    }

    $orders = ServiceBooking::with('service')
        ->where('service_provider_id', $sprovider->id)
        ->orderBy('date', 'desc')
        ->get();

    $totalOrders = ServiceBooking::count();
    $serviceProviderOrders = $orders->count();
    $percentage = ($totalOrders > 0) ? ($serviceProviderOrders / $totalOrders) * 100 : 0;

    $totalService = Service::where('service_provider_id', $sprovider->id)->count();
    $totalAmount = ServiceBooking::where('service_provider_id', $sprovider->id)->sum('total');

    $totalRating = Rating::where('service_provider_id', $sprovider->id)->get();
    $ratingsCount = Rating::count();
    $serviceProviderRatings = $totalRating->count();
    $percentageRating = ($ratingsCount > 0) ? ($serviceProviderRatings / $ratingsCount) * 100 : 0;

    $revenueByServiceType = ServiceBooking::select('services.name as service_name', DB::raw('SUM(service_bookings.total) as total_revenue'))
        ->join('services', 'services.id', '=', 'service_bookings.service_id')
        ->where('service_bookings.service_provider_id', $sprovider->id)
        ->groupBy('services.name')
        ->get();

    $ordersGraph = ServiceBooking::select('status', DB::raw('COUNT(*) as count'))
        ->where('service_provider_id', $sprovider->id)
        ->groupBy('status')
        ->get();

    $locationData = ServiceBooking::select('location', DB::raw('COUNT(*) as count'))
        ->where('service_provider_id', $sprovider->id)
        ->groupBy('location')
        ->get();

    // Monthly revenue grouped by service for stacked bar/line chart
    $monthlyRevenue = ServiceBooking::join('services', 'service_bookings.service_id', '=', 'services.id')
        ->select(
            DB::raw("DATE_FORMAT(service_bookings.created_at, '%Y-%m') as month"),
            'services.name as service_name',
            DB::raw('SUM(service_bookings.total) as total_revenue')
        )
        ->where('service_bookings.service_provider_id', $sprovider->id)
        ->groupBy('month', 'services.name')
        ->orderBy('month')
        ->get();

    $monthsRevenue = $monthlyRevenue->pluck('month')->unique()->values()->toArray();
    $services = $monthlyRevenue->pluck('service_name')->unique()->values()->toArray();

    $datasets = [];
    foreach ($services as $service) {
        $data = [];
        foreach ($monthsRevenue as $month) {
            $total = $monthlyRevenue
                ->where('service_name', $service)
                ->where('month', $month)
                ->sum('total_revenue');
            $data[] = $total;
        }
        $datasets[] = [
            'label' => $service,
            'data' => $data,
            'backgroundColor' => '#' . substr(md5($service), 0, 6),
            'borderColor' => '#' . substr(md5($service), 0, 6),
            'fill' => false,
            'tension' => 0.3,
        ];
    }

    // Monthly revenue totals (sum of all services) for performance line chart
    $monthlyRevenueTotal = ServiceBooking::where('service_provider_id', $sprovider->id)
        ->whereYear('created_at', Carbon::now()->year)
        ->select(
            DB::raw("MONTH(created_at) as month"),
            DB::raw('SUM(total) as total_revenue')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    // Initialize arrays for all 12 months with 0 revenue
    $monthsPerformance = [];
    $monthlyRevenueData = [];
    for ($m = 1; $m <= 12; $m++) {
        $monthsPerformance[] = Carbon::create()->month($m)->format('M');
        $monthlyRevenueData[$m - 1] = 0;
    }
    foreach ($monthlyRevenueTotal as $item) {
        $monthlyRevenueData[$item->month - 1] = (float)$item->total_revenue;
    }

    // Monthly orders for booking performance line chart
    $performanceData = ServiceBooking::where('service_provider_id', $sprovider->id)
        ->whereYear('created_at', Carbon::now()->year)
        ->select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total_orders')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    $months = [];
    $monthlyOrders = [];
    for ($m = 1; $m <= 12; $m++) {
        $months[$m] = Carbon::create()->month($m)->format('M');
        $monthlyOrders[$m] = 0;
    }
    foreach ($performanceData as $data) {
        $monthlyOrders[$data->month] = $data->total_orders;
    }

    $showModal = empty($sprovider->sprovider_name) || empty($sprovider->proEmail);

    return view('stadmin.ServicePadminDashboard', compact(
        'showModal',
        'sprovider',
        'orders',
        'revenueByServiceType',
        'percentageRating',
        'percentage',
        'totalService',
        'totalAmount',
        'totalRating',
        'ordersGraph',
        'locationData',
        'months',
        'monthlyOrders',
        'monthsRevenue',
        'datasets',
        'monthsPerformance',
        'monthlyRevenueData'
    ));
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
        return view('stadmin.customers.show', compact('clients','orders'));
    }
}
