<!DOCTYPE html>
<html lang="vi">
<head>
    <!-- Basic Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <title>Thuê Tài Xế Lái Xe Hộ Đà Nẵng 24/7 | Xế Hộ 247 - An Toàn, Uy Tín</title>
    <meta name="description" content="Dịch vụ thuê tài xế lái xe hộ uy tín tại Đà Nẵng ⭐ Chuyên nghiệp 24/7 ⭐ Phục vụ trong 10 phút ⭐ Giá từ 150k ⭐ Hotline: 0559 304 993">
    <meta name="keywords" content="thuê tài xế, lái xe hộ, tài xế hộ đà nẵng, thuê tài xế đà nẵng, dịch vụ lái xe hộ, xe hộ 24/7, tài xế an toàn">
    <meta name="author" content="Xế Hộ 24/7 - Đà Nẵng">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <link rel="canonical" href="https://xeho247.vn">
    
    <!-- Geo Tags -->
    <meta name="geo.region" content="VN-DN">
    <meta name="geo.placename" content="Đà Nẵng">
    <meta name="geo.position" content="16.0544;108.2022">
    <meta name="ICBM" content="16.0544, 108.2022">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://xeho247.vn">
    <meta property="og:title" content="Thuê Tài Xế Lái Xe Hộ Đà Nẵng 24/7 - An Toàn, Uy Tín">
    <meta property="og:description" content="Dịch vụ thuê tài xế lái xe hộ chuyên nghiệp tại Đà Nẵng. Phục vụ 24/7, tài xế đến trong 10 phút. Giá từ 150k. Hotline: 0559 304 993">
    <meta property="og:image" content="{{ asset('images/logo.jpeg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="Xế Hộ 24/7 - Đà Nẵng">
    <meta property="og:locale" content="vi_VN">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Thuê Tài Xế Lái Xe Hộ Đà Nẵng 24/7 - An Toàn, Uy Tín">
    <meta name="twitter:description" content="Dịch vụ thuê tài xế lái xe hộ chuyên nghiệp tại Đà Nẵng. Phục vụ 24/7, tài xế đến trong 10 phút. Giá từ 150k">
    <meta name="twitter:image" content="{{ asset('images/logo.jpeg') }}">
    
    <!-- Mobile & PWA -->
    <meta name="theme-color" content="#C9A227">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Xế Hộ 24/7">
    
    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon/favicon.ico') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon/favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/favicon/favicon-96x96.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('images/favicon/site.webmanifest') }}">
    <meta name="msapplication-TileColor" content="#C9A227">
    <meta name="theme-color" content="#C9A227">
    
    <!-- DNS Prefetch & Preconnect -->
    <link rel="dns-prefetch" href="//maps.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">
    <link rel="preconnect" href="https://maps.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Google Maps API with Places Library -->
    <script>
        // Define callback function before loading Google Maps
        function initMap() {
            console.log('✅ Google Maps API loaded successfully');
            console.log('API Key used:', '{{ config('services.map.google.api_key') }}');
        }
        
        // Log any Google Maps errors
        window.gm_authFailure = function() {
            console.error('❌ Google Maps Authentication Failed!');
            console.error('API Key:', '{{ config('services.map.google.api_key') }}');
            console.error('Check: 1) API key is correct, 2) APIs are enabled, 3) Billing is active');
        };
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.map.google.api_key') }}&libraries=places&language=vi&region=VN&callback=initMap" async defer></script>
    <style>
        :root {
            --bg-dark: #000000;
            --bg-dark-secondary: #0D0D0D;
            --bg-card: #1A1A1A;
            --gold: #C9A227;
            --gold-light: #D4A84B;
            --gold-hover: #E5B82A;
            --red: #E63946;
            --red-light: #FF4D5A;
            --white: #FFFFFF;
            --white-80: rgba(255, 255, 255, 0.8);
            --white-60: rgba(255, 255, 255, 0.6);
            --white-40: rgba(255, 255, 255, 0.4);
            --white-20: rgba(255, 255, 255, 0.2);
            --gray-dark: #2A2A2A;
            --tan: #D4C5A9;
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

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-dark);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--gold);
            border-radius: 4px;
        }

        /* Utility classes */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .text-gold {
            color: var(--gold);
        }

        .text-red {
            color: var(--red);
        }

        .text-tan {
            color: var(--tan);
        }

        .gradient-gold {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Gold decorative corners */
        .gold-corner {
            position: relative;
        }
        .gold-corner::before,
        .gold-corner::after {
            content: '';
            position: absolute;
            width: 60px;
            height: 60px;
            border: 3px solid var(--gold);
        }
        .gold-corner::before {
            top: -10px;
            left: -10px;
            border-right: none;
            border-bottom: none;
        }
        .gold-corner::after {
            bottom: -10px;
            right: -10px;
            border-left: none;
            border-top: none;
        }

        /* Button styles */
        .btn-gold {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--bg-dark);
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(201, 162, 39, 0.4);
        }

        .btn-outline-gold {
            background: transparent;
            color: var(--gold);
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: 2px solid var(--gold);
            cursor: pointer;
        }
        .btn-outline-gold:hover {
            background: var(--gold);
            color: var(--bg-dark);
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--white-20);
            transition: all 0.3s ease;
        }

        .nav-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .nav-logo img {
            height: 50px;
            width: auto;
        }

        .nav-logo-text {
            display: flex;
            flex-direction: column;
        }

        .nav-logo-text span:first-child {
            font-size: 18px;
            font-weight: 800;
            color: var(--gold);
        }

        .nav-logo-text span:last-child {
            font-size: 11px;
            color: var(--white-60);
        }

        .nav-social {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-left: 30px;
            padding-left: 30px;
            border-left: 1px solid var(--white-20);
        }

        .social-icon {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(201, 162, 39, 0.1);
            border-radius: 50%;
            color: var(--gold);
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .social-icon:hover {
            background: var(--gold);
            color: var(--bg-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(201, 162, 39, 0.3);
        }

        .social-icon svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-links a {
            color: var(--white-80);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            font-size: 14px;
        }

        .nav-links a:hover {
            color: var(--gold);
        }

        .nav-phone {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--red);
            font-weight: 700;
            font-size: 18px;
            text-decoration: none;
        }

        .nav-phone:hover {
            color: var(--red-light);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            padding-top: 80px;
            overflow: hidden;
        }

        .hero-background {
            position: absolute;
            inset: 0;
            z-index: -1;
        }

        .hero-background img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.3;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.6) 50%, rgba(0,0,0,0.9) 100%);
        }

        .hero-content {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 60px 20px;
            width: 100%;
        }

        .hero-logo {
            margin-bottom: 30px;
        }

        .hero-logo img {
            height: 120px;
            width: auto;
            margin: 0 auto;
            display: block;
        }

        .hero-title {
            font-size: clamp(28px, 5vw, 48px);
            font-weight: 800;
            color: var(--gold);
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .hero-phone {
            font-size: clamp(48px, 10vw, 80px);
            font-weight: 800;
            color: var(--red);
            margin-bottom: 20px;
            letter-spacing: 4px;
            text-shadow: 0 0 40px rgba(230, 57, 70, 0.5);
        }

        .hero-phone a {
            color: inherit;
            text-decoration: none;
        }

        .hero-price {
            font-size: clamp(24px, 4vw, 36px);
            font-weight: 700;
            color: var(--gold);
            margin-bottom: 40px;
        }

        .hero-services {
            background: var(--gray-dark);
            border-radius: 20px;
            padding: 30px 40px;
            max-width: 600px;
            margin: 0 auto 40px;
            border: 1px solid var(--white-20);
        }

        .hero-services ul {
            list-style: none;
            text-align: left;
        }

        .hero-services li {
            padding: 12px 0;
            font-size: 18px;
            font-weight: 500;
            color: var(--white);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .hero-services li::before {
            content: '•';
            color: var(--gold);
            font-size: 24px;
        }

        .hero-cta {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        /* Services Section */
        .services {
            padding: 100px 0;
            background: var(--bg-dark-secondary);
            position: relative;
        }

        .services::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-badge {
            display: inline-block;
            background: rgba(201, 162, 39, 0.15);
            border: 1px solid var(--gold);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            color: var(--gold);
            margin-bottom: 20px;
        }

        .section-title {
            font-size: clamp(28px, 4vw, 42px);
            font-weight: 800;
            margin-bottom: 15px;
        }

        .section-subtitle {
            font-size: 18px;
            color: var(--white-60);
            max-width: 600px;
            margin: 0 auto;
        }

        .services-image {
            margin-bottom: 60px;
            text-align: center;
        }

        .services-image img {
            max-width: 100%;
            height: auto;
            border-radius: 20px;
            border: 2px solid var(--gold);
            box-shadow: 0 20px 60px rgba(201, 162, 39, 0.2);
        }

        .services-video {
            margin-bottom: 60px;
            text-align: center;
        }

        .services-video h3 {
            color: var(--gold);
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .video-container {
            position: relative;
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
            height: 0;
            overflow: hidden;
            border-radius: 20px;
            border: 2px solid var(--gold);
            box-shadow: 0 20px 60px rgba(201, 162, 39, 0.3);
            background: var(--bg-card);
        }

        .video-container iframe,
        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .service-card {
            background: var(--bg-card);
            border: 1px solid var(--white-20);
            border-radius: 20px;
            padding: 35px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .service-card:hover {
            border-color: var(--gold);
            transform: translateY(-5px);
        }

        .service-card:hover::before {
            transform: scaleX(1);
        }

        .service-icon {
            width: 60px;
            height: 60px;
            background: rgba(201, 162, 39, 0.15);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .service-card h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--white);
        }

        .service-card p {
            color: var(--white-60);
            font-size: 15px;
        }

        /* Pricing Section */
        .pricing {
            padding: 100px 0;
            background: var(--bg-dark);
        }

        .pricing-image {
            margin-bottom: 60px;
            text-align: center;
        }

        .pricing-image img {
            max-width: 100%;
            height: auto;
            border-radius: 20px;
            border: 2px solid var(--gold);
            box-shadow: 0 20px 60px rgba(201, 162, 39, 0.2);
        }

        .price-table {
            background: var(--bg-card);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--white-20);
            max-width: 900px;
            margin: 0 auto;
        }

        .price-table-header {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            padding: 20px;
            text-align: center;
        }

        .price-table-header h3 {
            color: var(--bg-dark);
            font-size: 24px;
            font-weight: 800;
        }

        .price-row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            border-bottom: 1px solid var(--white-20);
        }

        .price-row:last-child {
            border-bottom: none;
        }

        .price-cell {
            padding: 20px;
            text-align: center;
            border-right: 1px solid var(--white-20);
        }

        .price-cell:last-child {
            border-right: none;
        }

        .price-cell.header {
            background: rgba(201, 162, 39, 0.1);
            font-weight: 700;
            color: var(--gold);
        }

        .price-cell .price {
            font-size: 20px;
            font-weight: 700;
            color: var(--gold);
        }

        .price-cell .unit {
            font-size: 14px;
            color: var(--white-60);
        }

        /* Distance and Price Info */
        .distance-price-info {
            margin-top: 15px;
            padding: 20px;
            background: linear-gradient(135deg, rgba(201, 162, 39, 0.1) 0%, rgba(212, 168, 75, 0.1) 100%);
            border-radius: 12px;
            border: 1px solid var(--gold);
            display: none;
        }

        .distance-price-info.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .distance-price-info .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid var(--white-20);
        }

        .distance-price-info .info-row:last-child {
            border-bottom: none;
        }

        .distance-price-info .info-label {
            color: var(--white-80);
            font-size: 14px;
            font-weight: 500;
        }

        .distance-price-info .info-value {
            color: var(--gold);
            font-size: 18px;
            font-weight: 700;
        }

        .distance-price-info .info-note {
            margin-top: 10px;
            padding: 10px;
            background: var(--bg-card);
            border-radius: 8px;
            color: var(--white-60);
            font-size: 13px;
            text-align: center;
        }

        .distance-price-info .loading {
            text-align: center;
            color: var(--white-60);
            padding: 20px;
        }

        .distance-price-info .error {
            color: var(--red-light);
            text-align: center;
            padding: 10px;
        }

        /* Features Section */
        .features {
            padding: 100px 0;
            background: var(--bg-dark-secondary);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .feature-card {
            text-align: center;
            padding: 40px 30px;
            background: var(--bg-card);
            border: 1px solid var(--white-20);
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            border-color: var(--gold);
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: rgba(201, 162, 39, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            margin: 0 auto 25px;
            border: 2px solid var(--gold);
        }

        .feature-card h3 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--gold);
        }

        .feature-card p {
            color: var(--white-60);
            font-size: 14px;
        }

        /* Booking Section */
        .booking {
            padding: 100px 0;
            background: var(--bg-dark);
        }

        .booking-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: start;
        }

        @media (max-width: 968px) {
            .booking-grid {
                grid-template-columns: 1fr;
            }
            
            .nav-social {
                display: none;
            }
            
            .nav-links {
                display: none;
            }
            
            nav .nav-container {
                justify-content: space-between;
            }
        }

        .booking-form-container {
            background: var(--bg-card);
            border: 1px solid var(--white-20);
            border-radius: 25px;
            padding: 40px;
        }

        .booking-form-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .booking-form-header span {
            font-size: 40px;
        }

        .booking-form-header h3 {
            font-size: 24px;
            font-weight: 700;
            color: var(--gold);
        }

        .booking-form-header p {
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

        .form-input {
            width: 100%;
            background: var(--bg-dark);
            border: 1px solid var(--white-20);
            border-radius: 12px;
            padding: 15px 20px;
            padding-left: 45px;
            color: var(--white);
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 20px rgba(201, 162, 39, 0.2);
        }

        .form-input::placeholder {
            color: var(--white-40);
        }

        .form-input.error {
            border-color: var(--red);
        }

        .error-message {
            color: var(--red);
            font-size: 12px;
            margin-top: 5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        @media (max-width: 500px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .form-textarea {
            width: 100%;
            background: var(--bg-dark);
            border: 1px solid var(--white-20);
            border-radius: 12px;
            padding: 15px 20px;
            color: var(--white);
            font-size: 16px;
            min-height: 80px;
            resize: vertical;
            font-family: inherit;
        }

        .form-textarea:focus {
            outline: none;
            border-color: var(--gold);
        }

        .booking-info {
            padding-left: 20px;
        }

        .booking-info h2 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .booking-info p {
            color: var(--white-60);
            font-size: 18px;
            margin-bottom: 30px;
        }

        .info-list {
            list-style: none;
            margin-bottom: 40px;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 20px;
            background: var(--bg-card);
            border: 1px solid var(--white-20);
            border-radius: 15px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .info-item:hover {
            border-color: var(--gold);
        }

        .info-icon {
            width: 50px;
            height: 50px;
            background: rgba(201, 162, 39, 0.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .info-item h4 {
            font-size: 16px;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 5px;
        }

        .info-item p {
            font-size: 14px;
            color: var(--white-60);
            margin: 0;
        }

        .hotline-box {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
        }

        .hotline-box p {
            color: var(--bg-dark);
            font-size: 14px;
            margin-bottom: 10px;
        }

        .hotline-box a {
            font-size: 36px;
            font-weight: 800;
            color: var(--bg-dark);
            text-decoration: none;
        }

        .hotline-box span {
            display: block;
            font-size: 12px;
            color: rgba(0,0,0,0.6);
            margin-top: 5px;
        }

        /* Contact Section */
        .contact {
            padding: 100px 0;
            background: var(--bg-dark-secondary);
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
        }

        @media (max-width: 768px) {
            .contact-grid {
                grid-template-columns: 1fr;
            }
        }

        .contact-info h2 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .contact-info > p {
            color: var(--white-60);
            margin-bottom: 30px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .contact-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .contact-item span {
            font-size: 12px;
            color: var(--white-60);
        }

        .contact-item a, .contact-item p {
            font-size: 20px;
            font-weight: 700;
            color: var(--white);
            text-decoration: none;
            margin: 0;
        }

        .contact-item a:hover {
            color: var(--gold);
        }

        .contact-form-box {
            background: var(--bg-card);
            border: 1px solid var(--white-20);
            border-radius: 25px;
            padding: 40px;
        }

        .contact-form-box h3 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 25px;
            color: var(--gold);
        }

        /* Footer */
        footer {
            padding: 60px 0 30px;
            background: var(--bg-dark);
            border-top: 1px solid var(--white-20);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        @media (max-width: 768px) {
            .footer-grid {
                grid-template-columns: 1fr;
            }
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            text-decoration: none;
        }

        .footer-logo img {
            height: 60px;
            width: auto;
        }

        .footer-logo-text span:first-child {
            font-size: 22px;
            font-weight: 800;
            color: var(--gold);
        }

        .footer-logo-text span:last-child {
            font-size: 12px;
            color: var(--white-60);
            display: block;
        }

        .footer-description {
            color: var(--white-60);
            font-size: 14px;
            margin-bottom: 20px;
            max-width: 400px;
        }

        .social-links {
            display: flex;
            gap: 10px;
        }

        .social-link {
            width: 40px;
            height: 40px;
            background: rgba(201, 162, 39, 0.15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: var(--gold);
            color: var(--bg-dark);
        }

        .footer-column h4 {
            font-size: 16px;
            font-weight: 700;
            color: var(--gold);
            margin-bottom: 20px;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column li {
            margin-bottom: 12px;
        }

        .footer-column a {
            color: var(--white-60);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .footer-column a:hover {
            color: var(--gold);
        }

        .footer-bottom {
            padding-top: 30px;
            border-top: 1px solid var(--white-20);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-bottom p {
            font-size: 13px;
            color: var(--white-60);
        }

        .footer-links {
            display: flex;
            gap: 20px;
        }

        .footer-links a {
            font-size: 13px;
            color: var(--white-60);
            text-decoration: none;
        }

        .footer-links a:hover {
            color: var(--gold);
        }

        /* Floating buttons */
        .floating-btns {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 99;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .float-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }

        .float-btn:hover {
            transform: scale(1.1);
        }

        .float-btn-phone {
            background: var(--red);
            color: white;
        }

        .float-btn-zalo {
            background: var(--gold);
            color: var(--bg-dark);
        }

        .float-btn svg {
            width: 28px;
            height: 28px;
        }

        /* Animation */
        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(230, 57, 70, 0.5); }
            50% { box-shadow: 0 0 0 15px rgba(230, 57, 70, 0); }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .hero-services {
                padding: 20px;
            }

            .hero-services li {
                font-size: 15px;
            }

            .price-row {
                grid-template-columns: 1fr;
            }

            .price-cell {
                border-right: none;
                border-bottom: 1px solid var(--white-20);
            }

            .price-cell:last-child {
                border-bottom: none;
            }

            .booking-form-container {
                padding: 25px;
            }

            .booking-info {
                padding-left: 0;
            }
        }

        /* Testimonials */
        .testimonials {
            padding: 100px 0;
            background: var(--bg-dark);
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .testimonial-card {
            background: var(--bg-card);
            border: 1px solid var(--white-20);
            border-radius: 20px;
            padding: 30px;
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            border-color: var(--gold);
        }

        .testimonial-stars {
            color: var(--gold);
            font-size: 18px;
            margin-bottom: 15px;
        }

        .testimonial-text {
            color: var(--white-80);
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 20px;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .testimonial-avatar {
            width: 50px;
            height: 50px;
            background: rgba(201, 162, 39, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .testimonial-author h4 {
            font-size: 16px;
            font-weight: 600;
            color: var(--white);
        }

        .testimonial-author p {
            font-size: 13px;
            color: var(--white-60);
        }

        .success-message {
            background: rgba(76, 175, 80, 0.2);
            border: 1px solid #4caf50;
            color: #4caf50;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Autocomplete Dropdown */
        .autocomplete-wrapper {
            position: relative;
        }

        .autocomplete-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--bg-card);
            border: 1px solid var(--gold);
            border-top: none;
            border-radius: 0 0 8px 8px;
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .autocomplete-dropdown.show {
            display: block;
        }

        .autocomplete-item {
            padding: 12px 15px;
            cursor: pointer;
            transition: background 0.2s ease;
            border-bottom: 1px solid var(--white-20);
            color: var(--white-80);
            font-size: 14px;
        }

        .autocomplete-item:last-child {
            border-bottom: none;
        }

        .autocomplete-item:hover {
            background: rgba(201, 162, 39, 0.2);
        }

        .autocomplete-item.active {
            background: rgba(201, 162, 39, 0.3);
        }

        .autocomplete-item .item-name {
            font-weight: 600;
            color: var(--gold);
            margin-bottom: 4px;
        }

        .autocomplete-item .item-address {
            font-size: 12px;
            color: var(--white-60);
        }

        .autocomplete-loading {
            padding: 15px;
            text-align: center;
            color: var(--white-60);
            font-size: 13px;
        }

        .autocomplete-no-results {
            padding: 15px;
            text-align: center;
            color: var(--white-40);
            font-size: 13px;
        }

        .autocomplete-icon {
            display: inline-block;
            width: 16px;
            height: 16px;
            margin-right: 8px;
            color: var(--gold);
        }

        /* Google Places Autocomplete Styling */
        .pac-container {
            background: var(--bg-card) !important;
            border: 1px solid var(--gold) !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;
            font-family: 'Be Vietnam Pro', sans-serif !important;
            margin-top: 2px !important;
            z-index: 10000 !important;
        }

        .pac-container:after {
            display: none !important;
        }

        .pac-item {
            background: var(--bg-card) !important;
            border-top: 1px solid var(--white-20) !important;
            padding: 12px 15px !important;
            cursor: pointer !important;
            color: var(--white-80) !important;
            font-size: 14px !important;
            line-height: 1.4 !important;
        }

        .pac-item:first-child {
            border-top: none !important;
        }

        .pac-item:hover,
        .pac-item-selected {
            background: rgba(201, 162, 39, 0.2) !important;
        }

        .pac-item-query {
            color: var(--gold) !important;
            font-size: 14px !important;
            font-weight: 600 !important;
        }

        .pac-matched {
            color: var(--gold-light) !important;
            font-weight: 700 !important;
        }

        .pac-icon {
            display: none !important;
        }

        .pac-item-query .pac-matched {
            color: var(--gold-hover) !important;
        }
    </style>
    
    <!-- Structured Data (JSON-LD) -->
    @verbatim
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@graph": [
            {
                "@type": "LocalBusiness",
                "@id": "https://xeho247.vn/#organization",
                "name": "Xế Hộ 24/7 - Đà Nẵng",
                "alternateName": "Xế Hộ 247 Đà Nẵng",
                "url": "https://xeho247.vn",
                "logo": {
                    "@type": "ImageObject",
                    "url": "/images/logo.jpeg",
                    "width": 250,
                    "height": 250
                },
                "image": "/images/logo.jpeg",
                "description": "Dịch vụ thuê tài xế lái xe hộ chuyên nghiệp tại Đà Nẵng. Phục vụ 24/7, tài xế đến trong 10 phút. An toàn, uy tín, giá cả hợp lý.",
                "telephone": "+84559304993",
                "email": "admin@xeho247danang.vn",
                "address": {
                    "@type": "PostalAddress",
                    "addressLocality": "Đà Nẵng",
                    "addressRegion": "Đà Nẵng",
                    "addressCountry": "VN"
                },
                "geo": {
                    "@type": "GeoCoordinates",
                    "latitude": "16.0544",
                    "longitude": "108.2022"
                },
                "areaServed": {
                    "@type": "City",
                    "name": "Đà Nẵng"
                },
                "priceRange": "150000-200000 VND",
                "openingHoursSpecification": {
                    "@type": "OpeningHoursSpecification",
                    "dayOfWeek": [
                        "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"
                    ],
                    "opens": "00:00",
                    "closes": "23:59"
                },
                "sameAs": [
                    "https://www.facebook.com/share/1G45eKqszA/",
                    "https://www.tiktok.com/@laixehodanang0559304993",
                    "https://www.youtube.com/@Xeho247"
                ]
            },
            {
                "@type": "WebSite",
                "@id": "https://xeho247.vn/#website",
                "url": "https://xeho247.vn",
                "name": "Xế Hộ 24/7 - Đà Nẵng",
                "description": "Dịch vụ thuê tài xế lái xe hộ Đà Nẵng",
                "publisher": {
                    "@id": "https://xeho247.vn/#organization"
                },
                "inLanguage": "vi-VN"
            },
            {
                "@type": "Service",
                "serviceType": "Thuê tài xế lái xe hộ",
                "provider": {
                    "@id": "https://xeho247.vn/#organization"
                },
                "areaServed": {
                    "@type": "City",
                    "name": "Đà Nẵng"
                },
                "offers": {
                    "@type": "Offer",
                    "priceSpecification": [
                        {
                            "@type": "PriceSpecification",
                            "price": "150000",
                            "priceCurrency": "VND",
                            "name": "Giá ban ngày (6h-23h59)"
                        },
                        {
                            "@type": "PriceSpecification",
                            "price": "200000",
                            "priceCurrency": "VND",
                            "name": "Giá ban đêm (0h-5h59)"
                        }
                    ]
                }
            }
        ]
    }
    </script>
    @endverbatim
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <a href="{{ url('/') }}" class="nav-logo">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Xế Hộ 24/7 - Đà Nẵng">
                <div class="nav-logo-text">
                    <span>XẾ HỘ 24/7</span>
                    <span>Đà Nẵng - An toàn - Uy tín</span>
                </div>
            </a>
            
            <!-- Social Media Icons -->
            <div class="nav-social">
                <a href="https://www.tiktok.com/@laixehodanang0559304993" target="_blank" rel="noopener" class="social-icon" title="TikTok">
                    <svg viewBox="0 0 24 24">
                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                    </svg>
                </a>
                <a href="https://www.facebook.com/share/1G45eKqszA/" target="_blank" rel="noopener" class="social-icon" title="Facebook">
                    <svg viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                <a href="https://www.youtube.com/@Xeho247" target="_blank" rel="noopener" class="social-icon" title="YouTube">
                    <svg viewBox="0 0 24 24">
                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                </a>
            </div>
            
            <div class="nav-links">
                <a href="#booking">Đặt xe</a>
                <a href="#services">Dịch vụ</a>
                <a href="#pricing">Bảng giá</a>
                <a href="#contact">Liên hệ</a>
            </div>
            <a href="tel:0559304993" class="nav-phone">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                </svg>
                0559 304 993
            </a>
        </div>
    </nav>

    <!-- Booking Section -->
    <section id="booking" class="booking">
        <div class="container">
            <div class="booking-grid">
                <div class="booking-form-container">
                    <div class="booking-form-header">
                        <span>🚗</span>
                        <div>
                            <h3>THUÊ TÀI XẾ</h3>
                            <p>Điền thông tin để đặt xe ngay</p>
                        </div>
                    </div>

                    <form id="bookingForm" action="{{ route('booking.store') }}" method="POST">
                        @csrf
                        
                        <!-- Hidden fields for distance and price -->
                        <input type="hidden" id="distance_hidden" name="distance" value="">
                        <input type="hidden" id="price_hidden" name="price" value="">
                        
                        <div class="form-group">
                            <label>Điểm đón</label>
                            <div class="input-wrapper">
                                <span class="input-icon">📍</span>
                                <input type="text" id="pickup_location" name="pickup_location" class="form-input @error('pickup_location') error @enderror" placeholder="Nhập địa chỉ điểm đón..." value="{{ old('pickup_location') }}" required>
                                @error('pickup_location')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Điểm đến</label>
                            <div class="input-wrapper">
                                <span class="input-icon">🎯</span>
                                <input type="text" id="dropoff_location" name="dropoff_location" class="form-input" placeholder="Nhập địa chỉ điểm đến..." value="{{ old('dropoff_location') }}">
                            </div>
                            
                            <!-- Distance and Price Info Display -->
                            <div id="distancePriceInfo" class="distance-price-info">
                                <div class="loading" id="loadingInfo">
                                    <span>⏳ Đang tính toán khoảng cách và giá...</span>
                                </div>
                                <div id="resultInfo" style="display: none;">
                                    <div class="info-row">
                                        <span class="info-label">📏 Quãng đường:</span>
                                        <span class="info-value" id="distanceValue">-</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">💰 Giá ước tính:</span>
                                        <span class="info-value" id="priceValue">-</span>
                                    </div>
                                    <div class="info-note" id="priceNote" style="display: none;"></div>
                                </div>
                                <div id="errorInfo" class="error" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Thông tin liên hệ</label>
                            <div class="form-row">
                                <div class="input-wrapper">
                                    <span class="input-icon">👤</span>
                                    <input type="text" name="name" class="form-input @error('name') error @enderror" placeholder="Họ và tên" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-wrapper">
                                    <span class="input-icon">📱</span>
                                    <input type="tel" name="phone" class="form-input @error('phone') error @enderror" placeholder="Số điện thoại" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Ghi chú (tùy chọn)</label>
                            <textarea name="notes" class="form-textarea" placeholder="Yêu cầu đặc biệt, loại xe cụ thể...">{{ old('notes') }}</textarea>
                        </div>

                        <button type="submit" class="btn-gold" style="width: 100%; justify-content: center;">
                            🚗 Yêu cầu điều phối tài xế
                        </button>

                        <div style="text-align: center; margin: 20px 0; color: var(--white-40);">hoặc</div>

                        <a href="tel:0559304993" class="btn-outline-gold" style="width: 100%; justify-content: center;">
                            📞 Gọi 0559 304 993
                        </a>
                    </form>
                </div>

                <div class="booking-info">
                    <span class="section-badge">⚡ Đặt xe nhanh</span>
                    <h2>Tài xế đến trong <span class="text-gold">10 phút</span></h2>
                    <p>Chỉ cần điền form, chúng tôi sẽ liên hệ lại ngay để xác nhận và báo giá chính xác.</p>

                    <ul class="info-list">
                        <li class="info-item">
                            <div class="info-icon">✅</div>
                            <div>
                                <h4>Xác nhận nhanh trong 5 phút</h4>
                                <p>Đội ngũ tư vấn sẽ gọi lại ngay sau khi bạn gửi yêu cầu</p>
                            </div>
                        </li>
                        <li class="info-item">
                            <div class="info-icon">💰</div>
                            <div>
                                <h4>Báo giá minh bạch</h4>
                                <p>Biết trước chi phí, không phát sinh phí ẩn</p>
                            </div>
                        </li>
                        <li class="info-item">
                            <div class="info-icon">🕐</div>
                            <div>
                                <h4>Hoạt động 24/7</h4>
                                <p>Phục vụ mọi lúc, kể cả đêm khuya và ngày lễ</p>
                            </div>
                        </li>
                    </ul>

                    <div class="hotline-box">
                        <p>Cần hỗ trợ ngay?</p>
                        <a href="tel:0559304993">0559 304 993</a>
                        <span>Hotline 24/7 - Miễn phí cuộc gọi</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-background">
            <div class="hero-overlay"></div>
        </div>
        <div class="hero-content">
            <div class="hero-logo">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Xế Hộ 24/7 Logo">
            </div>
            <h1 class="hero-title">XẾ HỘ 24/7 - ĐÀ NẴNG</h1>
            <div class="hero-phone">
                <a href="tel:0559304993">0559 304 993</a>
            </div>
            <p class="hero-price">GIÁ CHỈ TỪ 150.000Đ</p>
            
            <div class="hero-services">
                <ul>
                    <li>Lái Hộ Xe Máy, Xe Oto Uy Tín</li>
                    <li>Cho Thuê Tài Xế Theo Giờ, Ngày</li>
                    <li>Lái Hộ Đi Công Tác, Đi Tỉnh Xa</li>
                    <li>Hỗ Trợ Lái Tour Du Lịch Dài Ngày</li>
                </ul>
            </div>
            
            <div class="hero-cta">
                <a href="tel:0559304993" class="btn-gold">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                    </svg>
                    Gọi ngay: 0559 304 993
                </a>
                <a href="#booking" class="btn-outline-gold">
                    Đặt xe online
                </a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">⚡ Dịch vụ đa dạng</span>
                <h2 class="section-title">
                    Dịch vụ <span class="text-gold">Lái Xe Hộ</span> Chuyên Nghiệp
                </h2>
                <p class="section-subtitle">
                    Đáp ứng mọi nhu cầu di chuyển của bạn - An toàn, uy tín, giá cả hợp lý
                </p>
            </div>

            <div class="services-image">
                <img src="{{ asset('images/service.jpeg') }}" alt="Dịch vụ Xế Hộ 24/7 Đà Nẵng">
            </div>

            <!-- Services Video -->
            <div class="services-video">
                <h3>🎬 Xem Video Giới Thiệu Dịch Vụ</h3>
                <div class="video-container">
                    <!-- YouTube Shorts Video - Xế Hộ 24/7 -->
                    <iframe 
                        width="560" 
                        height="315" 
                        src="https://www.youtube.com/embed/LkyGmhzoUIg" 
                        title="Xế Hộ 24/7 - Dịch vụ thuê tài xế Đà Nẵng" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        referrerpolicy="strict-origin-when-cross-origin" 
                        allowfullscreen
                        loading="lazy">
                    </iframe>
                    
                    <!-- Fallback message if video doesn't load -->
                    <noscript>
                        <div style="background: #f8d7da; color: #721c24; padding: 20px; border-radius: 10px; text-align: center;">
                            <p>⚠️ Video không thể hiển thị. Vui lòng bật JavaScript hoặc <a href="https://www.youtube.com/@Xeho247" target="_blank" style="color: #C9A227;">xem trên YouTube</a></p>
                        </div>
                    </noscript>
                    
                    <!-- Option 2: Local Video (uncomment to use local video instead) -->
                    <!--
                    <video controls poster="{{ asset('images/video-thumbnail.jpg') }}">
                        <source src="{{ asset('videos/intro.mp4') }}" type="video/mp4">
                        <source src="{{ asset('videos/intro.webm') }}" type="video/webm">
                        Trình duyệt của bạn không hỗ trợ video.
                    </video>
                    -->
                </div>
            </div>

            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">🍺</div>
                    <h3>Lái Xe Hộ Khi Say</h3>
                    <p>Vui chơi hết mình, an tâm về nhà. Tài xế lái chính chiếc xe của bạn, tránh vi phạm nồng độ cồn</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">⏱️</div>
                    <h3>Thuê Tài Xế Theo Giờ</h3>
                    <p>Đặt trước tài xế để di chuyển nhiều điểm trong ngày - lý tưởng cho công việc, đón khách</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">📆</div>
                    <h3>Tài Xế Riêng Theo Ngày</h3>
                    <p>Phù hợp cho chuyến công tác, du lịch dài ngày với tài xế am hiểu lộ trình</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">🚙</div>
                    <h3>Lái Xe Đi Tỉnh Xa</h3>
                    <p>Hỗ trợ lái xe đi công tác, du lịch đến các tỉnh lân cận một cách an toàn</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">✨ Tại sao chọn chúng tôi?</span>
                <h2 class="section-title">
                    Dịch vụ <span class="text-gold">24/7</span> - Uy Tín - An Toàn
                </h2>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">👨‍✈️</div>
                    <h3>Tài Xế Chuyên Nghiệp</h3>
                    <p>Đội ngũ tài xế được tuyển chọn kỹ lưỡng, có 3+ năm kinh nghiệm lái xe an toàn</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🕐</div>
                    <h3>Phục Vụ 24/7</h3>
                    <p>Sẵn sàng phục vụ bất kể ngày đêm, kể cả lễ Tết - Tài xế đến trong 10 phút</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💰</div>
                    <h3>Giá Minh Bạch</h3>
                    <p>Biết trước giá cước ngay khi đặt xe, không phát sinh chi phí ẩn</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🛡️</div>
                    <h3>An Toàn Tuyệt Đối</h3>
                    <p>Giám sát GPS 24/7, bảo hiểm toàn diện cho mọi chuyến đi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="pricing">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">💰 Bảng giá dịch vụ</span>
                <h2 class="section-title">
                    Giá cước <span class="text-gold">minh bạch & cạnh tranh</span>
                </h2>
                <p class="section-subtitle">
                    Không phát sinh chi phí ẩn - Biết trước giá cước trước khi đặt xe
                </p>
            </div>

            <div class="price-table">
                <div class="price-table-header">
                    <h3>BẢNG GIÁ THUÊ TÀI XẾ LÁI XE HỘ</h3>
                </div>
                
                <!-- Giá ban ngày -->
                <div style="padding: 15px; background: rgba(201, 162, 39, 0.1); text-align: center;">
                    <strong class="text-gold">Bảng Giá Áp Dụng Từ 6h - 23h59</strong>
                </div>
                <div class="price-row">
                    <div class="price-cell header">Giá Mở Cửa<br><small>(từ 0-5km)</small></div>
                    <div class="price-cell header">Từ 5km đến 30km</div>
                    <div class="price-cell header">Từ 30km trở đi</div>
                </div>
                <div class="price-row">
                    <div class="price-cell">
                        <span class="price">150.000Đ</span><br>
                        <span class="unit">/chuyến</span>
                    </div>
                    <div class="price-cell">
                        <span class="price">150.000Đ + 15.000Đ</span><br>
                        <span class="unit">/km</span>
                    </div>
                    <div class="price-cell">
                        <span class="price">Thỏa thuận</span><br>
                        <span class="unit"></span>
                    </div>
                </div>

                <!-- Giá ban đêm -->
                <div style="padding: 15px; background: rgba(201, 162, 39, 0.1); text-align: center; border-top: 1px solid var(--white-20);">
                    <strong class="text-gold">Bảng Giá Áp Dụng Từ 0h - 5h59</strong>
                </div>
                <div class="price-row">
                    <div class="price-cell header">Giá Mở Cửa<br><small>(từ 0-5km)</small></div>
                    <div class="price-cell header">Từ 5km đến 30km</div>
                    <div class="price-cell header">Từ 30km trở đi</div>
                </div>
                <div class="price-row">
                    <div class="price-cell">
                        <span class="price">200.000Đ</span><br>
                        <span class="unit">/chuyến</span>
                    </div>
                    <div class="price-cell">
                        <span class="price">200.000Đ + 15.000Đ</span><br>
                        <span class="unit">/km</span>
                    </div>
                    <div class="price-cell">
                        <span class="price">Thỏa thuận</span><br>
                        <span class="unit"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">💬 Khách hàng nói gì?</span>
                <h2 class="section-title">
                    Được <span class="text-gold">hàng nghìn khách hàng</span> tin tưởng
                </h2>
            </div>

            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-stars">⭐⭐⭐⭐⭐</div>
                    <p class="testimonial-text">
                        "Dịch vụ tuyệt vời! Tài xế rất lịch sự và chuyên nghiệp. Đặc biệt tiện lợi khi đi tiệc về, không còn lo vi phạm nồng độ cồn nữa."
                    </p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">👨</div>
                        <div>
                            <h4>Nguyễn Minh Hoàng</h4>
                            <p>Doanh nhân, Đà Nẵng</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-stars">⭐⭐⭐⭐⭐</div>
                    <p class="testimonial-text">
                        "Gọi điện là có tài xế ngay, giá cả hợp lý và minh bạch. Đã giới thiệu cho nhiều bạn bè sử dụng."
                    </p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">👩</div>
                        <div>
                            <h4>Trần Thị Lan</h4>
                            <p>Nhân viên văn phòng, Đà Nẵng</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-stars">⭐⭐⭐⭐⭐</div>
                    <p class="testimonial-text">
                        "Thuê tài xế theo ngày để đi công tác rất tiện. Tài xế am hiểu đường xá, lịch sự. Sẽ tiếp tục ủng hộ!"
                    </p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">👨‍💼</div>
                        <div>
                            <h4>Lê Văn Đức</h4>
                            <p>Giám đốc kinh doanh, Đà Nẵng</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-info">
                    <span class="section-badge">📞 Liên hệ</span>
                    <h2>Cần hỗ trợ? <span class="text-gold">Chúng tôi luôn sẵn sàng</span></h2>
                    <p>Đội ngũ hỗ trợ khách hàng 24/7 sẵn sàng giải đáp mọi thắc mắc của bạn</p>

                    <div class="contact-item">
                        <div class="contact-icon">📞</div>
                        <div>
                            <span>Hotline 24/7</span>
                            <a href="tel:0559304993">0559 304 993</a>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">📍</div>
                        <div>
                            <span>Khu vực phục vụ</span>
                            <p>Đà Nẵng và các tỉnh lân cận</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">🕐</div>
                        <div>
                            <span>Thời gian hoạt động</span>
                            <p>24/7 - Kể cả ngày lễ</p>
                        </div>
                    </div>
                </div>

                <div class="contact-form-box">
                    <h3>Gửi yêu cầu hỗ trợ</h3>

                    <form action="{{ route('support.store') }}" method="POST" id="supportForm">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="name" class="form-input" placeholder="Họ và tên" value="{{ old('name') }}" required style="padding-left: 20px;">
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" class="form-input" placeholder="Số điện thoại" value="{{ old('phone') }}" required style="padding-left: 20px;">
                        </div>
                        <div class="form-group">
                            <textarea name="message" class="form-textarea" placeholder="Nội dung cần hỗ trợ..." required>{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="btn-gold" style="width: 100%; justify-content: center;">
                            Gửi yêu cầu
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a href="{{ url('/') }}" class="footer-logo">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="Xế Hộ 24/7">
                        <div class="footer-logo-text">
                            <span>XẾ HỘ 24/7</span>
                            <span>Đà Nẵng - An toàn - Uy tín</span>
                        </div>
                    </a>
                    <p class="footer-description">
                        Dịch vụ thuê tài xế và lái xe hộ chuyên nghiệp tại Đà Nẵng. Bạn uống - Chúng tôi lái!
                    </p>
                    <div class="social-links">
                        <a href="https://www.tiktok.com/@laixehodanang0559304993" target="_blank" rel="noopener" class="social-link" title="TikTok">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                            </svg>
                        </a>
                        <a href="https://www.facebook.com/share/1G45eKqszA/" target="_blank" rel="noopener" class="social-link" title="Facebook">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="https://www.youtube.com/@Xeho247" target="_blank" rel="noopener" class="social-link" title="YouTube">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="footer-column">
                    <h4>Dịch vụ</h4>
                    <ul>
                        <li><a href="#">Lái xe hộ</a></li>
                        <li><a href="#">Thuê tài xế theo giờ</a></li>
                        <li><a href="#">Thuê tài xế theo ngày</a></li>
                        <li><a href="#">Bảng giá dịch vụ</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h4>Hỗ trợ</h4>
                    <ul>
                        <li><a href="#">Về chúng tôi</a></li>
                        <li><a href="#">Đăng ký tài xế</a></li>
                        <li><a href="#">Chính sách bảo mật</a></li>
                        <li><a href="#">Điều khoản dịch vụ</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>© 2026 Xế Hộ 24/7 - Đà Nẵng. Hotline: 0559 304 993</p>
                <div class="footer-links">
                    <a href="#">Chính sách bảo mật</a>
                    <a href="#">Điều khoản</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Buttons -->
    <div class="floating-btns">
        <a href="tel:0559304993" class="float-btn float-btn-phone pulse">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
        </a>
        <a href="#" class="float-btn float-btn-zalo">
            <svg fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.562 8.248c0-.417-.097-.793-.266-1.122h-3.023v7.148h1.586v-2.457h1.242v-1.43h-1.242v-1.067c0-.278.22-.488.503-.488h.942v-1.43h-.942c-1.103 0-2.004.878-2.004 1.918v1.067H13.32v1.43h1.038v2.457H8.174c-.87 0-1.586-.697-1.586-1.55V9.798h1.758c.32 0 .585.257.585.567v3.157h1.573V9.365c0-1.066-.882-1.932-1.973-1.932H6.588v6.291c0 1.639 1.362 2.98 3.025 2.98h6.774c1.663 0 3.025-1.341 3.025-2.98v-5.09c0-.128-.01-.256-.028-.386h.178z"/>
            </svg>
        </a>
    </div>

    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.style.background = 'rgba(0, 0, 0, 0.98)';
            } else {
                nav.style.background = 'rgba(0, 0, 0, 0.95)';
            }
        });

        // Google Maps API Integration
        let calculateTimeout = null;
        let pickupAutocomplete = null;
        let dropoffAutocomplete = null;
        let distanceMatrixService = null;
        
        // Initialize Google Places Autocomplete
        function initAutocomplete() {
            // Wait for Google Maps API to load
            if (typeof google === 'undefined' || !google.maps) {
                setTimeout(initAutocomplete, 100);
                return;
            }
            
            const pickupInput = document.getElementById('pickup_location');
            const dropoffInput = document.getElementById('dropoff_location');
            
            if (pickupInput && dropoffInput) {
                // Initialize Distance Matrix Service
                distanceMatrixService = new google.maps.DistanceMatrixService();
                
                // Setup Google Places Autocomplete for both inputs
                // Restrict to Vietnam and Da Nang area
                const options = {
                    componentRestrictions: { country: 'vn' },
                    fields: ['formatted_address', 'geometry', 'name'],
                    types: ['geocode', 'establishment']
                };
                
                pickupAutocomplete = new google.maps.places.Autocomplete(pickupInput, options);
                dropoffAutocomplete = new google.maps.places.Autocomplete(dropoffInput, options);
                
                // Listen for place selection
                pickupAutocomplete.addListener('place_changed', function() {
                    clearTimeout(calculateTimeout);
                    calculateTimeout = setTimeout(calculateDistanceAndPrice, 500);
                });
                
                dropoffAutocomplete.addListener('place_changed', function() {
                    clearTimeout(calculateTimeout);
                    calculateTimeout = setTimeout(calculateDistanceAndPrice, 500);
                });
                
                // Also trigger on manual input (with debounce)
                pickupInput.addEventListener('input', function() {
                    clearTimeout(calculateTimeout);
                    calculateTimeout = setTimeout(calculateDistanceAndPrice, 1500);
                });
                
                dropoffInput.addEventListener('input', function() {
                    clearTimeout(calculateTimeout);
                    calculateTimeout = setTimeout(calculateDistanceAndPrice, 1500);
                });
            }
        }

        
        // Calculate price based on distance
        function calculatePrice(distanceKm) {
            const currentHour = new Date().getHours();
            let price = 0;
            let priceNote = '';
            
            // Determine if it's day (6h-23h59) or night (0h-5h59)
            const isNightTime = currentHour >= 0 && currentHour < 6;
            const basePrice = isNightTime ? 200000 : 150000;
            const perKmPrice = 15000;
            
            if (distanceKm > 30) {
                // Over 30km - need to contact hotline
                return {
                    price: null,
                    message: '📞 Liên hệ hotline 0559 304 993 để thỏa thuận giá cả',
                    note: 'Khoảng cách trên 30km, vui lòng liên hệ để được báo giá chính xác'
                };
            } else if (distanceKm <= 5) {
                // 0-5km: Base price only
                price = basePrice;
                priceNote = `Giá mở cửa (0-5km) ${isNightTime ? 'ban đêm' : 'ban ngày'}`;
            } else {
                // 5-30km: Base price + per km charge
                price = basePrice + (distanceKm - 5) * perKmPrice;
                priceNote = `${basePrice.toLocaleString('vi-VN')}đ (giá mở cửa) + ${((distanceKm - 5) * perKmPrice).toLocaleString('vi-VN')}đ (${(distanceKm - 5).toFixed(1)}km × 15.000đ)`;
            }
            
            return {
                price: price,
                message: price.toLocaleString('vi-VN') + 'đ',
                note: priceNote
            };
        }
        
        // Calculate distance using Google Distance Matrix API
        async function calculateDistanceAndPrice() {
            console.log('🔍 calculateDistanceAndPrice called');
            
            // Wait for Google Maps API to load
            if (typeof google === 'undefined' || !google.maps || !distanceMatrixService) {
                console.warn('⚠️ Google Maps not ready yet. google:', typeof google, 'distanceMatrixService:', distanceMatrixService);
                return;
            }
            
            console.log('✅ Google Maps ready, distanceMatrixService initialized');
            
            const pickupLocation = document.getElementById('pickup_location').value.trim();
            const dropoffLocation = document.getElementById('dropoff_location').value.trim();
            
            console.log('📍 Pickup:', pickupLocation);
            console.log('📍 Dropoff:', dropoffLocation);
            
            const infoContainer = document.getElementById('distancePriceInfo');
            const loadingInfo = document.getElementById('loadingInfo');
            const resultInfo = document.getElementById('resultInfo');
            const errorInfo = document.getElementById('errorInfo');
            const distanceValue = document.getElementById('distanceValue');
            const priceValue = document.getElementById('priceValue');
            const priceNote = document.getElementById('priceNote');
            
            // Reset display
            if (!pickupLocation || !dropoffLocation) {
                infoContainer.classList.remove('show');
                return;
            }
            
            // Show loading
            infoContainer.classList.add('show');
            loadingInfo.style.display = 'block';
            resultInfo.style.display = 'none';
            errorInfo.style.display = 'none';
            
            console.log('🚀 Calling Distance Matrix API...');
            
            // Use Google Distance Matrix API
            distanceMatrixService.getDistanceMatrix(
                {
                    origins: [pickupLocation + ', Đà Nẵng, Việt Nam'],
                    destinations: [dropoffLocation + ', Đà Nẵng, Việt Nam'],
                    travelMode: google.maps.TravelMode.DRIVING,
                    unitSystem: google.maps.UnitSystem.METRIC,
                    avoidHighways: false,
                    avoidTolls: false
                },
                function(response, status) {
                    console.log('📡 Distance Matrix Response - Status:', status);
                    console.log('📡 Response:', response);
                    
                    loadingInfo.style.display = 'none';
                    
                    if (status === 'OK' && response.rows[0].elements[0].status === 'OK') {
                        try {
                            // Get distance in meters and convert to km
                            const distanceMeters = response.rows[0].elements[0].distance.value;
                            const distanceKm = distanceMeters / 1000;
                            const distanceText = distanceKm.toFixed(1) + ' km';
                            
                            // Calculate price
                            const priceInfo = calculatePrice(distanceKm);
                            
                            // Display results
                            distanceValue.textContent = distanceText;
                            
                            // Set hidden field values for form submission
                            document.getElementById('distance_hidden').value = distanceKm.toFixed(2);
                            
                            if (priceInfo.price === null) {
                                // Over 30km case - don't set price
                                document.getElementById('price_hidden').value = '';
                                priceValue.textContent = priceInfo.message;
                                priceValue.style.fontSize = '14px';
                                priceNote.textContent = priceInfo.note;
                                priceNote.style.display = 'block';
                                priceNote.style.background = 'rgba(230, 57, 70, 0.2)';
                                priceNote.style.color = 'var(--red-light)';
                            } else {
                                // Set price for form submission
                                document.getElementById('price_hidden').value = priceInfo.price;
                                priceValue.textContent = priceInfo.message;
                                priceValue.style.fontSize = '18px';
                                priceNote.textContent = priceInfo.note;
                                priceNote.style.display = 'block';
                                priceNote.style.background = 'var(--bg-card)';
                                priceNote.style.color = 'var(--white-60)';
                            }
                            
                            resultInfo.style.display = 'block';
                        } catch (error) {
                            errorInfo.textContent = '❌ Lỗi xử lý dữ liệu: ' + error.message;
                            errorInfo.style.display = 'block';
                        }
                    } else {
                        let errorMessage = 'Không thể tính khoảng cách. ';
                        
                        if (status === 'OVER_QUERY_LIMIT') {
                            errorMessage += 'Đã vượt quá giới hạn truy vấn API.';
                        } else if (status === 'REQUEST_DENIED') {
                            errorMessage += 'API key không hợp lệ hoặc chưa được enable.';
                        } else if (status === 'INVALID_REQUEST') {
                            errorMessage += 'Yêu cầu không hợp lệ.';
                        } else if (response.rows[0].elements[0].status === 'ZERO_RESULTS') {
                            errorMessage += 'Không tìm thấy đường đi giữa hai địa điểm.';
                        } else if (response.rows[0].elements[0].status === 'NOT_FOUND') {
                            errorMessage += 'Không tìm thấy địa chỉ. Vui lòng kiểm tra lại.';
                        } else {
                            errorMessage += 'Vui lòng thử lại sau.';
                        }
                        
                        errorInfo.textContent = '❌ ' + errorMessage;
                        errorInfo.style.display = 'block';
                    }
                }
            );
        }
        
        // Initialize when page loads - wait for Google Maps API
        function startInit() {
            if (typeof google !== 'undefined' && google.maps) {
                initAutocomplete();
            } else {
                setTimeout(startInit, 100);
            }
        }
        
        // Start initialization when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', startInit);
        } else {
            startInit();
        }

        // Check if page was just loaded after form submission
        window.addEventListener('DOMContentLoaded', function() {
            // Check URL hash or session to determine which form was submitted
            const urlParams = new URLSearchParams(window.location.search);
            const formType = urlParams.get('form');
            
            if (formType === 'booking') {
                // Scroll to booking section after booking form submission
                setTimeout(() => {
                    document.getElementById('booking')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);
            } else if (formType === 'support') {
                // Scroll to contact section after support form submission
                setTimeout(() => {
                    document.getElementById('contact')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);
            }
        });

        // SweetAlert2 for booking form
        @if(session('success'))
            const successMessage = {!! json_encode(session('success')) !!};
            const isBookingSuccess = successMessage.includes('đặt xe') || successMessage.includes('booking');
            
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: successMessage,
                confirmButtonText: 'Đóng',
                confirmButtonColor: '#C9A227',
                background: '#1A1A1A',
                color: '#FFFFFF',
                timer: 5000,
                timerProgressBar: true,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            }).then(() => {
                // Scroll to appropriate section based on form type
                if (isBookingSuccess) {
                    document.getElementById('booking')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                } else {
                    document.getElementById('contact')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        @endif

        @if($errors->any())
            const errorMessages = @json($errors->all());
            const errorHtml = '<ul style="text-align: left; padding-left: 20px;">' + 
                errorMessages.map(error => `<li>${error}</li>`).join('') + 
                '</ul>';
            
            Swal.fire({
                icon: 'error',
                title: 'Có lỗi xảy ra!',
                html: errorHtml,
                confirmButtonText: 'Đóng',
                confirmButtonColor: '#E63946',
                background: '#1A1A1A',
                color: '#FFFFFF',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            }).then(() => {
                // Scroll to booking section on error (most errors are from booking form)
                document.getElementById('booking')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        @endif

        // Form submission with loading - Booking Form
        const bookingForm = document.getElementById('bookingForm');
        if (bookingForm) {
            bookingForm.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang gửi...';
            });
        }

        // Form submission with loading - Support Form
        const supportForm = document.getElementById('supportForm');
        if (supportForm) {
            supportForm.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang gửi...';
            });
        }
    </script>
</body>
</html>
