<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Skincare',
                'slug' => 'skincare',
                'description' => 'Produk perawatan kulit untuk menjaga kesehatan dan kecantikan kulit wajah.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Bodycare',
                'slug' => 'bodycare',
                'description' => 'Produk perawatan tubuh untuk kulit halus dan sehat.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Haircare',
                'slug' => 'haircare',
                'description' => 'Produk perawatan rambut untuk rambut sehat dan indah.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Babycare',
                'slug' => 'babycare',
                'description' => 'Produk perawatan khusus untuk kulit bayi yang sensitif.',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Mommycare',
                'slug' => 'mommycare',
                'description' => 'Produk perawatan khusus untuk ibu hamil dan menyusui.',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Mancare',
                'slug' => 'mancare',
                'description' => 'Produk perawatan khusus untuk pria.',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Therapeutic',
                'slug' => 'therapeutic',
                'description' => 'Produk dengan manfaat terapi untuk perawatan khusus.',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Decorative',
                'slug' => 'decorative',
                'description' => 'Produk kosmetik dekoratif untuk kecantikan.',
                'order' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Perfume',
                'slug' => 'perfume',
                'description' => 'Produk parfum dan pewangi.',
                'order' => 9,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
