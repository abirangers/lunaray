<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get Skincare category (first category from seeder)
        $skincare = ProductCategory::where('slug', 'skincare')->first();
        
        if (!$skincare) {
            $this->command->error('Product categories must be seeded first!');
            return;
        }

        $products = [
            [
                'product_category_id' => $skincare->id,
                'name' => 'Body Wash',
                'slug' => 'body-wash',
                'description' => 'Sabun mandi dengan formula lembut yang membersihkan kulit tanpa membuatnya kering.',
                'features' => [
                    'pH Balanced',
                    'Gentle Formula',
                    'Moisturizing',
                    'Suitable for all skin types',
                ],
                'order' => 1,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'product_category_id' => $skincare->id,
                'name' => 'Facial Mask',
                'slug' => 'facial-mask',
                'description' => 'Masker wajah yang menutrisi dan mencerahkan kulit wajah.',
                'features' => [
                    'Deep Cleansing',
                    'Brightening',
                    'Hydrating',
                    'Natural Ingredients',
                ],
                'order' => 2,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'product_category_id' => $skincare->id,
                'name' => 'Facial Scrub',
                'slug' => 'facial-scrub',
                'description' => 'Scrub wajah untuk mengangkat sel kulit mati dan membuat kulit lebih halus.',
                'features' => [
                    'Exfoliating',
                    'Smooth Skin',
                    'Pore Minimizing',
                    'Gentle Beads',
                ],
                'order' => 3,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'product_category_id' => $skincare->id,
                'name' => 'Body Serum',
                'slug' => 'body-serum',
                'description' => 'Serum tubuh yang melembapkan dan mencerahkan kulit secara menyeluruh.',
                'features' => [
                    'Deep Hydration',
                    'Brightening',
                    'Lightweight Formula',
                    'Fast Absorbing',
                ],
                'order' => 4,
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }

        $this->command->info('Default products seeded successfully!');
    }
}
