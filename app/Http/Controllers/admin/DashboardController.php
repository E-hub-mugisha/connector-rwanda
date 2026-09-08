<?php

namespace App\Http\Controllers\admin;

use App\Exports\ServiceExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ServiceBooking;
use App\Models\ServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Summary statistics
        |--------------------------------------------------------------------------
        */

        $totalSales = Order::where('status', 'delivered')->count();

        $totalRevenue = (float) ServiceBooking::sum('total');

        $totalBookings = ServiceBooking::count();

        $totalSprovider = ServiceProvider::count();

        $totalUsers = User::count();


        /*
        |--------------------------------------------------------------------------
        | Recent bookings
        |--------------------------------------------------------------------------
        */

        $orders = ServiceBooking::latest('created_at')
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Recent orders
        |--------------------------------------------------------------------------
        */

        $porders = Order::latest('created_at')
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Bookings by week
        |--------------------------------------------------------------------------
        */

        $bookings = ServiceBooking::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%U') as week"),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        $data = $bookings->map(function ($booking) {
            return [
                'week' => $booking->week,
                'count' => (int) $booking->total,
            ];
        })->values()->toArray();


        /*
        |--------------------------------------------------------------------------
        | Booking status
        |--------------------------------------------------------------------------
        */

        $services = ServiceBooking::select(
                'status',
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('status')
            ->get();

        $done = $services->map(function ($service) {
            return [
                'status' => $service->status ?: 'Unknown',
                'count' => (int) $service->count,
            ];
        })->values()->toArray();


        /*
        |--------------------------------------------------------------------------
        | Providers by category
        |--------------------------------------------------------------------------
        */

        $providers = ServiceProvider::with('category')
            ->select(
                'service_category_id',
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('service_category_id')
            ->get();

        $providerCategoryData = $providers->map(function ($provider) {
            return [
                'category' => optional($provider->category)->name
                    ?? optional($provider->category)->title
                    ?? 'Uncategorized',
                'count' => (int) $provider->count,
            ];
        })->values()->toArray();


        /*
        |--------------------------------------------------------------------------
        | User registrations
        |--------------------------------------------------------------------------
        |
        | Last 12 months rather than all historical data.
        |
        */

        $userData = User::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $userRegistrationData = $userData->map(function ($item) {
            return [
                'month' => $item->month,
                'count' => (int) $item->count,
            ];
        })->values()->toArray();


        /*
        |--------------------------------------------------------------------------
        | Payment methods
        |--------------------------------------------------------------------------
        */

        $bookingData = ServiceBooking::select(
                DB::raw("COALESCE(payment_mode, 'Unknown') as payment_mode"),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('payment_mode')
            ->get();

        $paymentData = $bookingData->map(function ($item) {
            return [
                'payment_mode' => $item->payment_mode,
                'count' => (int) $item->count,
            ];
        })->values()->toArray();


        /*
        |--------------------------------------------------------------------------
        | Pending bookings
        |--------------------------------------------------------------------------
        |
        | We check the common pending status without hardcoding
        | this number in the UI.
        |
        */

        $pendingBookings = ServiceBooking::where('status', 'pending')->count();


        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        return view('admin.admin-dashboard-component', [
            'orders' => $orders,
            'porders' => $porders,

            'data' => $data,
            'done' => $done,

            'userData' => $userRegistrationData,
            'bookingData' => $paymentData,

            'providers' => $providers,
            'providerCategoryData' => $providerCategoryData,

            'bookings' => $bookings,
            'services' => $services,

            'totalSales' => $totalSales,
            'totalRevenue' => $totalRevenue,
            'totalBooking' => $totalBookings,
            'totalSprovider' => $totalSprovider,
            'totalUsers' => $totalUsers,
            'pendingBookings' => $pendingBookings,
        ]);
    }


    /**
     * Export services report.
     */
    public function exportExcel()
    {
        return Excel::download(
            new ServiceExport,
            'services.xls'
        );
    }

}