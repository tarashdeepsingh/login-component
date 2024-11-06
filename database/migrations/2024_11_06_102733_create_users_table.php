<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('users');
        // Retrieve fields from the config file
        $fields = config('custom_login.fields');

        // Create the 'users' table dynamically based on config fields
        Schema::create('users', function (Blueprint $table) use ($fields) {
            $table->id();
            
            foreach ($fields as $fieldName => $fieldDetails) {
                $type = $fieldDetails['type'];
                $isRequired = $fieldDetails['required'] ?? false;

                // Add field based on type from config
                $column = $table->$type($fieldName);

                // Set field to nullable if not required
                if (!$isRequired) {
                    $column->nullable();
                }
            }

            // Additional default fields
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // Create the 'password_reset_tokens' table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Create the 'sessions' table
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
