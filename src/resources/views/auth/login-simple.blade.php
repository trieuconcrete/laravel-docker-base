<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50">
    
    <!-- Brand Header Bar -->
    <div class="fixed top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 via-cyan-500 to-blue-600 z-50"></div>
    
    <div x-data="{ showPassword: false }" class="min-h-screen flex items-center justify-center p-6">
        
        <div class="w-full max-w-md">
            
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-lg bg-blue-600 mb-4 shadow-sm">
                    <i class="fas fa-layer-group text-white text-xl"></i>
                </div>
                <h1 class="text-2xl font-semibold text-slate-900">{{ config('app.name', 'AdminPro') }}</h1>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
                
                <!-- Accent Bar -->
                <div class="h-1 bg-blue-600"></div>
                
                <div class="p-8">
                    
                    <!-- Welcome Message -->
                    <div class="mb-6 text-center">
                        <h2 class="text-xl font-semibold text-slate-900 mb-1">Welcome Back</h2>
                        <p class="text-sm text-slate-600">Sign in to continue to your dashboard</p>
                    </div>

                    <!-- Login Form -->
                    <form action="{{ route('login') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                   class="w-full px-3 py-2 bg-white border border-slate-300 rounded text-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition-all @error('email') border-red-500 @enderror"
                                   placeholder="name@company.com">
                            @error('email')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" name="password" required
                                       class="w-full px-3 py-2 bg-white border border-slate-300 rounded text-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition-all pr-10 @error('password') border-red-500 @enderror"
                                       placeholder="••••••••">
                                <button type="button" @click="showPassword = !showPassword"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                    <i :class="showPassword ? 'fa-eye-slash' : 'fa-eye'" class="fas text-sm"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-600">
                                <span class="ml-2 text-sm text-slate-600">Remember me</span>
                            </label>
                            <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700">Forgot password?</a>
                        </div>

                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded text-sm transition-colors">
                            <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                        </button>
                    </form>

                </div>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <p class="text-sm text-slate-600">
                    © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </p>
            </div>

        </div>
    </div>

</body>
</html>
