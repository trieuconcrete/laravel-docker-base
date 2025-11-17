<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng nhập / Đăng ký - {{ config('app.name', 'AdminPro') }}</title>
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
        .gradient-bg {
            background: 
                linear-gradient(135deg, rgba(30, 58, 138, 0.95) 0%, rgba(59, 130, 246, 0.95) 100%),
                url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=2000') center/cover no-repeat fixed;
            position: relative;
            overflow: hidden;
        }
        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(30, 58, 138, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(96, 165, 250, 0.2) 0%, transparent 40%);
            z-index: 0;
        }
        .gradient-bg::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.4;
            z-index: 0;
        }
        .geometric-shape {
            position: absolute;
            border-radius: 8px;
            opacity: 0.1;
            transform: rotate(45deg);
            z-index: 0;
        }
        .shape-1 {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.1);
            top: 15%;
            left: 10%;
            animation: float 6s ease-in-out infinite;
        }
        .shape-2 {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.08);
            top: 60%;
            right: 15%;
            animation: float 8s ease-in-out infinite reverse;
        }
        .shape-3 {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.06);
            bottom: 20%;
            left: 20%;
            animation: float 7s ease-in-out infinite;
        }
        .shape-4 {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.09);
            top: 40%;
            right: 25%;
            animation: float 5s ease-in-out infinite;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        .dark .glass-effect {
            background: rgba(31, 41, 55, 0.98);
            backdrop-filter: blur(20px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        @keyframes float {
            0%, 100% { transform: rotate(45deg) translateY(0px); }
            50% { transform: rotate(45deg) translateY(-30px); }
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
    
    <div x-data="authData()" class="min-h-screen flex items-center justify-center p-8 gradient-bg relative overflow-hidden">
        
        <!-- Geometric Shapes -->
        <div class="geometric-shape shape-1"></div>
        <div class="geometric-shape shape-2"></div>
        <div class="geometric-shape shape-3"></div>
        <div class="geometric-shape shape-4"></div>
        
        <div class="absolute top-10 left-1/4 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
        <div class="absolute bottom-20 right-1/3 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 right-10 w-24 h-24 bg-white/5 rounded-full blur-xl"></div>

        <!-- Form Container -->
        <div class="w-full max-w-md relative z-10">
            
            <!-- Dark Mode Toggle -->
            <button @click="toggleDarkMode()" 
                    class="absolute -top-12 right-0 p-3 text-white/80 hover:text-white rounded-lg hover:bg-white/10 transition-colors">
                <i :class="darkMode ? 'fa-sun' : 'fa-moon'" class="fas text-xl"></i>
            </button>

            <!-- Logo -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center space-x-3 mb-6">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <i class="fas fa-cube text-white text-xl"></i>
                    </div>
                    <span class="text-3xl font-bold text-white">{{ config('app.name', 'AdminPro') }}</span>
                </div>
            </div>

            <!-- Card -->
            <div class="glass-effect rounded-2xl shadow-2xl p-8">
                
                <!-- Welcome Text -->
                <div class="mb-6 text-center">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
                        <span x-show="activeTab === 'login'" x-cloak>Chào mừng trở lại!</span>
                        <span x-show="activeTab === 'register'" x-cloak>Tạo tài khoản mới</span>
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        <span x-show="activeTab === 'login'" x-cloak>Đăng nhập để tiếp tục sử dụng hệ thống</span>
                        <span x-show="activeTab === 'register'" x-cloak>Điền thông tin để bắt đầu</span>
                    </p>
                </div>

                <!-- Tabs -->
                <div class="flex space-x-2 mb-6 bg-gray-100 dark:bg-gray-800 p-1 rounded-lg">
                    <button @click="activeTab = 'login'" 
                            :class="activeTab === 'login' ? 'bg-white dark:bg-gray-700 text-primary-600 dark:text-primary-400 shadow-sm' : 'text-gray-600 dark:text-gray-400'"
                            class="flex-1 py-2.5 rounded-lg font-medium transition-all">
                        Đăng nhập
                    </button>
                    <button @click="activeTab = 'register'" 
                            :class="activeTab === 'register' ? 'bg-white dark:bg-gray-700 text-primary-600 dark:text-primary-400 shadow-sm' : 'text-gray-600 dark:text-gray-400'"
                            class="flex-1 py-2.5 rounded-lg font-medium transition-all">
                        Đăng ký
                    </button>
                </div>

                <!-- Login Form -->
                <form x-show="activeTab === 'login'" x-cloak action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   placeholder="admin@example.com"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-all @error('email') border-red-500 @enderror">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mật khẩu
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input :type="showPassword ? 'text' : 'password'" name="password" required
                                   placeholder="••••••••"
                                   class="w-full pl-10 pr-12 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-all @error('password') border-red-500 @enderror">
                            <button type="button" @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <i :class="showPassword ? 'fa-eye-slash' : 'fa-eye'" class="fas"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" 
                                   class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Ghi nhớ đăng nhập</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400 font-medium">
                            Quên mật khẩu?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full py-3 px-4 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-medium rounded-lg transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-lg">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Đăng nhập
                    </button>

                    <!-- Social Login -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">Hoặc đăng nhập với</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('social.login', 'google') }}" class="flex items-center justify-center px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fab fa-google text-red-500 mr-2"></i>
                            <span class="text-gray-700 dark:text-gray-300 font-medium text-sm">Google</span>
                        </a>
                        <a href="{{ route('social.login', 'facebook') }}" class="flex items-center justify-center px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fab fa-facebook text-blue-600 mr-2"></i>
                            <span class="text-gray-700 dark:text-gray-300 font-medium text-sm">Facebook</span>
                        </a>
                    </div>
                </form>

                <!-- Register Form -->
                <form x-show="activeTab === 'register'" x-cloak action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <!-- Full Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Họ và tên
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   placeholder="Nguyễn Văn A"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-all">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   placeholder="email@example.com"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-all">
                        </div>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Số điện thoại
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-phone text-gray-400"></i>
                            </div>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required
                                   placeholder="0123456789"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-all">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mật khẩu
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input :type="showPassword ? 'text' : 'password'" name="password" required
                                   placeholder="••••••••"
                                   class="w-full pl-10 pr-12 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-all">
                            <button type="button" @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <i :class="showPassword ? 'fa-eye-slash' : 'fa-eye'" class="fas"></i>
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tối thiểu 8 ký tự, bao gồm chữ và số</p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Xác nhận mật khẩu
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" required
                                   placeholder="••••••••"
                                   class="w-full pl-10 pr-12 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-all">
                            <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <i :class="showConfirmPassword ? 'fa-eye-slash' : 'fa-eye'" class="fas"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Terms -->
                    <div>
                        <label class="flex items-start">
                            <input type="checkbox" name="terms" required
                                   class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500 mt-1">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                Tôi đồng ý với 
                                <a href="#" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 font-medium">Điều khoản dịch vụ</a> 
                                và 
                                <a href="#" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 font-medium">Chính sách bảo mật</a>
                            </span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full py-3 px-4 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-medium rounded-lg transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-lg">
                        <i class="fas fa-user-plus mr-2"></i>
                        Tạo tài khoản
                    </button>
                </form>

            </div>
        </div>

    </div>

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2"
         class="fixed top-6 right-6 z-50">
        <div class="flex items-center space-x-3 bg-green-500 text-white px-6 py-4 rounded-lg shadow-xl">
            <i class="fas fa-check-circle text-xl"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2"
         class="fixed top-6 right-6 z-50">
        <div class="flex items-center space-x-3 bg-red-500 text-white px-6 py-4 rounded-lg shadow-xl">
            <i class="fas fa-exclamation-circle text-xl"></i>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        function authData() {
            return {
                activeTab: 'login',
                darkMode: localStorage.getItem('darkMode') === 'true',
                showPassword: false,
                showConfirmPassword: false,
                
                init() {
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                    }
                },
                
                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('darkMode', this.darkMode);
                    document.documentElement.classList.toggle('dark');
                }
            }
        }
    </script>
</body>
</html>
