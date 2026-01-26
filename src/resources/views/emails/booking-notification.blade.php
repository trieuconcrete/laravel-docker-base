<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn Đặt Xe Mới</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .email-container {
            background: #f8f9fa;
            border-radius: 10px;
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #C9A227 0%, #D4A84B 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            background: white;
            padding: 30px 20px;
        }
        .booking-info {
            background: #f8f9fa;
            border-left: 4px solid #C9A227;
            padding: 15px;
            margin: 20px 0;
        }
        .info-row {
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #C9A227;
            display: inline-block;
            width: 140px;
        }
        .value {
            color: #333;
        }
        .highlight {
            background: #fff3cd;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }
        .highlight strong {
            color: #C9A227;
            font-size: 18px;
        }
        .footer {
            background: #2A2A2A;
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 14px;
        }
        .footer a {
            color: #C9A227;
            text-decoration: none;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            background: #fff3cd;
            color: #856404;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🚗 Đơn Đặt Xe Mới</h1>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">Xế Hộ 24/7 - Đà Nẵng</p>
        </div>

        <div class="content">
            <p>Xin chào Admin,</p>
            <p>Có một đơn đặt xe mới từ khách hàng. Chi tiết như sau:</p>

            <div class="booking-info">
                <div class="info-row">
                    <span class="label">👤 Họ tên:</span>
                    <span class="value">{{ $booking->name }}</span>
                </div>

                <div class="info-row">
                    <span class="label">📱 Số điện thoại:</span>
                    <span class="value"><strong>{{ $booking->phone }}</strong></span>
                </div>

                <div class="info-row">
                    <span class="label">📍 Điểm đón:</span>
                    <span class="value">{{ $booking->pickup_location }}</span>
                </div>

                @if($booking->dropoff_location)
                <div class="info-row">
                    <span class="label">🎯 Điểm đến:</span>
                    <span class="value">{{ $booking->dropoff_location }}</span>
                </div>
                @endif

                @if($booking->distance)
                <div class="info-row">
                    <span class="label">📏 Quãng đường:</span>
                    <span class="value">{{ number_format($booking->distance, 1) }} km</span>
                </div>
                @endif

                @if($booking->price)
                <div class="info-row">
                    <span class="label">💰 Giá ước tính:</span>
                    <span class="value"><strong style="color: #C9A227;">{{ number_format($booking->price) }}đ</strong></span>
                </div>
                @endif

                @if($booking->notes)
                <div class="info-row">
                    <span class="label">📝 Ghi chú:</span>
                    <span class="value">{{ $booking->notes }}</span>
                </div>
                @endif

                <div class="info-row">
                    <span class="label">🕐 Thời gian đặt:</span>
                    <span class="value">{{ $booking->created_at->format('d/m/Y H:i') }}</span>
                </div>

                <div class="info-row">
                    <span class="label">📊 Trạng thái:</span>
                    <span class="status-badge">{{ strtoupper($booking->status) }}</span>
                </div>
            </div>

            <div class="highlight">
                <p style="margin: 0;">⚡ <strong>Vui lòng liên hệ khách hàng trong vòng 5 phút!</strong></p>
            </div>

            <p style="text-align: center; margin-top: 30px;">
                <a href="{{ url('/admin/bookings') }}" style="display: inline-block; background: #C9A227; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                    Xem Chi Tiết Đơn Hàng
                </a>
            </p>
        </div>

        <div class="footer">
            <p style="margin: 0 0 10px 0;">
                <strong>Xế Hộ 24/7 - Đà Nẵng</strong>
            </p>
            <p style="margin: 0;">
                📞 Hotline: <a href="tel:0559304993">0559 304 993</a>
            </p>
            <p style="margin: 10px 0 0 0; opacity: 0.7; font-size: 12px;">
                Email được gửi tự động từ hệ thống
            </p>
        </div>
    </div>
</body>
</html>
