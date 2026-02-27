<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get password from environment or use default for development
        $defaultPassword = env('SEEDER_DEFAULT_PASSWORD', 'password');
        $useRandomPasswords = env('SEEDER_USE_RANDOM_PASSWORDS', false);
        
        $credentials = [];

        // Create Admin User
        $adminPassword = $useRandomPasswords ? Str::random(16) : $defaultPassword;
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make($adminPassword),
            'email_verified_at' => now(),
        ]);
        $credentials['admin'] = [
            'email' => 'admin@admin.com',
            'password' => $adminPassword,
        ];

        // Create Demo User
        $demoPassword = $useRandomPasswords ? Str::random(16) : $defaultPassword;
        User::create([
            'name' => 'Demo User',
            'email' => 'demo@demo.com',
            'password' => Hash::make($demoPassword),
            'email_verified_at' => now(),
        ]);
        $credentials['demo'] = [
            'email' => 'demo@demo.com',
            'password' => $demoPassword,
        ];

        // Create Test User
        $testPassword = $useRandomPasswords ? Str::random(16) : $defaultPassword;
        User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => Hash::make($testPassword),
            'email_verified_at' => now(),
        ]);
        $credentials['test'] = [
            'email' => 'test@test.com',
            'password' => $testPassword,
        ];

        $this->command->info('✅ Users created successfully!');
        $this->command->info('');
        $this->command->info('Login credentials:');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        
        foreach ($credentials as $role => $cred) {
            $this->command->info('📧 Email: ' . $cred['email']);
            $this->command->info('🔒 Password: ' . $cred['password']);
            $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        }

        if ($useRandomPasswords) {
            $this->command->warn('⚠️  Random passwords generated! Save these credentials.');
        } elseif ($defaultPassword === 'password' && app()->environment('production')) {
            $this->command->error('⚠️  WARNING: Using default password in production!');
            $this->command->error('   Set SEEDER_DEFAULT_PASSWORD or SEEDER_USE_RANDOM_PASSWORDS=true in .env');
        }
    }
}
