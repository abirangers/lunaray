<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Hero;
use App\Models\Article;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        // Get active heroes ordered
        $heroes = Hero::active()
            ->ordered()
            ->get();

        // Get active categories ordered
        $categories = ProductCategory::active()
            ->ordered()
            ->get();

        // Get active products grouped by category
        $products = collect();

        foreach ($categories as $category) {
            $categoryProducts = Product::with('category')
                ->where('product_category_id', $category->id)
                ->active()
                ->ordered()
                ->get();

            $products = $products->merge($categoryProducts);
        }

        // Get featured articles for Beautyversity section
        $articles = Article::published()
            ->featured()
            ->with(['author', 'categories'])
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('home', compact('heroes', 'categories', 'products', 'articles'));
    }
}
