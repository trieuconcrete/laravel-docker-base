<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DriverBooking;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Today's date
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfYear = Carbon::now()->startOfYear();

        // Revenue and Booking Stats
        $stats = [
            // Daily stats
            'revenue_today' => DriverBooking::whereDate('created_at', $today)->sum('price'),
            'bookings_today' => DriverBooking::whereDate('created_at', $today)->count(),
            
            // Weekly stats
            'revenue_week' => DriverBooking::where('created_at', '>=', $startOfWeek)->sum('price'),
            'bookings_week' => DriverBooking::where('created_at', '>=', $startOfWeek)->count(),
            
            // Monthly stats
            'revenue_month' => DriverBooking::where('created_at', '>=', $startOfMonth)->sum('price'),
            'bookings_month' => DriverBooking::where('created_at', '>=', $startOfMonth)->count(),
            
            // Yearly stats
            'revenue_year' => DriverBooking::where('created_at', '>=', $startOfYear)->sum('price'),
            'bookings_year' => DriverBooking::where('created_at', '>=', $startOfYear)->count(),
        ];

        // Today's bookings list
        $todayBookings = DriverBooking::whereDate('created_at', $today)
            ->orderBy('created_at', 'desc')
            ->get();

        // Monthly chart data for current year
        $monthlyData = DriverBooking::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(price) as revenue'),
                DB::raw('COUNT(*) as bookings')
            )
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        // Prepare chart data (all 12 months)
        $chartLabels = [];
        $chartRevenue = [];
        $chartBookings = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = 'Tháng ' . $i;
            $chartRevenue[] = $monthlyData->get($i)->revenue ?? 0;
            $chartBookings[] = $monthlyData->get($i)->bookings ?? 0;
        }

        return view('admin.dashboard', compact(
            'stats',
            'todayBookings',
            'chartLabels',
            'chartRevenue',
            'chartBookings'
        ));
    }
}
