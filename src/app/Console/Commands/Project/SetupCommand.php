<?php

namespace App\Console\Commands\Project;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SetupCommand extends Command
{
    protected $signature = 'project:setup
                            {--quick : Skip interactive prompts and use defaults}
                            {--create-database : Create a new database}
                            {--db-name= : Custom database name}';

    protected $description = 'Interactive project setup wizard with database and admin user creation';

    private array $adminCredentials = [];

    public function handle(): int
    {
        $quick = $this->option('quick');

        $this->newLine();
        $this->info('🚀 Laravel Project Setup Wizard');
        $this->newLine();

        // Step 1: Check and create .env
        if (!file_exists(base_path('.env'))) {
            $this->warn('⚠️  .env file not found. Creating from .env.example...');
            
            if (file_exists(base_path('.env.example'))) {
                copy(base_path('.env.example'), base_path('.env'));
                $this->line('   ✓ .env file created');
            } else {
                $this->error('❌ .env.example file not found!');
                return self::FAILURE;
            }
        } else {
            $this->line('✓ .env file exists');
        }

        // Step 2: Database Configuration
        $this->newLine();
        $this->info('📊 Database Configuration');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        $createDb = $this->option('create-database');
        if (!$quick && !$createDb) {
            $this->newLine();
            $this->line('Current database: ' . env('DB_DATABASE', 'Not set'));
            $createDb = $this->confirm('Do you want to create a new database?', false);
        }

        if ($createDb) {
            $dbName = $this->option('db-name');
            if (!$dbName && !$quick) {
                $currentDb = env('DB_DATABASE', '');
                $defaultName = !empty($currentDb) ? $currentDb . '_new' : 'laravel_' . date('Ymd_His');
                $this->newLine();
                $dbName = $this->ask('Enter new database name', $defaultName);
                
                // Validate database name
                if (preg_match('/[^a-zA-Z0-9_]/', $dbName)) {
                    $this->error('Database name can only contain letters, numbers and underscores!');
                    $dbName = preg_replace('/[^a-zA-Z0-9_]/', '_', $dbName);
                    $this->warn('Using sanitized name: ' . $dbName);
                }
            } elseif (!$dbName) {
                $dbName = 'laravel_' . date('Ymd_His');
            }

            $this->newLine();
            $this->line('Creating database: ' . $dbName . '...');
            
            $dbCreated = $this->createDatabase($dbName);
            
            if ($dbCreated) {
                // Verify database exists before updating .env
                if ($this->verifyDatabaseExists($dbName)) {
                    $this->updateEnvDatabase($dbName);
                    $this->reloadDatabaseConfig();
                } else {
                    $this->error('   ✗ Database verification failed!');
                    if (!$quick && !$this->confirm('Database might not be created. Continue anyway?', false)) {
                        return self::FAILURE;
                    }
                }
            } else {
                $this->error('   ✗ Database creation failed!');
                $this->newLine();
                $this->warn('   💡 You can create database manually:');
                $this->line('   docker-compose exec mysql mysql -u root -proot \\');
                $this->line('       -e "CREATE DATABASE IF NOT EXISTS ' . $dbName . ' CHARACTER SET utf8mb4"');
                $this->newLine();
                
                if (!$quick && !$this->confirm('Continue without creating database?', false)) {
                    return self::FAILURE;
                }
            }
        } else {
            $this->line('   ⏭️  Using existing database: ' . env('DB_DATABASE'));
        }

        // Step 3: Generate APP_KEY
        $this->newLine();
        if (empty(env('APP_KEY'))) {
            $this->info('🔑 Generating application key...');
            Artisan::call('key:generate', ['--force' => true]);
            $this->line('   ✓ Application key generated');
        } else {
            $this->line('✓ Application key exists');
        }

        // Step 4: Run migrations
        $this->newLine();
        if ($quick || $this->confirm('Run database migrations?', true)) {
            $this->info('📦 Running migrations...');
            $this->newLine();
            
            try {
                // Show migration output
                $exitCode = Artisan::call('migrate', [
                    '--force' => true,
                    '--verbose' => true
                ]);
                
                // Display the actual migration output
                $output = Artisan::output();
                if (!empty(trim($output))) {
                    $this->line($output);
                }
                
                if ($exitCode === 0) {
                    $this->newLine();
                    $this->line('   ✓ Migrations completed successfully');
                } else {
                    $this->error('   ✗ Migration command returned error code: ' . $exitCode);
                }
            } catch (\Exception $e) {
                $this->error('   ✗ Migration failed: ' . $e->getMessage());
                if (!$quick && !$this->confirm('Continue anyway?', false)) {
                    return self::FAILURE;
                }
            }
        }

        // Step 5: Create Admin User
        $this->newLine();
        $this->info('👤 Admin User Setup');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        if ($quick) {
            $this->createDefaultAdmin();
        } else {
            if ($this->confirm('Create admin user now?', true)) {
                $this->createCustomAdmin();
            }
        }

        // Step 6: Storage link
        $this->newLine();
        if (!file_exists(public_path('storage'))) {
            $this->info('🔗 Creating storage link...');
            Artisan::call('storage:link');
            $this->line('   ✓ Storage linked');
        } else {
            $this->line('✓ Storage link exists');
        }

        // Step 7: Optimize
        $this->newLine();
        $this->info('⚡ Optimizing application...');
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        $this->line('   ✓ Configuration cached');
        $this->line('   ✓ Routes cached');

        // Step 8: Health check
        $this->newLine();
        $this->info('🏥 Running health check...');
        Artisan::call('project:health');

        // Summary
        $this->displaySummary();

        return self::SUCCESS;
    }

    private function createDatabase(string $dbName): bool
    {
        $this->line('   Step 1: Attempting to create database...');

        try {
            $host = env('DB_HOST', '127.0.0.1');
            $port = env('DB_PORT', '3306');
            $normalUser = env('DB_USERNAME', 'laravel');
            
            $rootPasswords = ['root', env('MYSQL_ROOT_PASSWORD', 'root'), 'secret', ''];
            
            $pdo = null;
            
            $this->line('   Step 2: Connecting as root user...');
            
            foreach ($rootPasswords as $tryPassword) {
                try {
                    $pdo = new \PDO(
                        "mysql:host={$host};port={$port}",
                        'root',
                        $tryPassword,
                        [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
                    );
                    $this->line('   ✓ Connected as root');
                    break;
                } catch (\Exception $e) {
                    continue;
                }
            }
            
            if (!$pdo) {
                $this->warn('   ⚠️  Could not connect with root user via PDO');
                $this->line('   Step 3: Trying Docker MySQL command...');
                return $this->createDatabaseViaMysqlCommand($dbName);
            }

            // Create database
            $this->line('   Step 3: Creating database "' . $dbName . '"...');
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $this->line('   ✓ Database SQL executed');
            
            // Grant privileges
            if ($normalUser !== 'root') {
                $this->line('   Step 4: Granting privileges to user "' . $normalUser . '"...');
                $pdo->exec("GRANT ALL PRIVILEGES ON `{$dbName}`.* TO '{$normalUser}'@'%'");
                $pdo->exec("FLUSH PRIVILEGES");
                $this->line('   ✓ Privileges granted');
            }
            
            $this->line('   ✓ Database creation completed');
            return true;
        } catch (\Exception $e) {
            $this->error('   ✗ PDO method failed: ' . $e->getMessage());
            $this->line('   Trying Docker MySQL command method...');
            return $this->createDatabaseViaMysqlCommand($dbName);
        }
    }
    
    private function verifyDatabaseExists(string $dbName): bool
    {
        try {
            $this->line('   Verifying database exists...');
            
            $host = env('DB_HOST', '127.0.0.1');
            $port = env('DB_PORT', '3306');
            
            $rootPasswords = ['root', env('MYSQL_ROOT_PASSWORD', 'root'), 'secret', ''];
            
            foreach ($rootPasswords as $tryPassword) {
                try {
                    $pdo = new \PDO(
                        "mysql:host={$host};port={$port}",
                        'root',
                        $tryPassword,
                        [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
                    );
                    
                    $stmt = $pdo->query("SHOW DATABASES LIKE '{$dbName}'");
                    $result = $stmt->fetch();
                    
                    if ($result) {
                        $this->line('   ✓ Database verified: ' . $dbName);
                        return true;
                    }
                    
                    $this->warn('   ⚠️  Database not found in SHOW DATABASES');
                    return false;
                } catch (\Exception $e) {
                    continue;
                }
            }
            
            // Fallback: Try Docker command
            if (function_exists('shell_exec')) {
                $checkCommand = sprintf(
                    'docker-compose exec -T mysql mysql -u root -proot -e "SHOW DATABASES LIKE \'%s\'" 2>/dev/null',
                    $dbName
                );
                
                $output = shell_exec($checkCommand);
                
                if ($output && strpos($output, $dbName) !== false) {
                    $this->line('   ✓ Database verified via Docker: ' . $dbName);
                    return true;
                }
            }
            
            return false;
        } catch (\Exception $e) {
            $this->warn('   ⚠️  Could not verify database: ' . $e->getMessage());
            return false;
        }
    }

    private function createDatabaseViaMysqlCommand(string $dbName): bool
    {
        try {
            $normalUser = env('DB_USERNAME', 'laravel');
            
            if (function_exists('shell_exec')) {
                $this->line('   Attempting to create via Docker MySQL container...');
                
                // Create database
                $createDbCommand = sprintf(
                    'docker-compose exec -T mysql mysql -u root -proot -e "CREATE DATABASE IF NOT EXISTS %s CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci" 2>&1',
                    escapeshellarg($dbName)
                );
                
                $output = shell_exec($createDbCommand);
                
                // Grant privileges
                $grantCommand = sprintf(
                    'docker-compose exec -T mysql mysql -u root -proot -e "GRANT ALL PRIVILEGES ON %s.* TO \'%s\'@\'%%\'; FLUSH PRIVILEGES;" 2>&1',
                    escapeshellarg($dbName),
                    $normalUser
                );
                
                shell_exec($grantCommand);
                
                // Verify
                $checkCommand = sprintf(
                    'docker-compose exec -T mysql mysql -u root -proot -e "SHOW DATABASES LIKE \'%s\'" 2>&1',
                    $dbName
                );
                
                $checkOutput = shell_exec($checkCommand);
                
                if ($checkOutput && strpos($checkOutput, $dbName) !== false) {
                    $this->line('   ✓ Database created via Docker MySQL command');
                    $this->line('   ✓ Granted privileges to user: ' . $normalUser);
                    return true;
                }
            }
            
            return false;
        } catch (\Exception $e) {
            $this->error('   ✗ Alternative method failed: ' . $e->getMessage());
            return false;
        }
    }

    private function updateEnvDatabase(string $dbName): void
    {
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);

        if (preg_match('/^DB_DATABASE=/m', $envContent)) {
            $envContent = preg_replace(
                '/^DB_DATABASE=.*/m',
                'DB_DATABASE=' . $dbName,
                $envContent
            );
        } else {
            $envContent = preg_replace(
                '/^(DB_CONNECTION=.*)/m',
                "$1\nDB_DATABASE=" . $dbName,
                $envContent
            );
        }

        file_put_contents($envFile, $envContent);
        $this->line('   ✓ Updated .env file: DB_DATABASE=' . $dbName);
        
        $this->newLine();
        $this->line('   Database configuration:');
        $this->line('   • Host: ' . env('DB_HOST'));
        $this->line('   • Database: ' . $dbName);
        $this->line('   • Username: ' . env('DB_USERNAME'));
    }

    private function reloadDatabaseConfig(): void
    {
        // Clear all cached config
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        
        // Purge all database connections
        DB::purge();
        
        // Clear config repository
        $this->laravel['config']->set('database.connections.mysql.database', env('DB_DATABASE'));
        
        // Get fresh database name from .env
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);
        preg_match('/^DB_DATABASE=(.*)$/m', $envContent, $matches);
        $newDbName = $matches[1] ?? env('DB_DATABASE');
        
        // Force set the database config
        config(['database.connections.mysql.database' => $newDbName]);
        
        // Reconnect
        DB::reconnect('mysql');
        
        // Verify connection
        try {
            $dbName = DB::connection()->getDatabaseName();
            $this->line('   ✓ Database configuration reloaded');
            $this->line('   ✓ Connected to database: ' . $dbName);
            
            if ($dbName !== $newDbName) {
                $this->warn('   ⚠️  Warning: Connected to "' . $dbName . '" but expected "' . $newDbName . '"');
            }
        } catch (\Exception $e) {
            $this->warn('   ⚠️  Could not verify database connection: ' . $e->getMessage());
        }
    }

    private function createDefaultAdmin(): void
    {
        try {
            $email = 'admin@' . (parse_url(config('app.url'), PHP_URL_HOST) ?? 'admin.com');
            
            // Check if admin already exists
            $existingAdmin = User::where('email', $email)->first();
            
            if ($existingAdmin) {
                $this->warn('   ⚠️  Admin user already exists: ' . $email);
                $this->line('   Use: php artisan user:password ' . $email . ' to reset password');
                return;
            }
            
            $password = Str::random(16);
            
            $admin = User::create([
                'name' => 'Administrator',
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);

            $this->adminCredentials = [
                'email' => $admin->email,
                'password' => $password,
                'showPassword' => true,
            ];

            $this->line('   ✓ Admin user created with random password');
        } catch (\Exception $e) {
            $this->warn('   ⚠️  Could not create admin user: ' . $e->getMessage());
        }
    }

    private function createCustomAdmin(): void
    {
        try {
            $this->newLine();
            $name = $this->ask('Admin name', 'Administrator');
            $email = $this->ask('Admin email', 'admin@admin.com');
            
            // Check if user already exists
            $existingUser = User::where('email', $email)->first();
            
            if ($existingUser) {
                $this->warn('   ⚠️  User with email ' . $email . ' already exists!');
                
                if ($this->confirm('Update existing user password instead?', true)) {
                    $useRandomPassword = $this->confirm('Generate random password?', false);
                    
                    if ($useRandomPassword) {
                        $password = Str::random(16);
                    } else {
                        $password = $this->secret('New password (min 8 characters)');
                        if (strlen($password) < 8) {
                            $this->error('Password must be at least 8 characters!');
                            $password = Str::random(16);
                            $this->warn('Using random password instead');
                            $useRandomPassword = true;
                        }
                    }
                    
                    $existingUser->password = Hash::make($password);
                    $existingUser->name = $name;
                    $existingUser->save();
                    
                    $this->adminCredentials = [
                        'email' => $existingUser->email,
                        'password' => $useRandomPassword ? $password : '***hidden***',
                        'showPassword' => $useRandomPassword,
                    ];
                    
                    $this->newLine();
                    $this->line('   ✓ User password updated successfully');
                    
                    if ($useRandomPassword) {
                        $this->warn('   ⚠️  Save the password shown in summary below!');
                    }
                } else {
                    $this->line('   ⏭️  Skipping user creation');
                }
                
                return;
            }
            
            $useRandomPassword = $this->confirm('Generate random password?', false);
            
            if ($useRandomPassword) {
                $password = Str::random(16);
            } else {
                $password = $this->secret('Admin password (min 8 characters)');
                if (strlen($password) < 8) {
                    $this->error('Password must be at least 8 characters!');
                    $password = Str::random(16);
                    $this->warn('Using random password instead');
                    $useRandomPassword = true;
                }
            }

            $admin = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);

            $this->adminCredentials = [
                'email' => $admin->email,
                'password' => $useRandomPassword ? $password : '***hidden***',
                'showPassword' => $useRandomPassword,
            ];

            $this->newLine();
            $this->line('   ✓ Admin user created successfully');
            
            if ($useRandomPassword) {
                $this->warn('   ⚠️  Save the password shown in summary below!');
            }
        } catch (\Exception $e) {
            $this->error('   ✗ Failed to create admin user: ' . $e->getMessage());
        }
    }

    private function displaySummary(): void
    {
        $this->newLine();
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('✅ Project Setup Completed Successfully!');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->newLine();
        $this->line('🌐 Application URL: ' . config('app.url'));
        $this->line('💾 Database: ' . config('database.connections.mysql.database'));
        
        if (!empty($this->adminCredentials)) {
            $this->newLine();
            $this->line('👤 Admin Login Credentials:');
            $this->line('   📧 Email: ' . $this->adminCredentials['email']);
            
            if (isset($this->adminCredentials['showPassword']) && $this->adminCredentials['showPassword']) {
                $this->line('   🔒 Password: ' . $this->adminCredentials['password']);
                $this->newLine();
                $this->warn('   ⚠️  IMPORTANT: Save this password now! It won\'t be shown again.');
            } else {
                $this->line('   🔒 Password: ' . ($this->adminCredentials['password'] ?? 'As configured'));
            }
        }
        
        $this->newLine();
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->newLine();
        
        $this->info('💡 Next steps:');
        $this->line('   • Start development server: php artisan serve');
        $this->line('   • Create more users: php artisan user:create');
        $this->line('   • Check system health: php artisan project:health');
        $this->line('   • Backup database: php artisan db:backup --compress');
        $this->newLine();
    }
}
