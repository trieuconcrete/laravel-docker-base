<?php

namespace App\Console\Commands\User;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create
                            {--name= : The name of the user}
                            {--email= : The email address of the user}
                            {--password= : The password for the user}
                            {--admin : Make the user an admin}
                            {--verified : Mark email as verified}
                            {--random-password : Generate a random password}
                            {--interactive : Interactive mode with prompts}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user with custom details';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $interactive = $this->option('interactive');

        // Get user details
        $name = $this->option('name');
        $email = $this->option('email');
        $password = $this->option('password');
        $isAdmin = $this->option('admin');
        $verified = $this->option('verified');
        $randomPassword = $this->option('random-password');

        // Interactive mode
        if ($interactive || (!$name && !$email)) {
            $name = $this->ask('User name');
            $email = $this->ask('Email address');
            
            if ($this->confirm('Generate random password?', false)) {
                $randomPassword = true;
            } else {
                $password = $this->secret('Password (leave empty for random)');
                if (empty($password)) {
                    $randomPassword = true;
                }
            }
            
            $isAdmin = $this->confirm('Make this user an admin?', false);
            $verified = $this->confirm('Mark email as verified?', true);
        }

        // Validate inputs
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            $this->error('Validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error('  - ' . $error);
            }
            return self::FAILURE;
        }

        // Generate random password if needed
        if ($randomPassword || empty($password)) {
            $password = Str::random(16);
            $showPassword = true;
        } else {
            $showPassword = false;
        }

        // Create user
        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => $verified ? now() : null,
            ]);

            $this->newLine();
            $this->info('✅ User created successfully!');
            $this->newLine();
            $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->line('👤 Name: ' . $user->name);
            $this->line('📧 Email: ' . $user->email);
            if ($showPassword) {
                $this->line('🔒 Password: ' . $password);
                $this->warn('⚠️  Save this password! It won\'t be shown again.');
            }
            $this->line('✔️  Email Verified: ' . ($verified ? 'Yes' : 'No'));
            if ($isAdmin) {
                $this->line('👑 Admin: Yes');
            }
            $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to create user: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}
