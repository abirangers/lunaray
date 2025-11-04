<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hero;
use Illuminate\Support\Facades\Storage;

class HeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $heroes = [
            [
                'name' => 'Main Hero Banner',
                'slug' => 'main-hero-banner',
                'order' => 1,
                'is_active' => true,
            ],
        ];

        foreach ($heroes as $hero) {
            $createdHero = Hero::updateOrCreate(
                ['slug' => $hero['slug']],
                $hero
            );

            // Add hero image if it doesn't exist
            if (!$createdHero->hasMedia('hero_image')) {
                $imagePath = public_path('images/lunaray-landing/newbackground2.webp');
                
                if (file_exists($imagePath)) {
                    $createdHero->addMedia($imagePath)
                        ->toMediaCollection('hero_image');
                }
            }
        }

        $this->command->info('Default heroes seeded successfully!');
    }
}
