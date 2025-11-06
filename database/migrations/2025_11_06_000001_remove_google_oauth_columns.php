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
        // Set temporary password for users with NULL password (Google OAuth users)
        \DB::table('users')
            ->whereNull('password')
            ->update(['password' => \Hash::make(\Str::random(32))]);

        $connection = Schema::getConnection();
        $driver = $connection->getDriverName();

        // Handle SQLite separately as it has limitations with dropping columns
        if ($driver === 'sqlite') {
            // For SQLite, drop the unique index first
            try {
                $connection->statement('DROP INDEX IF EXISTS users_google_id_unique');
            } catch (\Exception $e) {
                // Index might not exist or have different name, continue
            }
        }

        Schema::table('users', function (Blueprint $table) use ($driver) {
            // Drop unique index first for non-SQLite databases
            if ($driver !== 'sqlite' && Schema::hasColumn('users', 'google_id')) {
                $table->dropUnique(['google_id']);
            }
        });

        // Drop columns
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'google_id')) {
                $table->dropColumn('google_id');
            }
            if (Schema::hasColumn('users', 'google_token')) {
                $table->dropColumn('google_token');
            }
            if (Schema::hasColumn('users', 'google_refresh_token')) {
                $table->dropColumn('google_refresh_token');
            }
        });

        // Make password required (was nullable for Google OAuth users)
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'password')) {
                $table->string('password')->nullable(false)->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable()->unique();
            $table->text('google_token')->nullable();
            $table->text('google_refresh_token')->nullable();
            $table->string('password')->nullable()->change();
        });
    }
};
