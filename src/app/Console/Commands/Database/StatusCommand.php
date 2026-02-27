<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class StatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:status
                            {--detailed : Show detailed information}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show database connection status and information';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $detailed = $this->option('detailed');

        $this->newLine();
        $this->info('📊 Database Status');
        $this->newLine();
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        try {
            // Connection info
            $connection = DB::connection();
            $pdo = $connection->getPdo();
            
            $this->line('Connection: <fg=green>✓ Active</>');
            $this->line('Driver: ' . $connection->getDriverName());
            $this->line('Database: ' . $connection->getDatabaseName());
            $this->line('Host: ' . config('database.connections.' . config('database.default') . '.host'));
            $this->line('Port: ' . config('database.connections.' . config('database.default') . '.port'));

            // Version
            if ($connection->getDriverName() === 'mysql') {
                $version = DB::select('SELECT VERSION() as version')[0]->version ?? 'Unknown';
                $this->line('Version: ' . $version);
            }

            // Tables count
            $tables = DB::select('SHOW TABLES');
            $tableCount = count($tables);
            $this->line('Tables: ' . $tableCount);

            if ($detailed && $tableCount > 0) {
                $this->newLine();
                $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
                $this->info('📋 Tables Information');
                $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
                
                $tableData = [];
                foreach ($tables as $table) {
                    $tableName = array_values((array) $table)[0];
                    $count = DB::table($tableName)->count();
                    $tableData[] = [
                        'Table' => $tableName,
                        'Rows' => number_format($count),
                    ];
                }
                
                $this->table(['Table', 'Rows'], $tableData);
            }

            // Migrations
            $this->newLine();
            $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->info('🔄 Migrations');
            $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            
            try {
                $migrations = DB::table('migrations')->count();
                $this->line('Applied Migrations: ' . $migrations);
                
                if ($detailed) {
                    $lastMigrations = DB::table('migrations')
                        ->orderBy('id', 'desc')
                        ->limit(5)
                        ->get();
                    
                    if ($lastMigrations->isNotEmpty()) {
                        $this->newLine();
                        $this->line('Last 5 migrations:');
                        foreach ($lastMigrations as $migration) {
                            $this->line('  • ' . $migration->migration . ' (batch: ' . $migration->batch . ')');
                        }
                    }
                }
            } catch (\Exception $e) {
                $this->line('Migrations table: <fg=red>Not found</>');
            }

            $this->newLine();
            $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->info('✅ Database is healthy');
            $this->newLine();

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Database connection failed!');
            $this->error('Error: ' . $e->getMessage());
            $this->newLine();
            
            return self::FAILURE;
        }
    }
}
