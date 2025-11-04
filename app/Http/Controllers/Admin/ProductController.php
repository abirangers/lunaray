<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\Conversions\Manipulations;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'media']);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('product_category_id', $request->category);
        }

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

        $products = $query->paginate(15)->withQueryString();
        $categories = ProductCategory::active()->ordered()->withCount('products')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::active()->ordered()->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure unique slug
            $originalSlug = $validated['slug'];
            $count = 1;
            while (Product::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count;
                $count++;
            }
        }

        // Parse features JSON
        if (!empty($validated['features'])) {
            try {
                $features = json_decode($validated['features'], true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $validated['features'] = $features;
                } else {
                    // If not valid JSON, treat as comma-separated list
                    $validated['features'] = array_map('trim', explode(',', $validated['features']));
                }
            } catch (\Exception $e) {
                $validated['features'] = array_map('trim', explode(',', $validated['features']));
            }
        }

        // Set defaults
        // Auto-assign to last position in category
        $maxOrder = Product::where('product_category_id', $validated['product_category_id'])->max('order') ?? 0;
        $validated['order'] = $maxOrder + 1;
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        $product = Product::create($validated);

        // Handle image upload
        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $mimeType = $file->getMimeType();
            $isWebP = $mimeType === 'image/webp';
            
            $mediaAdder = $product->addMediaFromRequest('product_image');
            
            // If not WebP, convert original to WebP
            if (!$isWebP) {
                $mediaAdder->performManipulations(function (Manipulations $manipulations) {
                    $manipulations->format('webp');
                });
            }
            
            $mediaAdder->toMediaCollection('product_image');
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load('category');
        $categories = ProductCategory::active()->ordered()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($product->id),
            ],
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure unique slug (excluding current product)
            $originalSlug = $validated['slug'];
            $count = 1;
            while (Product::where('slug', $validated['slug'])
                ->where('id', '!=', $product->id)
                ->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count;
                $count++;
            }
        }

        // Parse features JSON
        if (!empty($validated['features'])) {
            try {
                $features = json_decode($validated['features'], true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $validated['features'] = $features;
                } else {
                    $validated['features'] = array_map('trim', explode(',', $validated['features']));
                }
            } catch (\Exception $e) {
                $validated['features'] = array_map('trim', explode(',', $validated['features']));
            }
        }

        // Keep existing order (don't change it during update)
        unset($validated['order']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        $product->update($validated);

        // Handle image upload/replacement
        if ($request->hasFile('product_image')) {
            // Clear old image
            $product->clearMediaCollection('product_image');
            
            $file = $request->file('product_image');
            $mimeType = $file->getMimeType();
            $isWebP = $mimeType === 'image/webp';
            
            $mediaAdder = $product->addMediaFromRequest('product_image');
            
            // If not WebP, convert original to WebP
            if (!$isWebP) {
                $mediaAdder->performManipulations(function (Manipulations $manipulations) {
                    $manipulations->format('webp');
                });
            }
            
            $mediaAdder->toMediaCollection('product_image');
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete associated media
        $product->clearMediaCollection('product_image');
        
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Handle bulk actions.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:feature,unfeature,activate,deactivate,delete',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
        ]);

        $products = Product::whereIn('id', $request->products)->get();

        switch ($request->action) {
            case 'feature':
                Product::whereIn('id', $request->products)->update(['is_featured' => true]);
                $message = count($request->products) . ' products marked as featured.';
                break;

            case 'unfeature':
                Product::whereIn('id', $request->products)->update(['is_featured' => false]);
                $message = count($request->products) . ' products unmarked as featured.';
                break;

            case 'activate':
                Product::whereIn('id', $request->products)->update(['is_active' => true]);
                $message = count($request->products) . ' products activated.';
                break;

            case 'deactivate':
                Product::whereIn('id', $request->products)->update(['is_active' => false]);
                $message = count($request->products) . ' products deactivated.';
                break;

            case 'delete':
                // Delete media for all products
                foreach ($products as $product) {
                    $product->clearMediaCollection('product_image');
                }
                
                Product::whereIn('id', $request->products)->delete();
                $message = count($request->products) . ' products deleted.';
                break;
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', $message);
    }

    /**
     * Reorder products within a category.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:product_categories,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.order' => 'required|integer|min:1',
        ]);

        DB::transaction(function() use ($request) {
            foreach ($request->products as $item) {
                Product::where('id', $item['id'])
                    ->where('product_category_id', $request->category_id)
                    ->update(['order' => $item['order']]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Products reordered successfully.'
        ]);
    }

    /**
     * Move product up in order.
     */
    public function moveUp(Product $product)
    {
        $previousProduct = Product::where('product_category_id', $product->product_category_id)
            ->where('order', '<', $product->order)
            ->orderBy('order', 'desc')
            ->first();

        if ($previousProduct) {
            DB::transaction(function() use ($product, $previousProduct) {
                $tempOrder = $product->order;
                $product->update(['order' => $previousProduct->order]);
                $previousProduct->update(['order' => $tempOrder]);
            });
        }

        return response()->json([
            'success' => true,
            'message' => 'Product moved up successfully.'
        ]);
    }

    /**
     * Move product down in order.
     */
    public function moveDown(Product $product)
    {
        $nextProduct = Product::where('product_category_id', $product->product_category_id)
            ->where('order', '>', $product->order)
            ->orderBy('order', 'asc')
            ->first();

        if ($nextProduct) {
            DB::transaction(function() use ($product, $nextProduct) {
                $tempOrder = $product->order;
                $product->update(['order' => $nextProduct->order]);
                $nextProduct->update(['order' => $tempOrder]);
            });
        }

        return response()->json([
            'success' => true,
            'message' => 'Product moved down successfully.'
        ]);
    }
}
