<?php

namespace App\Console\Commands\User;

use App\Models\User;
use Illuminate\Console\Command;

class ListUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:list
                            {--verified : Show only verified users}
                            {--unverified : Show only unverified users}
                            {--limit= : Limit number of results}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all users in the system';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $query = User::query();

        // Apply filters
        if ($this->option('verified')) {
            $query->whereNotNull('email_verified_at');
        }

        if ($this->option('unverified')) {
            $query->whereNull('email_verified_at');
        }

        if ($limit = $this->option('limit')) {
            $query->limit((int) $limit);
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        if ($users->isEmpty()) {
            $this->warn('No users found.');
            return self::SUCCESS;
        }

        $this->newLine();
        $this->info('Total users: ' . $users->count());
        $this->newLine();

        // Prepare table data
        $tableData = $users->map(function ($user) {
            return [
                'ID' => $user->id,
                'Name' => $user->name,
                'Email' => $user->email,
                'Phone' => $user->phone ?? '-',
                'Verified' => $user->email_verified_at ? '✓' : '✗',
                'Created' => $user->created_at->format('Y-m-d H:i'),
            ];
        })->toArray();

        $this->table(
            ['ID', 'Name', 'Email', 'Phone', 'Verified', 'Created'],
            $tableData
        );

        return self::SUCCESS;
    }
}
