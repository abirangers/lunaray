<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles first
        $this->call(RoleSeeder::class);
        
        // Seed permissions and assign them to roles
        $this->call(PermissionSeeder::class);

        // Seed staff users with roles
        $this->call(StaffSeeder::class);

        // Seed chatbot configurations
        $this->call(ChatbotConfigurationSeeder::class);

        // Seed articles and categories
        $this->call(ArticleSeeder::class);

        // Create additional test users if needed
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
