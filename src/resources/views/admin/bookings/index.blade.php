@extends('layouts.admin')

@section('title', 'Quản lý đặt xe tài xế')

@push('styles')
<style>
    @media (max-width: 768px) {
        .booking-card {
            background: white;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .dark .booking-card {
            background: rgb(31 41 55);
        }
        .booking-card-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        .dark .booking-card-header {
            border-bottom-color: rgb(55 65 81);
        }
        .booking-card-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
        }
        .booking-card-label {
            color: #6b7280;
            font-weight: 500;
        }
        .dark .booking-card-label {
            color: rgb(156 163 175);
        }
        .booking-card-value {
            color: #111827;
            font-weight: 500;
            text-align: right;
        }
        .dark .booking-card-value {
            color: white;
        }
    }
</style>
@endpush

@section('content')
<div class="p-4 md:p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">🚗 Quản lý đặt xe tài xế</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Xế Hộ 24/7 - Đà Nẵng</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ url('/') }}" target="_blank" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    <span class="hidden sm:inline">Xem trang chủ</span>
                    <span class="sm:hidden">Trang chủ</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 md:gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-3 md:p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-lg md:text-xl"></i>
                    </div>
                </div>
                <div class="ml-3 md:ml-4">
                    <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400">Chờ xử lý</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">{{ $bookings->where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-3 md:p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-lg md:text-xl"></i>
                    </div>
                </div>
                <div class="ml-3 md:ml-4">
                    <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400">Đã xác nhận</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">{{ $bookings->where('status', 'confirmed')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-3 md:p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-car text-blue-600 text-lg md:text-xl"></i>
                    </div>
                </div>
                <div class="ml-3 md:ml-4">
                    <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400">Đã phân công</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">{{ $bookings->where('status', 'assigned')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-3 md:p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-double text-purple-600 text-lg md:text-xl"></i>
                    </div>
                </div>
                <div class="ml-3 md:ml-4">
                    <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400">Hoàn thành</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">{{ $bookings->where('status', 'completed')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-3 md:p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-times-circle text-red-600 text-lg md:text-xl"></i>
                    </div>
                </div>
                <div class="ml-3 md:ml-4">
                    <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400">Đã hủy</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">{{ $bookings->where('status', 'cancelled')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6">
        <form method="GET" action="{{ route('admin.bookings.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-calendar mr-1"></i>Từ ngày
                </label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-calendar mr-1"></i>Đến ngày
                </label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-filter mr-1"></i>Trạng thái
                </label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                    <option value="">Tất cả trạng thái</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Chờ xử lý</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>✅ Đã xác nhận</option>
                    <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>🚗 Đã phân công</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>✔️ Hoàn thành</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>❌ Đã hủy</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-primary-500 hover:bg-primary-600 text-black font-medium rounded-lg transition-colors">
                    <i class="fas fa-search mr-2"></i>Lọc
                </button>
                <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="sticky top-0 bg-gray-50 dark:bg-gray-900 z-10 shadow-[0_2px_4px_rgba(0,0,0,0.1)]">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" style="min-width: 60px;">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" style="min-width: 180px;">Thông tin khách</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" style="min-width: 280px;">Địa điểm</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" style="min-width: 100px;">Quãng đường</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" style="min-width: 110px;">Thành tiền</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" style="min-width: 200px;">Ghi chú</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" style="min-width: 160px;">Trạng thái</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" style="min-width: 100px;">Ngày tạo</th>
                        <th scope="col" class="sticky right-0 bg-gray-50 dark:bg-gray-900 px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider shadow-[-4px_0_6px_-1px_rgba(0,0,0,0.1)]" style="min-width: 120px;">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white" style="min-width: 60px;">
                                #{{ $booking->id }}
                            </td>
                            <td class="px-6 py-4" style="min-width: 180px;">
                                <div class="text-sm">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $booking->name }}</div>
                                    <div class="text-gray-500 dark:text-gray-400">
                                        <a href="tel:{{ $booking->phone }}" class="hover:text-blue-600">
                                            <i class="fas fa-phone mr-1"></i>{{ $booking->phone }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4" style="min-width: 280px;">
                                <div class="text-sm">
                                    <div class="text-gray-900 dark:text-white">
                                        <i class="fas fa-map-marker-alt text-green-600 mr-1"></i>
                                        <span class="font-medium">Đón:</span> {{ Str::limit($booking->pickup_location, 50) }}
                                    </div>
                                    @if($booking->dropoff_location)
                                        <div class="text-gray-500 dark:text-gray-400 mt-1">
                                            <i class="fas fa-flag-checkered text-red-600 mr-1"></i>
                                            <span class="font-medium">Đến:</span> {{ Str::limit($booking->dropoff_location, 50) }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap" style="min-width: 100px;">
                                <div class="text-sm">
                                    @if($booking->distance)
                                        <span class="text-gray-900 dark:text-white font-medium">{{ number_format($booking->distance, 1) }} km</span>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap" style="min-width: 110px;">
                                <div class="text-sm">
                                    @if($booking->price)
                                        <span class="text-primary-500 dark:text-primary-400 font-bold">{{ number_format($booking->price, 0, ',', '.') }}đ</span>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">Liên hệ</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4" style="min-width: 200px;">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $booking->notes ? Str::limit($booking->notes, 60) : '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap" style="min-width: 160px;">
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400" style="min-width: 100px;">
                                <div>{{ $booking->created_at->format('d/m/Y') }}</div>
                                <div class="text-xs">{{ $booking->created_at->format('H:i') }}</div>
                            </td>
                            <td class="sticky right-0 bg-white dark:bg-gray-800 px-6 py-4 whitespace-nowrap text-right text-sm font-medium shadow-[-4px_0_6px_-1px_rgba(0,0,0,0.1)]" style="min-width: 120px;">
                                <a href="tel:{{ $booking->phone }}" class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                    <i class="fas fa-phone mr-2"></i>Gọi
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
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

        <!-- Mobile Card View -->
        <div class="md:hidden p-4">
            @forelse($bookings as $booking)
                <div class="booking-card">
                    <div class="booking-card-header">
                        <div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">#{!! $booking->id !!}</div>
                            <div class="font-bold text-gray-900 dark:text-white mt-1">{{ $booking->name }}</div>
                            <a href="tel:{{ $booking->phone }}" class="text-sm text-blue-600 dark:text-blue-400">
                                <i class="fas fa-phone mr-1"></i>{{ $booking->phone }}
                            </a>
                        </div>
                        <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" 
                                    class="text-xs rounded-lg px-2 py-1 font-medium cursor-pointer border
                                           @if($booking->status == 'pending') bg-yellow-100 text-yellow-800 border-yellow-300
                                           @elseif($booking->status == 'confirmed') bg-green-100 text-green-800 border-green-300
                                           @elseif($booking->status == 'assigned') bg-blue-100 text-blue-800 border-blue-300
                                           @elseif($booking->status == 'completed') bg-purple-100 text-purple-800 border-purple-300
                                           @else bg-red-100 text-red-800 border-red-300
                                           @endif">
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>⏳ Chờ</option>
                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>✅ Xác nhận</option>
                                <option value="assigned" {{ $booking->status == 'assigned' ? 'selected' : '' }}>🚗 Phân công</option>
                                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>✔️ Hoàn thành</option>
                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>❌ Hủy</option>
                            </select>
                        </form>
                    </div>

                    <div class="booking-card-row">
                        <span class="booking-card-label"><i class="fas fa-map-marker-alt text-green-600 mr-1"></i>Điểm đón:</span>
                        <span class="booking-card-value">{{ Str::limit($booking->pickup_location, 25) }}</span>
                    </div>

                    @if($booking->dropoff_location)
                    <div class="booking-card-row">
                        <span class="booking-card-label"><i class="fas fa-flag-checkered text-red-600 mr-1"></i>Điểm đến:</span>
                        <span class="booking-card-value">{{ Str::limit($booking->dropoff_location, 25) }}</span>
                    </div>
                    @endif

                    @if($booking->distance)
                    <div class="booking-card-row">
                        <span class="booking-card-label"><i class="fas fa-road mr-1"></i>Quãng đường:</span>
                        <span class="booking-card-value font-bold">{{ number_format($booking->distance, 1) }} km</span>
                    </div>
                    @endif

                    @if($booking->price)
                    <div class="booking-card-row">
                        <span class="booking-card-label"><i class="fas fa-money-bill-wave mr-1"></i>Thành tiền:</span>
                        <span class="booking-card-value font-bold" style="color: #C9A227;">{{ number_format($booking->price, 0, ',', '.') }}đ</span>
                    </div>
                    @endif

                    @if($booking->notes)
                    <div class="booking-card-row">
                        <span class="booking-card-label"><i class="fas fa-sticky-note mr-1"></i>Ghi chú:</span>
                        <span class="booking-card-value text-xs">{{ Str::limit($booking->notes, 30) }}</span>
                    </div>
                    @endif

                    <div class="booking-card-row">
                        <span class="booking-card-label"><i class="fas fa-clock mr-1"></i>Ngày tạo:</span>
                        <span class="booking-card-value">{{ $booking->created_at->format('d/m/Y H:i') }}</span>
                    </div>

                    <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                        <a href="tel:{{ $booking->phone }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium">
                            <i class="fas fa-phone mr-2"></i>Gọi khách hàng
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                    <p class="text-gray-500 dark:text-gray-400 text-lg">Chưa có đơn đặt xe nào</p>
                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Các đơn đặt xe mới sẽ hiển thị tại đây</p>
                </div>
            @endforelse
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
