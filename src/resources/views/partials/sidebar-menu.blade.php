<!-- Driver Bookings (Xế Hộ 24/7) -->
<a href="{{ route('admin.bookings.index') }}" 
   class="flex items-center px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.bookings.*') ? 'bg-white/20 backdrop-blur-sm text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}"
   data-menu="bookings">
    <i class="fas fa-car w-5"></i>
    <span class="ml-3 font-medium">Đơn đặt xe tài xế</span>
    @if(isset($pendingBookings) && $pendingBookings > 0)
        <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $pendingBookings }}</span>
    @endif
</a>
