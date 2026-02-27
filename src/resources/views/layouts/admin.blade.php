<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 600: '#2563eb', 700: '#1d4ed8', 50: '#eff6ff' }
                    }
                }
            }
        }
    </script>
    <style>[x-cloak] { display: none !important; }</style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50" x-data="{ sidebarOpen: window.innerWidth >= 768 }" @resize.window="sidebarOpen = window.innerWidth >= 768">

    <!-- Top Bar -->
    <div class="fixed top-0 left-0 right-0 h-14 bg-white border-b border-slate-200 z-40">
        <div class="flex items-center justify-between h-full px-4">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-50 rounded">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-layer-group text-white text-sm"></i>
                    </div>
                    <span class="hidden sm:block text-lg font-semibold text-slate-900">{{ config('app.name') }}</span>
                </div>
            </div>
            <div class="flex items-center gap-1 sm:gap-3">
                <button class="relative p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-50 rounded hidden sm:block">
                    <i class="far fa-bell"></i>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 p-1.5 hover:bg-slate-50 rounded">
                        @auth
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563eb&color=fff" class="w-8 h-8 rounded-full" alt="{{ auth()->user()->name }}">
                        <span class="hidden md:block text-sm font-medium text-slate-700">{{ auth()->user()->name }}</span>
                        @else
                        <img src="https://ui-avatars.com/api/?name=Guest&background=94a3b8&color=fff" class="w-8 h-8 rounded-full" alt="Guest">
                        @endauth
                        <i class="fas fa-chevron-down text-xs text-slate-600"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-slate-200 py-1 z-50">
                        <!-- User Info -->
                        @auth
                        <div class="px-4 py-3 border-b border-slate-200">
                            <p class="text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        @endauth
                        
                        <!-- Menu Items -->
                        <a href="{{ route('admin.profile') }}" class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                            <i class="fas fa-user-circle w-4 mr-3 text-slate-400"></i>
                            <span>My Profile</span>
                        </a>
                        <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                            <i class="fas fa-cog w-4 mr-3 text-slate-400"></i>
                            <span>Settings</span>
                        </a>
                        
                        <div class="border-t border-slate-200 my-1"></div>
                        
                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <i class="fas fa-sign-out-alt w-4 mr-3"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false" 
         x-cloak
         class="md:hidden fixed inset-0 bg-slate-900/50 z-40 top-14"></div>

    <!-- Sidebar -->
    <aside x-show="sidebarOpen" 
           x-transition:enter="transition ease-out duration-200"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition ease-in duration-150"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           class="fixed left-0 top-14 bottom-0 w-64 bg-white border-r border-slate-200 z-50 overflow-y-auto transform">
        <div class="p-4">@include('partials.sidebar-menu')</div>
    </aside>

    <!-- Main -->
    <main :class="sidebarOpen ? 'md:ml-64' : 'ml-0'" class="pt-14 min-h-screen transition-all duration-300">
        <div class="p-4 sm:p-6">@yield('content')</div>
    </main>

</body>
</html>
