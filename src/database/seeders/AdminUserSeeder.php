<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo admin user mặc định
        User::updateOrCreate(
            ['email' => 'admin@xeho247.com'],
            [
                'name' => 'Admin Xế Hộ 24/7',
                'phone' => '0559304993',
                'password' => Hash::make('admin123456'),
                'email_verified_at' => now(),
            ]
        );

        // Tạo thêm một user demo
        User::updateOrCreate(
            ['email' => 'demo@xeho247.com'],
            [
                'name' => 'Demo User',
                'phone' => '0123456789',
                'password' => Hash::make('demo123456'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Admin users created successfully!');
        $this->command->info('📧 Email: admin@xeho247.com | Password: admin123456');
        $this->command->info('📧 Email: demo@xeho247.com | Password: demo123456');
    }
}
