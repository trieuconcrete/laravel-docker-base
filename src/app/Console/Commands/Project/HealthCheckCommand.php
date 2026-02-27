<?php

namespace App\Console\Commands\Project;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Exception;

class HealthCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:health
                            {--detailed : Show detailed information}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check health of all services (Database, Redis, etc.)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $detailed = $this->option('detailed');
        $allHealthy = true;

        $this->newLine();
        $this->info('🏥 Running Health Checks...');
        $this->newLine();

        // Check Database
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('📊 Database Connection');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        
        try {
            $startTime = microtime(true);
            DB::connection()->getPdo();
            $responseTime = round((microtime(true) - $startTime) * 1000, 2);
            
            $this->line('  Status: <fg=green>✓ Connected</>');
            $this->line('  Driver: ' . DB::connection()->getDriverName());
            $this->line('  Database: ' . DB::connection()->getDatabaseName());
            $this->line('  Response Time: ' . $responseTime . 'ms');
            
            if ($detailed) {
                $version = DB::select('SELECT VERSION() as version')[0]->version ?? 'Unknown';
                $this->line('  Version: ' . $version);
            }
        } catch (Exception $e) {
            $this->line('  Status: <fg=red>✗ Failed</>');
            $this->line('  Error: ' . $e->getMessage());
            $allHealthy = false;
        }

        $this->newLine();

        // Check Redis
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('🔴 Redis Connection');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        
        try {
            $startTime = microtime(true);
            Redis::connection()->ping();
            $responseTime = round((microtime(true) - $startTime) * 1000, 2);
            
            $this->line('  Status: <fg=green>✓ Connected</>');
            $this->line('  Response Time: ' . $responseTime . 'ms');
            
            if ($detailed) {
                $info = Redis::connection()->info();
                $this->line('  Version: ' . ($info['redis_version'] ?? 'Unknown'));
                $this->line('  Used Memory: ' . ($info['used_memory_human'] ?? 'Unknown'));
            }
        } catch (Exception $e) {
            $this->line('  Status: <fg=red>✗ Failed</>');
            $this->line('  Error: ' . $e->getMessage());
            $allHealthy = false;
        }

        $this->newLine();

        // Check Storage
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('💾 Storage');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        
        $storagePublic = storage_path('app/public');
        $logsPath = storage_path('logs');
        
        $this->line('  Public Storage: ' . (is_writable($storagePublic) ? '<fg=green>✓ Writable</>' : '<fg=red>✗ Not Writable</>'));
        $this->line('  Logs Directory: ' . (is_writable($logsPath) ? '<fg=green>✓ Writable</>' : '<fg=red>✗ Not Writable</>'));
        
        if ($detailed) {
            $this->line('  Public Path: ' . $storagePublic);
            $this->line('  Logs Path: ' . $logsPath);
        }

        if (!is_writable($storagePublic) || !is_writable($logsPath)) {
            $allHealthy = false;
        }

        $this->newLine();

        // Check Environment
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('⚙️  Environment');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        
        $this->line('  PHP Version: ' . PHP_VERSION);
        $this->line('  Laravel Version: ' . app()->version());
        $this->line('  Environment: ' . app()->environment());
        $this->line('  Debug Mode: ' . (config('app.debug') ? '<fg=yellow>Enabled</>' : '<fg=green>Disabled</>'));
        
        if ($detailed) {
            $this->line('  Timezone: ' . config('app.timezone'));
            $this->line('  Locale: ' . config('app.locale'));
        }

        $this->newLine();
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        // Overall status
        if ($allHealthy) {
            $this->info('✅ All systems operational!');
        } else {
            $this->error('❌ Some services are not healthy!');
            return self::FAILURE;
        }

        $this->newLine();

        return self::SUCCESS;
    }
}
