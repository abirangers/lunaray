<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\ProductCategory;

echo "=== Testing New Logic: 4 Products Per Category ===\n\n";

$categories = ProductCategory::where('is_active', true)
    ->orderBy('order')
    ->orderBy('name')
    ->get();

echo "Active Categories: " . $categories->count() . "\n\n";

$products = collect();

foreach ($categories as $category) {
    echo "Category: {$category->name} (ID: {$category->id})\n";
    
    $categoryProducts = Product::with('category')
        ->where('product_category_id', $category->id)
        ->where('is_active', true)
        ->orderBy('order')
        ->orderBy('name')
        ->limit(4)
        ->get();
    
    echo "  Products in this category: {$categoryProducts->count()}\n";
    
    foreach ($categoryProducts as $product) {
        echo "    - {$product->name} (order: {$product->order})\n";
    }
    
    $products = $products->merge($categoryProducts);
    echo "\n";
}

echo "=== Total Products to Display: {$products->count()} ===\n";

