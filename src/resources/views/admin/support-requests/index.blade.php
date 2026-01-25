@extends('layouts.admin')

@section('title', 'Quản lý yêu cầu hỗ trợ')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
            <i class="fas fa-headset mr-2"></i>Yêu cầu hỗ trợ
        </h1>
        <p class="text-gray-600 dark:text-gray-400">Quản lý tất cả yêu cầu hỗ trợ từ khách hàng</p>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6 p-4">
        <form method="GET" action="{{ route('admin.support-requests.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-search mr-1"></i>Tìm kiếm
                </label>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Tên, số điện thoại, nội dung..." 
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                >
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-filter mr-1"></i>Trạng thái
                </label>
                <select 
                    name="status" 
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                >
                    <option value="">Tất cả</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Chờ xử lý</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>🔄 Đang xử lý</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>✅ Đã giải quyết</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>🔒 Đã đóng</option>
                </select>
            </div>

            <!-- Actions -->
            <div class="flex items-end gap-2">
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex-1">
                    <i class="fas fa-search mr-2"></i>Lọc
                </button>
                <a href="{{ route('admin.support-requests.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition-colors">
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" style="min-width: 180px;">Thông tin</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" style="min-width: 300px;">Nội dung</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" style="min-width: 160px;">Trạng thái</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" style="min-width: 100px;">Ngày gửi</th>
                        <th scope="col" class="sticky right-0 bg-gray-50 dark:bg-gray-900 px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider shadow-[-4px_0_6px_-1px_rgba(0,0,0,0.1)]" style="min-width: 120px;">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($requests as $request)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white" style="min-width: 60px;">
                                #{{ $request->id }}
                            </td>
                            <td class="px-6 py-4" style="min-width: 180px;">
                                <div class="text-sm">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $request->name }}</div>
                                    <a href="tel:{{ $request->phone }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                        <i class="fas fa-phone mr-1"></i>{{ $request->phone }}
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4" style="min-width: 300px;">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ Str::limit($request->message, 100) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap" style="min-width: 160px;">
                                <form action="{{ route('admin.support-requests.update-status', $request) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" 
                                            class="text-sm rounded-lg px-3 py-1.5 font-medium cursor-pointer
                                                   @if($request->status == 'pending') bg-yellow-100 text-yellow-800 border-yellow-300
                                                   @elseif($request->status == 'in_progress') bg-blue-100 text-blue-800 border-blue-300
                                                   @elseif($request->status == 'resolved') bg-green-100 text-green-800 border-green-300
                                                   @else bg-gray-100 text-gray-800 border-gray-300
                                                   @endif
                                                   border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                        <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>⏳ Chờ xử lý</option>
                                        <option value="in_progress" {{ $request->status == 'in_progress' ? 'selected' : '' }}>🔄 Đang xử lý</option>
                                        <option value="resolved" {{ $request->status == 'resolved' ? 'selected' : '' }}>✅ Đã giải quyết</option>
                                        <option value="closed" {{ $request->status == 'closed' ? 'selected' : '' }}>🔒 Đã đóng</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400" style="min-width: 100px;">
                                <div>{{ $request->created_at->format('d/m/Y') }}</div>
                                <div class="text-xs">{{ $request->created_at->format('H:i') }}</div>
                            </td>
                            <td class="sticky right-0 bg-white dark:bg-gray-800 px-6 py-4 whitespace-nowrap text-right text-sm font-medium shadow-[-4px_0_6px_-1px_rgba(0,0,0,0.1)]" style="min-width: 120px;">
                                <a href="tel:{{ $request->phone }}" class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors mr-2">
                                    <i class="fas fa-phone mr-2"></i>Gọi
                                </a>
                                <form action="{{ route('admin.support-requests.destroy', $request) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa yêu cầu này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                                    <p class="text-gray-500 dark:text-gray-400 text-lg">Chưa có yêu cầu hỗ trợ nào</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Các yêu cầu hỗ trợ từ khách hàng sẽ hiển thị tại đây</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden p-4">
            @forelse($requests as $request)
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4 shadow">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">#{{ $request->id }}</div>
                            <div class="font-bold text-gray-900 dark:text-white mt-1">{{ $request->name }}</div>
                            <a href="tel:{{ $request->phone }}" class="text-sm text-blue-600 dark:text-blue-400">
                                <i class="fas fa-phone mr-1"></i>{{ $request->phone }}
                            </a>
                        </div>
                        <form action="{{ route('admin.support-requests.update-status', $request) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" 
                                    class="text-xs rounded-lg px-2 py-1 font-medium cursor-pointer
                                           @if($request->status == 'pending') bg-yellow-100 text-yellow-800 border-yellow-300
                                           @elseif($request->status == 'in_progress') bg-blue-100 text-blue-800 border-blue-300
                                           @elseif($request->status == 'resolved') bg-green-100 text-green-800 border-green-300
                                           @else bg-gray-100 text-gray-800 border-gray-300
                                           @endif
                                           border">
                                <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>⏳ Chờ</option>
                                <option value="in_progress" {{ $request->status == 'in_progress' ? 'selected' : '' }}>🔄 Đang xử lý</option>
                                <option value="resolved" {{ $request->status == 'resolved' ? 'selected' : '' }}>✅ Xong</option>
                                <option value="closed" {{ $request->status == 'closed' ? 'selected' : '' }}>🔒 Đóng</option>
                            </select>
                        </form>
                    </div>

                    <div class="mb-3">
                        <div class="text-sm text-gray-700 dark:text-gray-300">
                            <strong>Nội dung:</strong>
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            {{ Str::limit($request->message, 150) }}
                        </div>
                    </div>

                    <div class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-400 mb-3">
                        <span><i class="fas fa-clock mr-1"></i>{{ $request->created_at->format('d/m/Y H:i') }}</span>
                    </div>

                    <div class="flex gap-2">
                        <a href="tel:{{ $request->phone }}" class="flex-1 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-center rounded-lg transition-colors text-sm">
                            <i class="fas fa-phone mr-1"></i>Gọi
                        </a>
                        <form action="{{ route('admin.support-requests.destroy', $request) }}" method="POST" class="flex-1" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors text-sm">
                                <i class="fas fa-trash mr-1"></i>Xóa
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-gray-400 text-4xl mb-3"></i>
                    <p class="text-gray-500 dark:text-gray-400">Chưa có yêu cầu hỗ trợ nào</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($requests->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
