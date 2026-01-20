@extends('layouts.admin')

@section('title', 'Quản lý đặt xe tài xế')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">🚗 Quản lý đặt xe tài xế</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Xế Hộ 24/7 - Đà Nẵng</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ url('/') }}" target="_blank" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-external-link-alt mr-2"></i>Xem trang chủ
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Chờ xử lý</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $bookings->where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Đã xác nhận</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $bookings->where('status', 'confirmed')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-car text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Đã phân công</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $bookings->where('status', 'assigned')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-double text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Hoàn thành</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $bookings->where('status', 'completed')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-times-circle text-red-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Đã hủy</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $bookings->where('status', 'cancelled')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Thông tin khách</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Địa điểm</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ghi chú</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Trạng thái</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ngày tạo</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                #{{ $booking->id }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $booking->name }}</div>
                                    <div class="text-gray-500 dark:text-gray-400">
                                        <a href="tel:{{ $booking->phone }}" class="hover:text-blue-600">
                                            <i class="fas fa-phone mr-1"></i>{{ $booking->phone }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <div class="text-gray-900 dark:text-white">
                                        <i class="fas fa-map-marker-alt text-green-600 mr-1"></i>
                                        <span class="font-medium">Đón:</span> {{ Str::limit($booking->pickup_location, 30) }}
                                    </div>
                                    @if($booking->dropoff_location)
                                        <div class="text-gray-500 dark:text-gray-400 mt-1">
                                            <i class="fas fa-flag-checkered text-red-600 mr-1"></i>
                                            <span class="font-medium">Đến:</span> {{ Str::limit($booking->dropoff_location, 30) }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $booking->notes ? Str::limit($booking->notes, 40) : '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" 
                                            class="text-sm rounded-lg px-3 py-1.5 font-medium cursor-pointer
                                                   @if($booking->status == 'pending') bg-yellow-100 text-yellow-800 border-yellow-300
                                                   @elseif($booking->status == 'confirmed') bg-green-100 text-green-800 border-green-300
                                                   @elseif($booking->status == 'assigned') bg-blue-100 text-blue-800 border-blue-300
                                                   @elseif($booking->status == 'completed') bg-purple-100 text-purple-800 border-purple-300
                                                   @else bg-red-100 text-red-800 border-red-300
                                                   @endif
                                                   border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>⏳ Chờ xử lý</option>
                                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>✅ Đã xác nhận</option>
                                        <option value="assigned" {{ $booking->status == 'assigned' ? 'selected' : '' }}>🚗 Đã phân công</option>
                                        <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>✔️ Hoàn thành</option>
                                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>❌ Đã hủy</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                <div>{{ $booking->created_at->format('d/m/Y') }}</div>
                                <div class="text-xs">{{ $booking->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="tel:{{ $booking->phone }}" class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                    <i class="fas fa-phone mr-2"></i>Gọi
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                                    <p class="text-gray-500 dark:text-gray-400 text-lg">Chưa có đơn đặt xe nào</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Các đơn đặt xe mới sẽ hiển thị tại đây</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($bookings->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
