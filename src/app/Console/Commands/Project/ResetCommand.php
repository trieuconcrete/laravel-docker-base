<?php

namespace App\Console\Commands\Project;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ResetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:reset
                            {--force : Skip confirmation prompt}
                            {--no-seed : Skip database seeding}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the project (fresh migration, seed, clear cache)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $force = $this->option('force');
        $noSeed = $this->option('no-seed');

        // Warning
        $this->warn('⚠️  This will drop all tables and reset the database!');
        $this->newLine();

        // Confirm
        if (!$force) {
            if (!$this->confirm('Do you want to continue?', false)) {
                $this->info('Operation cancelled.');
                return self::SUCCESS;
            }
        }

        $this->newLine();
        $this->info('🔄 Starting project reset...');
        $this->newLine();

        // Step 1: Drop all tables and migrate
        $this->info('📦 Step 1/4: Migrating database...');
        Artisan::call('migrate:fresh', ['--force' => true]);
        $this->line('   ✓ Database migrated');

        // Step 2: Seed database
        if (!$noSeed) {
            $this->info('🌱 Step 2/4: Seeding database...');
            Artisan::call('db:seed', ['--force' => true]);
            $this->line('   ✓ Database seeded');
        } else {
            $this->info('⏭️  Step 2/4: Skipping database seeding');
        }

        // Step 3: Clear all caches
        $this->info('🧹 Step 3/4: Clearing caches...');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        $this->line('   ✓ All caches cleared');

        // Step 4: Optimize
        $this->info('⚡ Step 4/4: Optimizing application...');
        Artisan::call('optimize:clear');
        $this->line('   ✓ Application optimized');

        $this->newLine();
        $this->info('✅ Project reset completed successfully!');
        $this->newLine();

        return self::SUCCESS;
    }
}
