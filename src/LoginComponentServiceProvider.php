<?php

namespace Avalon\LrvLogin;

use Illuminate\Support\ServiceProvider;
use Avalon\LrvLogin\Observers\UserObserver;
use App\Models\User;

class LoginComponentServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Merge package configuration with app's configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/custom_login.php', 'custom_login');
    }

    public function boot()
    {
        User::observe(UserObserver::class);

        // Publish configuration file
        $this->publishes([
            __DIR__ . '/../config/custom_login.php' => config_path('custom_login.php'),
        ], 'config');
        copy(__DIR__ . '/../config/custom_login.php', config_path('custom_login.php'));

        // Publish views
        // $this->publishes([
        //     __DIR__ . '/../resources/views/auth' => resource_path('views/vendor/lrv_login/auth'),
        // ], 'views');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'lrv_login');

        // Check if the migration already exists
        $existingMigrationPath = database_path('migrations/0001_01_01_000000_create_users_table.php');
        if (file_exists($existingMigrationPath)) {
            // Delete it before publishing package migration
            unlink($existingMigrationPath); // This will delete the existing migration file
        }
        // Publish the migration from your package to the application's migration directory
        $this->publishes([
            __DIR__.'/database/migrations/0001_01_01_000000_create_users_table.php' => $existingMigrationPath,
        ], 'migrations');
        copy(__DIR__ . '/../database/migrations/0001_01_01_000000_create_users_table.php', $existingMigrationPath);
    }
}
