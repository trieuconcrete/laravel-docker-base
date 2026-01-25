<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng nhập - Xế Hộ 24/7 Đà Nẵng</title>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #000000;
            --bg-dark-secondary: #0D0D0D;
            --bg-card: #1A1A1A;
            --gold: #C9A227;
            --gold-light: #D4A84B;
            --gold-hover: #E5B82A;
            --red: #E63946;
            --white: #FFFFFF;
            --white-80: rgba(255, 255, 255, 0.8);
            --white-60: rgba(255, 255, 255, 0.6);
            --white-40: rgba(255, 255, 255, 0.4);
            --white-20: rgba(255, 255, 255, 0.2);
            --gray-dark: #2A2A2A;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            background: var(--bg-dark);
            color: var(--white);
            overflow-x: hidden;
            line-height: 1.6;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: 
                linear-gradient(135deg, rgba(0, 0, 0, 0.95) 0%, rgba(13, 13, 13, 0.95) 100%),
                url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23C9A227" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
            position: relative;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(201, 162, 39, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(201, 162, 39, 0.1) 0%, transparent 50%);
            z-index: 0;
        }

        .login-card {
            background: var(--bg-card);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            padding: 40px;
            width: 100%;
            max-width: 480px;
            position: relative;
            z-index: 1;
            border: 1px solid var(--white-20);
        }

        .login-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
            margin-bottom: 32px;
        }

        .login-logo img {
            height: 80px;
            width: auto;
            border-radius: 12px;
        }

        .login-logo-text {
            text-align: center;
        }

        .login-logo-text h1 {
            font-size: 24px;
            font-weight: 800;
            color: var(--gold);
            margin-bottom: 4px;
        }

        .login-logo-text p {
            font-size: 13px;
            color: var(--white-60);
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-header h2 {
            font-size: 22px;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 8px;
        }

        .login-header p {
            font-size: 14px;
            color: var(--white-60);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--white-80);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper svg {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            fill: var(--white-40);
        }

        .form-input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            background: var(--bg-dark-secondary);
            border: 1px solid var(--white-20);
            border-radius: 12px;
            color: var(--white);
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201, 162, 39, 0.1);
        }

        .form-input::placeholder {
            color: var(--white-40);
        }

        .form-input.error {
            border-color: var(--red);
        }

        .error-message {
            color: var(--red);
            font-size: 13px;
            margin-top: 6px;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .checkbox-wrapper label {
            font-size: 14px;
            color: var(--white-60);
            cursor: pointer;
            margin: 0;
        }

        .forgot-link {
            font-size: 14px;
            color: var(--gold);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: var(--gold-hover);
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--bg-dark);
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(201, 162, 39, 0.4);
        }

        .btn-submit svg {
            width: 20px;
            height: 20px;
            fill: var(--bg-dark);
        }

        .success-message {
            position: fixed;
            top: 24px;
            right: 24px;
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 1000;
            animation: slideIn 0.3s ease;
        }

        .error-alert {
            position: fixed;
            top: 24px;
            right: 24px;
            background: linear-gradient(135deg, var(--red) 0%, #C62828 100%);
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(230, 57, 70, 0.3);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 1000;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @media (max-width: 500px) {
            .login-card {
                padding: 28px;
            }
            
            .login-logo img {
                height: 60px;
            }
            
            .login-logo-text h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Logo -->
            <div class="login-logo">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Xế Hộ 24/7 - Đà Nẵng">
                <div class="login-logo-text">
                    <h1>XẾ HỘ 24/7</h1>
                    <p>Đà Nẵng - An toàn - Uy tín</p>
                </div>
            </div>

            <!-- Header -->
            <div class="login-header">
                <h2>Đăng nhập hệ thống</h2>
                <p>Nhập thông tin để truy cập tài khoản</p>
            </div>

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST">
            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST">
                @csrf
                    
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-wrapper">
                            <svg viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            <input 
                                type="email" 
                                id="email"
                                name="email" 
                                value="{{ old('email') }}" 
                                required
                                placeholder="admin@xeho247.com"
                                class="form-input @error('email') error @enderror">
                        </div>
                        @error('email')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <div class="input-wrapper">
                            <svg viewBox="0 0 24 24">
                                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                            </svg>
                            <input 
                                type="password" 
                                id="password"
                                name="password" 
                                required
                                placeholder="••••••••"
                                class="form-input @error('password') error @enderror">
                        </div>
                        @error('password')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="form-options">
                        <div class="checkbox-wrapper">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Ghi nhớ đăng nhập</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="forgot-link">Quên mật khẩu?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        <svg viewBox="0 0 24 24">
                            <path d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-8v2h8v14z"/>
                        </svg>
                        Đăng nhập
                    </button>
                </form>

        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="success-message" id="successMessage">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    <script>
        setTimeout(() => {
            document.getElementById('successMessage').style.display = 'none';
        }, 3000);
    </script>
    @endif

    <!-- Error Message -->
    @if(session('error'))
    <div class="error-alert" id="errorMessage">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
        </svg>
        <span>{{ session('error') }}</span>
    </div>
    <script>
        setTimeout(() => {
            document.getElementById('errorMessage').style.display = 'none';
        }, 3000);
    </script>
    @endif
</body>
</html>
