<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            [
                'name' => 'Skincare',
                'description' => 'Tips and tricks for healthy, glowing skin',
                'color' => '#FF6B6B',
                'is_active' => true,
            ],
            [
                'name' => 'Makeup',
                'description' => 'Makeup tutorials and beauty techniques',
                'color' => '#4ECDC4',
                'is_active' => true,
            ],
            [
                'name' => 'Hair Care',
                'description' => 'Hair care tips and styling guides',
                'color' => '#45B7D1',
                'is_active' => true,
            ],
            [
                'name' => 'Beauty Trends',
                'description' => 'Latest beauty trends and industry news',
                'color' => '#96CEB4',
                'is_active' => true,
            ],
            [
                'name' => 'Product Reviews',
                'description' => 'Honest reviews of beauty products',
                'color' => '#FFEAA7',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::updateOrCreate(
                ['slug' => Str::slug($categoryData['name'])],
                [
                    'name' => $categoryData['name'],
                    'description' => $categoryData['description'],
                    'color' => $categoryData['color'],
                    'is_active' => $categoryData['is_active'],
                ]
            );
        }

        // Get a content manager user
        $contentManager = User::whereHas('roles', function ($query) {
            $query->where('name', 'content_manager');
        })->first();

        if (!$contentManager) {
            // Create a content manager if none exists
            $contentManager = User::create([
                'name' => 'Content Manager',
                'email' => 'content@lunaray.com',
                'password' => bcrypt('password'),
            ]);
            $contentManager->assignRole('content_manager');
        }

        // Create sample articles
        $articles = [
            [
                'title' => '10 Essential Skincare Tips for Healthy Skin',
                'excerpt' => 'Discover the fundamental skincare practices that will transform your skin and give you that natural glow you\'ve always wanted.',
                'content' => '<h2>Introduction</h2><p>Taking care of your skin is one of the most important things you can do for your overall health and appearance. In this comprehensive guide, we\'ll explore 10 essential skincare tips that will help you achieve healthy, glowing skin.</p><h2>1. Cleanse Twice Daily</h2><p>Cleansing your skin twice daily is crucial for removing dirt, oil, and makeup that can clog pores and cause breakouts. Use a gentle cleanser that\'s appropriate for your skin type.</p><h2>2. Moisturize Regularly</h2><p>Moisturizing helps maintain your skin\'s natural barrier and prevents dryness. Choose a moisturizer that suits your skin type and apply it morning and night.</p><h2>3. Use Sunscreen Daily</h2><p>Protecting your skin from harmful UV rays is essential for preventing premature aging and skin cancer. Use a broad-spectrum sunscreen with at least SPF 30.</p>',
                'is_featured' => true,
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'view_count' => 1250,
            ],
            [
                'title' => 'The Ultimate Makeup Guide for Beginners',
                'excerpt' => 'Learn the basics of makeup application with our comprehensive beginner\'s guide. From foundation to eyeshadow, we\'ve got you covered.',
                'content' => '<h2>Getting Started with Makeup</h2><p>Makeup can be intimidating for beginners, but with the right guidance, anyone can learn to apply it beautifully. This guide will walk you through the basics.</p><h2>Essential Makeup Tools</h2><p>Before you start applying makeup, you\'ll need the right tools. Here are the essentials every beginner should have:</p><ul><li>Foundation brush or beauty sponge</li><li>Eyeshadow brushes</li><li>Mascara wand</li><li>Lip brush</li></ul><h2>Foundation Application</h2><p>Foundation is the base of your makeup look. Choose a shade that matches your skin tone and apply it evenly for a natural finish.</p>',
                'is_featured' => true,
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'view_count' => 980,
            ],
            [
                'title' => 'Hair Care Routine for Different Hair Types',
                'excerpt' => 'Understanding your hair type is the first step to achieving healthy, beautiful hair. Learn how to care for straight, curly, and wavy hair.',
                'content' => '<h2>Understanding Hair Types</h2><p>Different hair types require different care routines. Whether you have straight, curly, or wavy hair, there are specific techniques and products that will work best for you.</p><h2>Straight Hair Care</h2><p>Straight hair tends to be oily at the roots and dry at the ends. Use a clarifying shampoo and lightweight conditioner to maintain balance.</p><h2>Curly Hair Care</h2><p>Curly hair needs extra moisture and gentle handling. Use sulfate-free shampoos and leave-in conditioners to keep curls defined and healthy.</p>',
                'is_featured' => false,
                'status' => 'published',
                'published_at' => now()->subDays(7),
                'view_count' => 750,
            ],
            [
                'title' => '2024 Beauty Trends: What\'s In and What\'s Out',
                'excerpt' => 'Stay ahead of the curve with our comprehensive guide to the hottest beauty trends of 2024. From skincare to makeup, discover what\'s trending now.',
                'content' => '<h2>Skincare Trends 2024</h2><p>This year, we\'re seeing a focus on natural, sustainable beauty products and routines. Here are the top skincare trends to watch:</p><h2>Makeup Trends</h2><p>From bold lips to natural glow, 2024 makeup trends are all about self-expression and confidence.</p><h2>Hair Trends</h2><p>Hair trends this year include everything from bold colors to natural textures and everything in between.</p>',
                'is_featured' => false,
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'view_count' => 1200,
            ],
            [
                'title' => 'Product Review: Best Vitamin C Serums of 2024',
                'excerpt' => 'We\'ve tested the top vitamin C serums on the market to help you find the perfect one for your skincare routine.',
                'content' => '<h2>Why Vitamin C?</h2><p>Vitamin C is a powerful antioxidant that helps brighten skin, reduce dark spots, and protect against environmental damage.</p><h2>Our Top Picks</h2><p>After extensive testing, we\'ve narrowed down the best vitamin C serums available in 2024.</p><h2>How to Use Vitamin C</h2><p>Learn the proper way to incorporate vitamin C into your skincare routine for maximum benefits.</p>',
                'is_featured' => false,
                'status' => 'published',
                'published_at' => now()->subDays(12),
                'view_count' => 890,
            ],
        ];

        $categoryIds = Category::pluck('id')->toArray();

        foreach ($articles as $index => $articleData) {
            $article = Article::create([
                'title' => $articleData['title'],
                'slug' => Str::slug($articleData['title']),
                'excerpt' => $articleData['excerpt'],
                'content' => $articleData['content'],
                'is_featured' => $articleData['is_featured'],
                'status' => $articleData['status'],
                'published_at' => $articleData['published_at'],
                'view_count' => $articleData['view_count'],
                'author_id' => $contentManager->id,
            ]);

            // Attach random categories to each article
            $randomCategories = collect($categoryIds)->random(rand(1, 3));
            $article->categories()->attach($randomCategories);
        }
    }
}