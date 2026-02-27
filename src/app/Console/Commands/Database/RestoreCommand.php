<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class RestoreCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:restore
                            {file? : The backup file to restore}
                            {--path= : Custom backup directory path}
                            {--force : Skip confirmation prompt}
                            {--latest : Restore the latest backup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore database from a backup file';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->newLine();
        $this->info('🔄 Database Restore');
        $this->newLine();

        // Get database configuration
        $database = config('database.connections.' . config('database.default'));
        $dbName = $database['database'];
        $dbUser = $database['username'];
        $dbPassword = $database['password'];
        $dbHost = $database['host'];
        $dbPort = $database['port'];

        // Determine backup path
        $backupPath = $this->option('path') ?? storage_path('backups');

        if (!is_dir($backupPath)) {
            $this->error('❌ Backup directory not found: ' . $backupPath);
            return self::FAILURE;
        }

        // Get backup file
        $backupFile = null;

        if ($this->option('latest')) {
            // Find latest backup
            $files = glob($backupPath . '/backup_*.sql*');
            
            if (empty($files)) {
                $this->error('❌ No backup files found in: ' . $backupPath);
                return self::FAILURE;
            }

            usort($files, function ($a, $b) {
                return filemtime($b) - filemtime($a);
            });

            $backupFile = $files[0];
            $this->line('Using latest backup: ' . basename($backupFile));
        } elseif ($file = $this->argument('file')) {
            // Use specified file
            if (file_exists($file)) {
                $backupFile = $file;
            } elseif (file_exists($backupPath . '/' . $file)) {
                $backupFile = $backupPath . '/' . $file;
            } else {
                $this->error('❌ Backup file not found: ' . $file);
                return self::FAILURE;
            }
        } else {
            // List available backups
            $files = glob($backupPath . '/backup_*.sql*');
            
            if (empty($files)) {
                $this->error('❌ No backup files found in: ' . $backupPath);
                return self::FAILURE;
            }

            $this->line('Available backups:');
            $this->newLine();

            $choices = [];
            foreach ($files as $index => $file) {
                $filename = basename($file);
                $size = $this->formatBytes(filesize($file));
                $date = date('Y-m-d H:i:s', filemtime($file));
                $choices[$index] = "{$filename} ({$size}) - {$date}";
                $this->line('  [' . $index . '] ' . $choices[$index]);
            }

            $this->newLine();
            $choice = $this->ask('Select backup to restore (number)');

            if (!isset($files[$choice])) {
                $this->error('Invalid selection');
                return self::FAILURE;
            }

            $backupFile = $files[$choice];
        }

        // Show warning
        $this->newLine();
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->warn('⚠️  WARNING: This will overwrite the current database!');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->line('Database: ' . $dbName);
        $this->line('Backup File: ' . basename($backupFile));
        $this->line('File Size: ' . $this->formatBytes(filesize($backupFile)));
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->newLine();

        // Confirm
        if (!$this->option('force')) {
            if (!$this->confirm('Do you want to continue?', false)) {
                $this->info('Restore cancelled.');
                return self::SUCCESS;
            }
        }

        $this->newLine();
        $this->line('Restoring database...');

        try {
            // Check if file is compressed
            $isCompressed = str_ends_with($backupFile, '.gz');

            // Build mysql command
            $command = sprintf(
                'mysql -h%s -P%s -u%s -p%s %s',
                escapeshellarg($dbHost),
                escapeshellarg($dbPort),
                escapeshellarg($dbUser),
                escapeshellarg($dbPassword),
                escapeshellarg($dbName)
            );

            // Handle compressed files
            if ($isCompressed) {
                $command = 'gunzip < ' . escapeshellarg($backupFile) . ' | ' . $command;
            } else {
                $command .= ' < ' . escapeshellarg($backupFile);
            }

            // Execute restore
            $result = Process::run($command);

            if ($result->successful()) {
                $this->newLine();
                $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
                $this->info('✅ Database restored successfully!');
                $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
                $this->line('📁 From: ' . basename($backupFile));
                $this->line('💾 Database: ' . $dbName);
                $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
                $this->newLine();

                return self::SUCCESS;
            } else {
                $this->error('❌ Restore failed!');
                $this->error($result->errorOutput());
                
                return self::FAILURE;
            }
        } catch (\Exception $e) {
            $this->error('❌ Restore failed!');
            $this->error('Error: ' . $e->getMessage());
            
            return self::FAILURE;
        }
    }

    /**
     * Format bytes to human readable size
     */
    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
