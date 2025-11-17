<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_users' => 12453,
            'new_orders' => 348,
            'job_postings' => 127,
            'posts' => 1284,
        ];

        $recent_activities = [
            [
                'title' => 'Đơn hàng mới <span class="font-semibold">#12453</span>',
                'time' => '5 phút trước',
                'icon' => 'shopping-cart',
                'color' => 'primary'
            ],
            [
                'title' => 'Người dùng mới đăng ký',
                'time' => '15 phút trước',
                'icon' => 'user-plus',
                'color' => 'green'
            ],
            [
                'title' => 'Tin tuyển dụng mới được đăng',
                'time' => '1 giờ trước',
                'icon' => 'briefcase',
                'color' => 'blue'
            ],
            [
                'title' => 'Bài viết mới được xuất bản',
                'time' => '2 giờ trước',
                'icon' => 'file-alt',
                'color' => 'purple'
            ],
        ];

        return view('admin.dashboard', compact('stats', 'recent_activities'));
    }
}
