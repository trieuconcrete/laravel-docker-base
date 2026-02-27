<?php

namespace App\Console\Commands\User;

use App\Models\User;
use Illuminate\Console\Command;

class DeleteUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete
                            {email : The email address of the user to delete}
                            {--force : Skip confirmation prompt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a user from the system';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->argument('email');
        $force = $this->option('force');

        // Find user
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return self::FAILURE;
        }

        // Show user info
        $this->newLine();
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->line('User to delete:');
        $this->line('👤 Name: ' . $user->name);
        $this->line('📧 Email: ' . $user->email);
        $this->line('🆔 ID: ' . $user->id);
        $this->line('📅 Created: ' . $user->created_at->format('Y-m-d H:i:s'));
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->newLine();

        // Confirm deletion
        if (!$force) {
            if (!$this->confirm('Are you sure you want to delete this user? This action cannot be undone.', false)) {
                $this->info('Deletion cancelled.');
                return self::SUCCESS;
            }
        }

        // Delete user
        try {
            $user->delete();

            $this->newLine();
            $this->info('✅ User deleted successfully!');

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to delete user: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}
