@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Dashboard View -->
<div>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold" style="color: #C9A227;">Dashboard - Xế Hộ 24/7</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Tổng quan hệ thống đặt xe tài xế</p>
    </div>

    <!-- Revenue Report Cards -->
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
            <i class="fas fa-chart-line mr-2" style="color: #C9A227;"></i>Báo cáo doanh thu
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Today Revenue -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Doanh thu hôm nay</p>
                        <p class="text-2xl font-bold" style="color: #C9A227;">{{ number_format($stats['revenue_today'], 0, ',', '.') }}đ</p>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-calendar-day"></i> {{ Carbon\Carbon::today()->format('d/m/Y') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background-color: rgba(201, 162, 39, 0.1);">
                        <i class="fas fa-money-bill-wave text-xl" style="color: #C9A227;"></i>
                    </div>
                </div>
            </div>

            <!-- Week Revenue -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Doanh thu tuần này</p>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($stats['revenue_week'], 0, ',', '.') }}đ</p>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-calendar-week"></i> {{ Carbon\Carbon::now()->startOfWeek()->format('d/m') }} - {{ Carbon\Carbon::now()->endOfWeek()->format('d/m') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-wallet text-green-600 dark:text-green-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Month Revenue -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Doanh thu tháng này</p>
                        <p class="text-2xl font-bold text-blue-600">{{ number_format($stats['revenue_month'], 0, ',', '.') }}đ</p>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-calendar-alt"></i> Tháng {{ Carbon\Carbon::now()->month }}/{{ Carbon\Carbon::now()->year }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-coins text-blue-600 dark:text-blue-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Year Revenue -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Doanh thu năm nay</p>
                        <p class="text-2xl font-bold text-purple-600">{{ number_format($stats['revenue_year'], 0, ',', '.') }}đ</p>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-calendar"></i> Năm {{ Carbon\Carbon::now()->year }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-purple-600 dark:text-purple-400 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Report Cards -->
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
            <i class="fas fa-car mr-2" style="color: #C9A227;"></i>Báo cáo đặt xe tài xế
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Today Bookings -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Đặt xe hôm nay</p>
                        <p class="text-2xl font-bold" style="color: #C9A227;">{{ $stats['bookings_today'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-calendar-day"></i> {{ Carbon\Carbon::today()->format('d/m/Y') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background-color: rgba(201, 162, 39, 0.1);">
                        <i class="fas fa-car-side text-xl" style="color: #C9A227;"></i>
                    </div>
                </div>
            </div>

            <!-- Week Bookings -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Đặt xe tuần này</p>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['bookings_week'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-calendar-week"></i> {{ Carbon\Carbon::now()->startOfWeek()->format('d/m') }} - {{ Carbon\Carbon::now()->endOfWeek()->format('d/m') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-taxi text-green-600 dark:text-green-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Month Bookings -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Đặt xe tháng này</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $stats['bookings_month'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-calendar-alt"></i> Tháng {{ Carbon\Carbon::now()->month }}/{{ Carbon\Carbon::now()->year }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shuttle-van text-blue-600 dark:text-blue-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Year Bookings -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Đặt xe năm nay</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $stats['bookings_year'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-calendar"></i> Năm {{ Carbon\Carbon::now()->year }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-bar text-purple-600 dark:text-purple-400 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Charts Section -->
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
            <i class="fas fa-chart-bar mr-2" style="color: #C9A227;"></i>Biểu đồ doanh thu và đặt xe theo tháng ({{ Carbon\Carbon::now()->year }})
        </h2>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <canvas id="monthlyChart" height="80"></canvas>
        </div>
    </div>

    <!-- Today's Bookings List -->
    <div>
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
            <i class="fas fa-list mr-2" style="color: #C9A227;"></i>Danh sách đặt xe hôm nay ({{ Carbon\Carbon::today()->format('d/m/Y') }})
        </h2>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            @if($todayBookings->count() > 0)
                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Khách hàng</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Số điện thoại</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Điểm đón</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Điểm đến</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Khoảng cách</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Giá tiền</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Trạng thái</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Thời gian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($todayBookings as $booking)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">#{{ $booking->id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $booking->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $booking->phone }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ Str::limit($booking->pickup_location, 30) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ Str::limit($booking->dropoff_location, 30) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    @if($booking->distance)
                                        <span class="font-semibold">{{ number_format($booking->distance, 1) }} km</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold" style="color: #C9A227;">
                                    @if($booking->price)
                                        {{ number_format($booking->price, 0, ',', '.') }}đ
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                            'confirmed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                            'in_progress' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
                                            'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Chờ xác nhận',
                                            'confirmed' => 'Đã xác nhận',
                                            'in_progress' => 'Đang thực hiện',
                                            'completed' => 'Hoàn thành',
                                            'cancelled' => 'Đã hủy',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $statusLabels[$booking->status] ?? $booking->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $booking->created_at->format('H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($todayBookings as $booking)
                    <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">#{{ $booking->id }} - {{ $booking->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $booking->phone }}</p>
                            </div>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                    'confirmed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                    'in_progress' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
                                    'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                    'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                ];
                                $statusLabels = [
                                    'pending' => 'Chờ xác nhận',
                                    'confirmed' => 'Đã xác nhận',
                                    'in_progress' => 'Đang thực hiện',
                                    'completed' => 'Hoàn thành',
                                    'cancelled' => 'Đã hủy',
                                ];
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusLabels[$booking->status] ?? $booking->status }}
                            </span>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Điểm đón:</span>
                                <span class="text-gray-900 dark:text-white ml-2">{{ $booking->pickup_location }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Điểm đến:</span>
                                <span class="text-gray-900 dark:text-white ml-2">{{ $booking->dropoff_location }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-2 border-t border-gray-200 dark:border-gray-600">
                                <div>
                                    @if($booking->distance)
                                        <span class="text-gray-600 dark:text-gray-300">
                                            <i class="fas fa-route mr-1"></i>{{ number_format($booking->distance, 1) }} km
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    @if($booking->price)
                                        <span class="font-semibold text-lg" style="color: #C9A227;">{{ number_format($booking->price, 0, ',', '.') }}đ</span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400">
                                <i class="far fa-clock mr-1"></i>{{ $booking->created_at->format('H:i') }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="p-12 text-center">
                    <i class="fas fa-calendar-times text-5xl text-gray-300 dark:text-gray-600 mb-4"></i>
                    <p class="text-gray-500 dark:text-gray-400">Chưa có đặt xe nào hôm nay</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Monthly Chart
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [
                {
                    label: 'Doanh thu (VNĐ)',
                    data: {!! json_encode($chartRevenue) !!},
                    backgroundColor: 'rgba(201, 162, 39, 0.8)',
                    borderColor: 'rgba(201, 162, 39, 1)',
                    borderWidth: 1,
                    yAxisID: 'y',
                },
                {
                    label: 'Số lượng đặt xe',
                    data: {!! json_encode($chartBookings) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1,
                    yAxisID: 'y1',
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: '#9CA3AF',
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.datasetIndex === 0) {
                                // Revenue - format as currency
                                label += new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(context.parsed.y);
                            } else {
                                // Bookings - show count
                                label += context.parsed.y + ' chuyến';
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Doanh thu (VNĐ)',
                        color: '#C9A227'
                    },
                    ticks: {
                        color: '#9CA3AF',
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN').format(value) + 'đ';
                        }
                    },
                    grid: {
                        color: 'rgba(156, 163, 175, 0.1)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Số lượng đặt xe',
                        color: '#3B82F6'
                    },
                    ticks: {
                        color: '#9CA3AF',
                        stepSize: 1
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                },
                x: {
                    ticks: {
                        color: '#9CA3AF'
                    },
                    grid: {
                        color: 'rgba(156, 163, 175, 0.1)'
                    }
                }
            }
        }
    });
</script>
@endsection
