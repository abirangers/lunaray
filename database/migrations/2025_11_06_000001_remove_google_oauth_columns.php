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

        Schema::table('users', function (Blueprint $table) {
            // Check if columns exist before dropping
            if (Schema::hasColumn('users', 'google_id')) {
                $table->dropColumn('google_id');
            }
            if (Schema::hasColumn('users', 'google_token')) {
                $table->dropColumn('google_token');
            }
            if (Schema::hasColumn('users', 'google_refresh_token')) {
                $table->dropColumn('google_refresh_token');
            }

            // Make password required (was nullable for Google OAuth users)
            $table->string('password')->nullable(false)->change();
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
