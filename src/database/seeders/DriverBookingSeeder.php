<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DriverBooking;

class DriverBookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookings = [
            [
                'name' => 'Nguyễn Văn An',
                'phone' => '0901234567',
                'pickup_location' => '123 Trần Phú, Hải Châu, Đà Nẵng',
                'dropoff_location' => 'Sân bay Đà Nẵng',
                'distance' => 6.8,
                'price' => 252000,
                'notes' => 'Cần đến trước 8h sáng',
                'status' => 'pending',
                'booking_date' => now()->subHours(2),
                'created_at' => now()->subHours(2),
            ],
            [
                'name' => 'Trần Thị Bình',
                'phone' => '0912345678',
                'pickup_location' => 'Khách sạn Mường Thanh, Sơn Trà',
                'dropoff_location' => '456 Nguyễn Văn Linh, Thanh Khê',
                'distance' => 4.5,
                'price' => 217500,
                'notes' => 'Khách say rượu, cần hỗ trợ',
                'status' => 'confirmed',
                'booking_date' => now()->subHours(5),
                'created_at' => now()->subHours(5),
            ],
            [
                'name' => 'Lê Minh Châu',
                'phone' => '0923456789',
                'pickup_location' => 'Nhà hàng Hải Sản Ngọc Anh, An Hải Bắc',
                'dropoff_location' => 'Khu đô thị FPT, Ngũ Hành Sơn',
                'distance' => 8.2,
                'price' => 273000,
                'notes' => null,
                'status' => 'assigned',
                'booking_date' => now()->subHours(1),
                'created_at' => now()->subHours(1),
            ],
            [
                'name' => 'Phạm Văn Dũng',
                'phone' => '0934567890',
                'pickup_location' => 'Bệnh viện C Đà Nẵng',
                'dropoff_location' => '789 Lê Duẩn, Hải Châu',
                'distance' => 3.2,
                'price' => 198000,
                'notes' => 'Cần xe 7 chỗ',
                'status' => 'completed',
                'booking_date' => now()->subDay(),
                'created_at' => now()->subDay(),
            ],
            [
                'name' => 'Hoàng Thị Em',
                'phone' => '0945678901',
                'pickup_location' => 'Big C Đà Nẵng',
                'dropoff_location' => 'Chợ Hàn, Hải Châu',
                'distance' => 2.3,
                'price' => 184500,
                'notes' => 'Chỉ cần đi trong khu vực gần',
                'status' => 'pending',
                'booking_date' => now()->subMinutes(30),
                'created_at' => now()->subMinutes(30),
            ],
            [
                'name' => 'Đỗ Văn Phúc',
                'phone' => '0956789012',
                'pickup_location' => 'Quán Bia Hơi 2/9',
                'dropoff_location' => 'Chung cư Hòa Khánh, Liên Chiểu',
                'distance' => 12.5,
                'price' => 337500,
                'notes' => 'Đi nhậu về, không lái được',
                'status' => 'cancelled',
                'booking_date' => now()->subDays(2),
                'created_at' => now()->subDays(2),
            ],
            [
                'name' => 'Vũ Thị Giang',
                'phone' => '0967890123',
                'pickup_location' => 'Cầu Rồng, Sơn Trà',
                'dropoff_location' => 'Hội An, Quảng Nam',
                'distance' => 35.7,
                'price' => null,
                'notes' => 'Đi Hội An, đã thỏa thuận giá 800k',
                'status' => 'completed',
                'booking_date' => now()->subDays(3),
                'created_at' => now()->subDays(3),
            ],
            [
                'name' => 'Trần Văn Hùng',
                'phone' => '0978901234',
                'pickup_location' => 'Vincom Đà Nẵng',
                'dropoff_location' => 'Bãi biển Mỹ Khê',
                'distance' => 5.4,
                'price' => 231000,
                'notes' => 'Đưa gia đình đi chơi biển',
                'status' => 'assigned',
                'booking_date' => now()->subHours(3),
                'created_at' => now()->subHours(3),
            ],
        ];

        foreach ($bookings as $booking) {
            DriverBooking::create($booking);
        }

        $this->command->info('✅ Sample driver bookings created successfully!');
    }
}
