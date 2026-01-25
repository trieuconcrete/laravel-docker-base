<!-- Dashboard -->
<a href="{{ route('admin.dashboard') }}" 
   class="flex items-center px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-primary-500/20 backdrop-blur-sm text-primary-500' : 'text-white/70 hover:bg-primary-500/10 hover:text-primary-400' }}"
   data-menu="dashboard">
    <i class="fas fa-tachometer-alt w-5"></i>
    <span class="ml-3 font-medium">Báo cáo</span>
</a>

<!-- Driver Bookings (Xế Hộ 24/7) -->
<a href="{{ route('admin.bookings.index') }}" 
   class="flex items-center px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.bookings.*') ? 'bg-primary-500/20 backdrop-blur-sm text-primary-500' : 'text-white/70 hover:bg-primary-500/10 hover:text-primary-400' }}"
   data-menu="bookings">
    <i class="fas fa-car w-5"></i>
    <span class="ml-3 font-medium">Đơn đặt xe tài xế</span>
    @if(isset($pendingBookings) && $pendingBookings > 0)
        <span class="ml-auto bg-primary-500 text-black text-xs font-bold px-2 py-1 rounded-full">{{ $pendingBookings }}</span>
    @endif
</a>

<!-- Support Requests -->
<a href="{{ route('admin.support-requests.index') }}" 
   class="flex items-center px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.support-requests.*') ? 'bg-primary-500/20 backdrop-blur-sm text-primary-500' : 'text-white/70 hover:bg-primary-500/10 hover:text-primary-400' }}"
   data-menu="support-requests">
    <i class="fas fa-headset w-5"></i>
    <span class="ml-3 font-medium">Yêu cầu hỗ trợ</span>
</a>
