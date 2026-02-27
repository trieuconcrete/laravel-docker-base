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
<body class="bg-slate-50" x-data="{ sidebarOpen: true }">

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
                    <span class="text-lg font-semibold text-slate-900">{{ config('app.name') }}</span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button class="relative p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-50 rounded">
                    <i class="far fa-bell"></i>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 p-1.5 hover:bg-slate-50 rounded">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=2563eb&color=fff" class="w-8 h-8 rounded-full">
                        <i class="fas fa-chevron-down text-xs text-slate-600"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 py-1">
                        <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50"><i class="fas fa-user-circle w-4 mr-2"></i>Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50"><i class="fas fa-cog w-4 mr-2"></i>Settings</a>
                        <div class="border-t border-slate-200 my-1"></div>
                        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50"><i class="fas fa-sign-out-alt w-4 mr-2"></i>Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <aside x-show="sidebarOpen" class="fixed left-0 top-14 bottom-0 w-64 bg-white border-r border-slate-200 z-30 overflow-y-auto">
        <div class="p-4">@include('partials.sidebar-menu')</div>
    </aside>

    <!-- Main -->
    <main :class="sidebarOpen ? 'ml-64' : 'ml-0'" class="pt-14 min-h-screen transition-all duration-300">
        <div class="p-6">@yield('content')</div>
    </main>

</body>
</html>
