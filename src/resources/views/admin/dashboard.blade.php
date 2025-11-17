@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Dashboard View -->
<div>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Dashboard</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Tổng quan hệ thống</p>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Card 1 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Tổng người dùng</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['total_users'] ?? '12,453' }}</p>
                    <p class="text-xs text-green-600 mt-1">
                        <i class="fas fa-arrow-up"></i> +12.5% so với tháng trước
                    </p>
                </div>
                <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-primary-600 dark:text-primary-400 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Đơn hàng mới</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['new_orders'] ?? '348' }}</p>
                    <p class="text-xs text-green-600 mt-1">
                        <i class="fas fa-arrow-up"></i> +8.2% so với tháng trước
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-green-600 dark:text-green-400 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Tin tuyển dụng</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['job_postings'] ?? '127' }}</p>
                    <p class="text-xs text-blue-600 mt-1">
                        <i class="fas fa-arrow-up"></i> +5.3% so với tháng trước
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-briefcase text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Bài viết</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['posts'] ?? '1,284' }}</p>
                    <p class="text-xs text-purple-600 mt-1">
                        <i class="fas fa-arrow-up"></i> +15.8% so với tháng trước
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Hoạt động gần đây</h3>
            <div class="space-y-4">
                @forelse($recent_activities ?? [] as $activity)
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-{{ $activity['color'] }}-100 dark:bg-{{ $activity['color'] }}-900/20 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-{{ $activity['icon'] }} text-{{ $activity['color'] }}-600 dark:text-{{ $activity['color'] }}-400 text-xs"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-800 dark:text-gray-200">{{ $activity['title'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity['time'] }}</p>
                    </div>
                </div>
                @empty
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-primary-100 dark:bg-primary-900/20 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-shopping-cart text-primary-600 dark:text-primary-400 text-xs"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-800 dark:text-gray-200">Đơn hàng mới <span class="font-semibold">#12453</span></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">5 phút trước</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user-plus text-green-600 dark:text-green-400 text-xs"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-800 dark:text-gray-200">Người dùng mới đăng ký</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">15 phút trước</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Thao tác nhanh</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.products.create') }}" class="w-full flex items-center px-4 py-3 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-900/30 transition-colors">
                    <i class="fas fa-plus-circle mr-3"></i>
                    <span class="text-sm font-medium">Thêm sản phẩm mới</span>
                </a>

                <a href="{{ route('admin.posts.create') }}" class="w-full flex items-center px-4 py-3 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                    <i class="fas fa-pen mr-3"></i>
                    <span class="text-sm font-medium">Viết bài mới</span>
                </a>

                <a href="{{ route('admin.jobs.create') }}" class="w-full flex items-center px-4 py-3 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                    <i class="fas fa-briefcase mr-3"></i>
                    <span class="text-sm font-medium">Đăng tin tuyển dụng</span>
                </a>

                <a href="{{ route('admin.users.create') }}" class="w-full flex items-center px-4 py-3 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                    <i class="fas fa-user-plus mr-3"></i>
                    <span class="text-sm font-medium">Thêm người dùng</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
