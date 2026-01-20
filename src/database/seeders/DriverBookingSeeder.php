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
                'notes' => 'Cần xe 7 chỗ',
                'status' => 'completed',
                'booking_date' => now()->subDay(),
                'created_at' => now()->subDay(),
            ],
            [
                'name' => 'Hoàng Thị Em',
                'phone' => '0945678901',
                'pickup_location' => 'Big C Đà Nẵng',
                'dropoff_location' => null,
                'notes' => 'Chỉ cần đi trong khu vực 5km',
                'status' => 'pending',
                'booking_date' => now()->subMinutes(30),
                'created_at' => now()->subMinutes(30),
            ],
            [
                'name' => 'Đỗ Văn Phúc',
                'phone' => '0956789012',
                'pickup_location' => 'Quán Bia Hơi 2/9',
                'dropoff_location' => 'Chung cư Hòa Khánh, Liên Chiểu',
                'notes' => 'Đi nhậu về, không lái được',
                'status' => 'cancelled',
                'booking_date' => now()->subDays(2),
                'created_at' => now()->subDays(2),
            ],
        ];

        foreach ($bookings as $booking) {
            DriverBooking::create($booking);
        }

        $this->command->info('✅ Sample driver bookings created successfully!');
    }
}
