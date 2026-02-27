<?php

namespace App\Console\Commands\User;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:password
                            {email : The email address of the user}
                            {--password= : The new password}
                            {--random : Generate a random password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset a user\'s password';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->argument('email');
        $password = $this->option('password');
        $random = $this->option('random');

        // Find user
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return self::FAILURE;
        }

        // Get password
        if ($random) {
            $password = Str::random(16);
            $showPassword = true;
        } elseif (empty($password)) {
            $password = $this->secret('Enter new password (leave empty for random)');
            if (empty($password)) {
                $password = Str::random(16);
                $showPassword = true;
            } else {
                $confirmation = $this->secret('Confirm password');
                if ($password !== $confirmation) {
                    $this->error('Passwords do not match!');
                    return self::FAILURE;
                }
                $showPassword = false;
            }
        } else {
            $showPassword = false;
        }

        // Validate password length
        if (!$random && strlen($password) < 8) {
            $this->error('Password must be at least 8 characters long.');
            return self::FAILURE;
        }

        // Update password
        try {
            $user->password = Hash::make($password);
            $user->save();

            $this->newLine();
            $this->info('✅ Password updated successfully!');
            $this->newLine();
            $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->line('👤 User: ' . $user->name);
            $this->line('📧 Email: ' . $user->email);
            if ($showPassword) {
                $this->line('🔒 New Password: ' . $password);
                $this->warn('⚠️  Save this password! It won\'t be shown again.');
            } else {
                $this->line('🔒 Password has been updated.');
            }
            $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to update password: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}
