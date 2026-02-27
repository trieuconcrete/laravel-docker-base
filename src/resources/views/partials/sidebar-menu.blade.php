<!-- Navigation Menu -->
<nav class="space-y-1">
    
    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}" 
       class="flex items-center px-3 py-2.5 rounded text-sm transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-50' }}">
        <i class="fas fa-home w-5"></i>
        <span class="ml-3 font-medium">Dashboard</span>
    </a>

    <!-- User Management -->
    <div x-data="{ open: {{ request()->is('admin/users*') ? 'true' : 'false' }} }">
        <button @click="open = !open" 
                class="w-full flex items-center justify-between px-3 py-2.5 rounded text-sm transition-all {{ request()->is('admin/users*') ? 'bg-slate-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50' }}">
            <div class="flex items-center">
                <i class="fas fa-users w-5"></i>
                <span class="ml-3 font-medium">Users</span>
            </div>
            <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs"></i>
        </button>
        <div x-show="open" x-cloak class="ml-8 mt-1 space-y-0.5">
            <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.users.index') ? 'text-blue-600 font-medium bg-blue-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">Tài khoản</a>
            <a href="{{ route('admin.users.roles') }}" class="block px-3 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.users.roles') ? 'text-blue-600 font-medium bg-blue-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">Phân quyền</a>
            <a href="{{ route('admin.users.logs') }}" class="block px-3 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.users.logs') ? 'text-blue-600 font-medium bg-blue-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">Nhật ký</a>
        </div>
    </div>

</nav>
