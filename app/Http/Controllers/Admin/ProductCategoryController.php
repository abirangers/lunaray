<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProductCategory::withCount('products');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortField = $request->get('sort', 'order');
        $sortDirection = $request->get('direction', 'asc');
        
        if (in_array($sortField, ['name', 'order', 'created_at'])) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->orderBy('order')->orderBy('name');
        }

        $categories = $query->paginate(15)->withQueryString();

        return view('admin.product-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100|unique:product_categories,slug',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure unique slug
            $originalSlug = $validated['slug'];
            $count = 1;
            while (ProductCategory::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count;
                $count++;
            }
        }

        // Set defaults
        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->has('is_active');

        $category = ProductCategory::create($validated);

        return redirect()
            ->route('admin.product-categories.index')
            ->with('success', 'Product category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        $productCategory->loadCount('products');
        return view('admin.product-categories.show', compact('productCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        return view('admin.product-categories.edit', compact('productCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('product_categories', 'slug')->ignore($productCategory->id),
            ],
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure unique slug (excluding current category)
            $originalSlug = $validated['slug'];
            $count = 1;
            while (ProductCategory::where('slug', $validated['slug'])
                ->where('id', '!=', $productCategory->id)
                ->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count;
                $count++;
            }
        }

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->has('is_active');

        $productCategory->update($validated);

        return redirect()
            ->route('admin.product-categories.index')
            ->with('success', 'Product category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        // Check if category has products
        if ($productCategory->products()->count() > 0) {
            return redirect()
                ->route('admin.product-categories.index')
                ->with('error', 'Cannot delete category that has products. Please reassign or delete products first.');
        }

        $productCategory->delete();

        return redirect()
            ->route('admin.product-categories.index')
            ->with('success', 'Product category deleted successfully.');
    }

    /**
     * Handle bulk actions.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'categories' => 'required|array',
            'categories.*' => 'exists:product_categories,id',
        ]);

        $categories = ProductCategory::whereIn('id', $request->categories)->get();

        switch ($request->action) {
            case 'activate':
                ProductCategory::whereIn('id', $request->categories)->update(['is_active' => true]);
                $message = count($request->categories) . ' categories activated successfully.';
                break;

            case 'deactivate':
                ProductCategory::whereIn('id', $request->categories)->update(['is_active' => false]);
                $message = count($request->categories) . ' categories deactivated successfully.';
                break;

            case 'delete':
                // Check for categories with products
                $categoriesWithProducts = $categories->filter(function($category) {
                    return $category->products()->count() > 0;
                });

                if ($categoriesWithProducts->count() > 0) {
                    return redirect()
                        ->route('admin.product-categories.index')
                        ->with('error', 'Some categories have products and cannot be deleted.');
                }

                ProductCategory::whereIn('id', $request->categories)->delete();
                $message = count($request->categories) . ' categories deleted successfully.';
                break;
        }

        return redirect()
            ->route('admin.product-categories.index')
            ->with('success', $message);
    }
}
