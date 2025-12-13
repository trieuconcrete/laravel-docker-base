<?php

namespace App\Http\Controllers\Flowgram\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $lastMonthUsers = User::where('role', 'user')
            ->where('created_at', '<', now()->startOfMonth())
            ->count();
        $usersGrowth = $lastMonthUsers > 0 
            ? round((($totalUsers - $lastMonthUsers) / $lastMonthUsers) * 100) 
            : 100;

        $monthlyRevenue = Payment::whereMonth('billing_date', now()->month)
            ->whereYear('billing_date', now()->year)
            ->where('status', 'paid')
            ->sum('amount');
        $lastMonthRevenue = Payment::whereMonth('billing_date', now()->subMonth()->month)
            ->whereYear('billing_date', now()->subMonth()->year)
            ->where('status', 'paid')
            ->sum('amount');
        $revenueGrowth = $lastMonthRevenue > 0 
            ? round((($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100) 
            : 0;

        $monthlyOrders = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $lastMonthOrders = Order::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $ordersGrowth = $lastMonthOrders > 0 
            ? round((($monthlyOrders - $lastMonthOrders) / $lastMonthOrders) * 100) 
            : 0;

        $pendingInquiries = ContactInquiry::where('status', 'new')->count();

        $stats = [
            'total_users' => $totalUsers,
            'users_growth' => $usersGrowth,
            'monthly_revenue' => $monthlyRevenue,
            'revenue_growth' => $revenueGrowth,
            'monthly_orders' => $monthlyOrders,
            'orders_growth' => $ordersGrowth,
            'pending_inquiries' => $pendingInquiries,
        ];

        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $pendingInquiries = ContactInquiry::where('status', 'new')
            ->latest()
            ->take(5)
            ->get();

        return view('flowgram.admin.dashboard', compact('stats', 'recentOrders', 'pendingInquiries'));
    }
}

