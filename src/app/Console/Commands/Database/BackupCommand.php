<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Carbon\Carbon;

class BackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup
                            {--name= : Custom backup file name}
                            {--path= : Custom backup directory path}
                            {--compress : Compress the backup file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a database backup';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->newLine();
        $this->info('💾 Creating database backup...');
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
        
        // Create backup directory if it doesn't exist
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
            $this->line('✓ Created backup directory: ' . $backupPath);
        }

        // Generate backup filename
        $timestamp = Carbon::now()->format('Y-m-d_His');
        $filename = $this->option('name') ?? "backup_{$dbName}_{$timestamp}.sql";
        
        if ($this->option('compress')) {
            $filename .= '.gz';
        }
        
        $backupFile = $backupPath . '/' . $filename;

        try {
            // Build mysqldump command
            $command = sprintf(
                'mysqldump -h%s -P%s -u%s -p%s %s',
                escapeshellarg($dbHost),
                escapeshellarg($dbPort),
                escapeshellarg($dbUser),
                escapeshellarg($dbPassword),
                escapeshellarg($dbName)
            );

            // Add compression if requested
            if ($this->option('compress')) {
                $command .= ' | gzip';
            }

            // Redirect output to file
            $command .= ' > ' . escapeshellarg($backupFile);

            // Execute backup
            $this->line('Executing backup...');
            
            $result = Process::run($command);

            if ($result->successful()) {
                $fileSize = filesize($backupFile);
                $fileSizeHuman = $this->formatBytes($fileSize);

                $this->newLine();
                $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
                $this->info('✅ Backup created successfully!');
                $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
                $this->line('📁 File: ' . $filename);
                $this->line('📍 Location: ' . $backupFile);
                $this->line('📊 Size: ' . $fileSizeHuman);
                $this->line('🗜️  Compressed: ' . ($this->option('compress') ? 'Yes' : 'No'));
                $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
                $this->newLine();

                // Clean old backups (keep last 10)
                $this->cleanOldBackups($backupPath);

                return self::SUCCESS;
            } else {
                $this->error('❌ Backup failed!');
                $this->error($result->errorOutput());
                
                // Clean up failed backup file
                if (file_exists($backupFile)) {
                    unlink($backupFile);
                }
                
                return self::FAILURE;
            }
        } catch (\Exception $e) {
            $this->error('❌ Backup failed!');
            $this->error('Error: ' . $e->getMessage());
            
            return self::FAILURE;
        }
    }

    /**
     * Clean old backup files, keeping only the last 10
     */
    private function cleanOldBackups(string $path): void
    {
        $files = glob($path . '/backup_*.sql*');
        
        if (count($files) > 10) {
            // Sort by modification time
            usort($files, function ($a, $b) {
                return filemtime($a) - filemtime($b);
            });

            // Remove oldest files
            $filesToDelete = array_slice($files, 0, count($files) - 10);
            
            foreach ($filesToDelete as $file) {
                unlink($file);
            }
            
            $this->line('🧹 Cleaned up ' . count($filesToDelete) . ' old backup(s)');
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
