<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\Conversions\Manipulations;

class HeroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Hero::with('media');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
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

        $heroes = $query->paginate(15)->withQueryString();

        return view('admin.heroes.index', compact('heroes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.heroes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:heroes,slug',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240', // 10MB
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure unique slug
            $originalSlug = $validated['slug'];
            $count = 1;
            while (Hero::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count;
                $count++;
            }
        }

        // Set defaults
        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->has('is_active');

        $hero = Hero::create($validated);

        // Handle image upload
        if ($request->hasFile('hero_image')) {
            $file = $request->file('hero_image');
            $mimeType = $file->getMimeType();
            $isWebP = $mimeType === 'image/webp';
            
            $mediaAdder = $hero->addMediaFromRequest('hero_image');
            
            // If not WebP, convert original to WebP
            if (!$isWebP) {
                $mediaAdder->performManipulations(function (Manipulations $manipulations) {
                    $manipulations->format('webp');
                });
            }
            
            $mediaAdder->toMediaCollection('hero_image');
        }

        return redirect()
            ->route('admin.heroes.index')
            ->with('success', 'Hero slide created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hero $hero)
    {
        return view('admin.heroes.edit', compact('hero'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hero $hero)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('heroes', 'slug')->ignore($hero->id),
            ],
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240', // 10MB
        ]);

        // Generate slug if not provided or changed
        if (empty($validated['slug']) || $validated['slug'] !== $hero->slug) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure unique slug (excluding current hero)
            $originalSlug = $validated['slug'];
            $count = 1;
            while (Hero::where('slug', $validated['slug'])
                ->where('id', '!=', $hero->id)
                ->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count;
                $count++;
            }
        }

        $validated['is_active'] = $request->has('is_active');

        $hero->update($validated);

        // Handle image replacement
        if ($request->hasFile('hero_image')) {
            // Delete old image
            $hero->clearMediaCollection('hero_image');
            
            // Add new image
            $file = $request->file('hero_image');
            $mimeType = $file->getMimeType();
            $isWebP = $mimeType === 'image/webp';
            
            $mediaAdder = $hero->addMediaFromRequest('hero_image');
            
            // If not WebP, convert original to WebP
            if (!$isWebP) {
                $mediaAdder->performManipulations(function (Manipulations $manipulations) {
                    $manipulations->format('webp');
                });
            }
            
            $mediaAdder->toMediaCollection('hero_image');
        }

        return redirect()
            ->route('admin.heroes.index')
            ->with('success', 'Hero slide updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hero $hero)
    {
        $hero->clearMediaCollection('hero_image');
        $hero->delete();

        return redirect()
            ->route('admin.heroes.index')
            ->with('success', 'Hero slide deleted successfully.');
    }
}
