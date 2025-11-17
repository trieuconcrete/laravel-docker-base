<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'AdminPro') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-transition { transition: all 0.3s ease-in-out; }
        .sidebar-gradient {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.95) 0%, rgba(59, 130, 246, 0.95) 100%), url(https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=2000) center / cover no-repeat;
            position: relative;
            overflow: hidden;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
    
    <div class="flex h-screen overflow-hidden" x-data="dashboardData()">
        
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'" 
               class="sidebar-gradient fixed md:static inset-y-0 left-0 z-50 w-64 from-primary-600 to-primary-700 dark:from-primary-700 dark:to-primary-800 sidebar-transition transform md:transform-none">
            
            <!-- Logo -->
            <div class="flex items-center justify-between h-16 px-6 border-b border-primary-500/30">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                        <i class="fas fa-cube text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold text-white">{{ config('app.name', 'AdminPro') }}</span>
                </div>
                <button @click="sidebarOpen = false" class="md:hidden text-white/80 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto" x-data="{ activeMenu: '{{ request()->is('admin/cms/*') ? 'cms' : (request()->is('admin/crm/*') ? 'crm' : (request()->is('admin/products*') || request()->is('admin/orders*') || request()->is('admin/customers*') || request()->is('admin/inventory*') || request()->is('admin/analytics*') ? 'ecommerce' : (request()->is('admin/jobs/*') ? 'jobs' : (request()->is('admin/users*') ? 'users' : '')))) }}' }">
                @include('partials.sidebar-menu')
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Header -->
            <header class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-6">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <!-- Search -->
                    <div class="hidden md:flex items-center">
                        <div class="relative">
                            <input type="text" placeholder="Tìm kiếm..." 
                                   class="w-64 pl-10 pr-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 dark:text-gray-200">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <button @click="toggleDarkMode()" class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i :class="darkMode ? 'fa-sun' : 'fa-moon'" class="fas"></i>
                    </button>

                    <!-- Notifications -->
                    <button class="relative p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-bell"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>

                    <!-- Profile -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin User') }}&background=0ea5e9&color=fff" 
                                 class="w-9 h-9 rounded-full border-2 border-primary-500">
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ auth()->user()->name ?? 'Admin User' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->role ?? 'Super Admin' }}</p>
                            </div>
                            <i class="fas fa-chevron-down text-xs text-gray-500 dark:text-gray-400"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak
                             class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-2 z-50">
                            <a href="{{ route('admin.profile') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-user mr-2"></i> Hồ sơ
                            </a>
                            <a href="{{ route('admin.settings') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-cog mr-2"></i> Cài đặt
                            </a>
                            <hr class="my-2 border-gray-200 dark:border-gray-700">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-4 p-4 bg-green-100 dark:bg-green-900/20 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-400 rounded-lg">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-4 p-4 bg-red-100 dark:bg-red-900/20 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-400 rounded-lg">
                    {{ session('error') }}
                </div>
                @endif

                @yield('content')
            </main>
        </div>

        <!-- Mobile overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" 
             class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden" x-cloak></div>
    </div>

    <script>
        function dashboardData() {
            return {
                sidebarOpen: false,
                currentModule: '{{ request()->route()->getName() ?? 'dashboard' }}',
                darkMode: localStorage.getItem('darkMode') === 'true',
                
                init() {
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                    }
                    this.activateMenu();
                },
                
                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('darkMode', this.darkMode);
                    document.documentElement.classList.toggle('dark');
                },
                
                activateMenu() {
                    // Get current path
                    const currentPath = window.location.pathname;
                    
                    // Get all menu links
                    const menuLinks = document.querySelectorAll('nav a');
                    
                    menuLinks.forEach(link => {
                        const linkPath = new URL(link.href).pathname;
                        
                        // Remove active classes first
                        link.classList.remove('bg-white/20', 'backdrop-blur-sm', 'text-white');
                        
                        // Add active class if paths match
                        if (currentPath === linkPath) {
                            link.classList.add('bg-white/20', 'backdrop-blur-sm', 'text-white');
                        } else if (!link.classList.contains('text-white')) {
                            link.classList.add('text-white/70');
                        }
                    });
                    
                    // Auto-expand parent menu if child is active
                    this.autoExpandActiveMenu();
                },
                
autoExpandActiveMenu() {
                    const currentPath = window.location.pathname;
                    
                    // Auto-expand and activate parent menu based on current route
                    const parentMenus = document.querySelectorAll('nav button');
                    
                    parentMenus.forEach(button => {
                        const parentDiv = button.closest('div[x-data]');
                        if (!parentDiv) return;
                        
                        // Check CMS routes
                        if (currentPath.includes('/admin/cms/')) {
                            if (button.textContent.includes('CMS')) {
                                button.classList.remove('text-white/70');
                                button.classList.add('bg-white/20', 'backdrop-blur-sm', 'text-white');
                                Alpine.evaluate(parentDiv, 'open = true');
                            }
                        }
                        
                        // Check CRM routes
                        if (currentPath.includes('/admin/crm/')) {
                            if (button.textContent.includes('CRM')) {
                                button.classList.remove('text-white/70');
                                button.classList.add('bg-white/20', 'backdrop-blur-sm', 'text-white');
                                Alpine.evaluate(parentDiv, 'open = true');
                            }
                        }
                        
                        // Check E-commerce routes
                        if (currentPath.includes('/admin/products') || 
                            currentPath.includes('/admin/orders') || 
                            currentPath.includes('/admin/customers') ||
                            currentPath.includes('/admin/inventory') ||
                            currentPath.includes('/admin/analytics')) {
                            if (button.textContent.includes('E-commerce')) {
                                button.classList.remove('text-white/70');
                                button.classList.add('bg-white/20', 'backdrop-blur-sm', 'text-white');
                                Alpine.evaluate(parentDiv, 'open = true');
                            }
                        }
                        
                        // Check Jobs routes
                        if (currentPath.includes('/admin/jobs/')) {
                            if (button.textContent.includes('Job Portal')) {
                                button.classList.remove('text-white/70');
                                button.classList.add('bg-white/20', 'backdrop-blur-sm', 'text-white');
                                Alpine.evaluate(parentDiv, 'open = true');
                            }
                        }
                        
                        // Check Users routes
                        if (currentPath.includes('/admin/users/')) {
                            if (button.textContent.includes('Users')) {
                                button.classList.remove('text-white/70');
                                button.classList.add('bg-white/20', 'backdrop-blur-sm', 'text-white');
                                Alpine.evaluate(parentDiv, 'open = true');
                            }
                        }
                    });
                }
            }
        }
        
        // Add active class on page load and navigation
        document.addEventListener('DOMContentLoaded', function() {
            // Highlight active submenu items
            const currentPath = window.location.pathname;
            const submenuLinks = document.querySelectorAll('nav .ml-8 a');
            
            submenuLinks.forEach(link => {
                const linkPath = new URL(link.href).pathname;
                if (currentPath === linkPath) {
                    link.classList.remove('text-white/60');
                    link.classList.add('text-white', 'font-semibold');
                }
            });
        });
    </script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>
