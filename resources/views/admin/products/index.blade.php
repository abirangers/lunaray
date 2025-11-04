@extends('layouts.admin')

@section('title', 'Products')
@section('pageTitle', 'Products Management')
@section('pageDescription', 'Create, edit, and manage your product showcase')

@section('content')

    <!-- Action Buttons -->
    <div class="mb-8">
        <div class="flex items-center justify-end gap-3">
            <button @click="$dispatch('open-reorder-modal')" class="btn-modern btn-modern-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                </svg>
                Reorder Products
            </button>
            <a href="{{ route('admin.products.create') }}" class="btn-modern btn-modern-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create Product
            </a>
        </div>
    </div>

    <!-- Modern Filters -->
    <div class="card-modern mb-6">
        <div class="card-modern-header">
            <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Search & Filters</h2>
            <p class="text-sm text-neutral-600 dark:text-neutral-400">Find products with advanced filtering options</p>
        </div>
        <div class="card-modern-body">
            <form method="GET" class="space-y-6">
                <!-- Search and Quick Filters -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Modern Search -->
                    <div>
                        <label for="search" class="form-modern-label">Search Products</label>
                        <div class="input-group-modern">
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                   placeholder="Search by name..." 
                                   class="input-group-modern-input">
                            <div class="input-group-modern-icon">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="category" class="form-modern-label">Category</label>
                        <select name="category" id="category" class="form-modern">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->products_count ?? 0 }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="form-modern-label">Status</label>
                        <select name="status" id="status" class="form-modern">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label for="sort" class="form-modern-label">Sort By</label>
                        <select name="sort" id="sort" class="form-modern">
                            <option value="order" {{ request('sort') == 'order' ? 'selected' : '' }}>Display Order</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                        </select>
                    </div>
                </div>

                <!-- Modern Advanced Options -->
                <div class="flex flex-wrap items-center gap-6 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="featured" id="featured" value="1" {{ request('featured') ? 'checked' : '' }} 
                               class="w-4 h-4 text-primary-600 bg-neutral-100 border-neutral-300 rounded focus:ring-primary-500 focus:ring-2">
                        <label for="featured" class="text-sm font-medium text-neutral-700 dark:text-neutral-300">
                            Featured Only
                        </label>
                    </div>

                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="has_image" id="has_image" value="1" {{ request('has_image') ? 'checked' : '' }} 
                               class="w-4 h-4 text-primary-600 bg-neutral-100 border-neutral-300 rounded focus:ring-primary-500 focus:ring-2">
                        <label for="has_image" class="text-sm font-medium text-neutral-700 dark:text-neutral-300">
                            With Image
                        </label>
                    </div>
                </div>

                <!-- Modern Filter Actions -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                    <button type="submit" class="btn-modern btn-modern-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn-modern btn-modern-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear Filters
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Modern Products Table -->
    <div class="card-modern">
        <div class="card-modern-header">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Products</h2>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">{{ $products->total() }} products found</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto" x-data="{ 
            selectedProducts: [], 
            selectAll: false,
            toggleAll() {
                if (this.selectAll) {
                    this.selectedProducts = @json($products->pluck('id'));
                } else {
                    this.selectedProducts = [];
                }
            }
        }">
            <!-- Modern Bulk Actions -->
            <div x-show="selectedProducts.length > 0" 
                 x-cloak
                 class="mb-4 p-4 bg-neutral-50 dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700">
                <form method="POST" action="{{ route('admin.products.bulk-action') }}" 
                      @submit.prevent="if(confirm('Are you sure you want to perform this action?')) { $el.submit(); }">
                    @csrf
                    <input type="hidden" name="products" :value="JSON.stringify(selectedProducts)">
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">
                                <span x-text="selectedProducts.length"></span> products selected
                            </span>
                            <select name="action" class="form-modern text-sm" required>
                                <option value="">Bulk Actions</option>
                                <option value="feature">Mark as Featured</option>
                                <option value="unfeature">Remove Featured</option>
                                <option value="activate">Activate</option>
                                <option value="deactivate">Deactivate</option>
                                <option value="delete">Delete</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="submit" class="btn-modern btn-modern-primary">
                                Apply
                            </button>
                            <button type="button" @click="selectedProducts = []; selectAll = false" class="btn-modern btn-modern-secondary">
                                Clear
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <table class="table-modern">
                <thead class="table-modern-header">
                    <tr>
                        <th class="table-modern-header-cell w-12">
                            <input type="checkbox" 
                                   x-model="selectAll" 
                                   @change="toggleAll()"
                                   class="w-4 h-4 text-primary-600 bg-neutral-100 border-neutral-300 rounded focus:ring-primary-500 focus:ring-2">
                        </th>
                        <th class="table-modern-header-cell">Product</th>
                        <th class="table-modern-header-cell">Category</th>
                        <th class="table-modern-header-cell">Order</th>
                        <th class="table-modern-header-cell">Status</th>
                        <th class="table-modern-header-cell">Created</th>
                        <th class="table-modern-header-cell">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-modern-body">
                    @forelse($products as $product)
                        <tr class="table-modern-row">
                            <td class="table-modern-cell w-12">
                                <input type="checkbox" 
                                       x-model="selectedProducts" 
                                       value="{{ $product->id }}"
                                       class="w-4 h-4 text-primary-600 bg-neutral-100 border-neutral-300 rounded focus:ring-primary-500 focus:ring-2">
                            </td>
                            <td class="table-modern-cell">
                                <div class="flex items-center space-x-4">
                                    @if($product->hasMedia('product_image'))
                                        <img class="h-12 w-12 rounded-lg object-cover flex-shrink-0" 
                                             src="{{ $product->getFirstMediaUrl('product_image', 'thumb') }}" 
                                             alt="{{ $product->name }}">
                                    @else
                                        <div class="h-12 w-12 rounded-lg bg-gradient-to-br from-primary-100 to-secondary-100 dark:from-primary-900/20 dark:to-secondary-900/20 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-primary-500 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <h3 class="text-sm font-medium text-neutral-900 dark:text-neutral-100 truncate">
                                                {{ $product->name }}
                                            </h3>
                                            @if($product->is_featured)
                                                <span class="badge-modern badge-modern-accent">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                    Featured
                                                </span>
                                            @endif
                                        </div>
                                        @if($product->description)
                                            <p class="text-xs text-neutral-500 dark:text-neutral-400 truncate">{{ Str::limit($product->description, 60) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="table-modern-cell">
                                <span class="badge-modern badge-modern-info">
                                    {{ $product->category->name }}
                                </span>
                            </td>
                            <td class="table-modern-cell">
                                <span class="text-sm text-neutral-600 dark:text-neutral-400">
                                    {{ $product->order }}
                                </span>
                            </td>
                            <td class="table-modern-cell">
                                @if($product->is_active)
                                    <span class="badge-modern badge-modern-success">Active</span>
                                @else
                                    <span class="badge-modern badge-modern-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="table-modern-cell">
                                <span class="text-sm text-neutral-600 dark:text-neutral-400">
                                    {{ $product->created_at->format('M d, Y') }}
                                </span>
                            </td>
                            <td class="table-modern-cell">
                                <div class="flex items-center gap-2">
                                    <button @click="moveProduct({{ $product->id }}, 'up')" 
                                            class="btn-modern btn-modern-sm btn-modern-secondary"
                                            title="Move Up">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    </button>
                                    <button @click="moveProduct({{ $product->id }}, 'down')" 
                                            class="btn-modern btn-modern-sm btn-modern-secondary"
                                            title="Move Down">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="btn-modern btn-modern-sm btn-modern-primary"
                                       title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form method="POST" 
                                          action="{{ route('admin.products.destroy', $product) }}" 
                                          onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn-modern btn-modern-sm btn-modern-danger"
                                                title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="table-modern-cell text-center py-12">
                                <svg class="w-16 h-16 mx-auto mb-4 text-neutral-300 dark:text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-neutral-900 dark:text-neutral-100 mb-2">No products found</h3>
                                <p class="text-neutral-600 dark:text-neutral-400 mb-6">Get started by creating your first product.</p>
                                <a href="{{ route('admin.products.create') }}" class="btn-modern btn-modern-primary">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Create Product
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="card-modern-footer">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">
                        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} products
                    </div>
                    <div>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Reorder Modal -->
    <div x-data="reorderModal()" 
         @open-reorder-modal.window="open()"
         x-show="isOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="close()"></div>
        
        <!-- Modal Content -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white dark:bg-neutral-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[80vh] flex flex-col"
                 @click.away="close()">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">
                            Reorder Products
                        </h3>
                        <button @click="close()" class="text-neutral-400 hover:text-neutral-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Category Selector -->
                <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                    <label class="form-modern-label">Select Category</label>
                    <select x-model="selectedCategory" @change="loadProducts()" class="form-modern">
                        <option value="">Choose a category...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Draggable Product List -->
                <div class="flex-1 overflow-y-auto px-6 py-4">
                    <div x-show="loading" class="text-center py-8">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-primary-500 border-t-transparent"></div>
                    </div>

                    <div x-show="!loading && products.length === 0" class="text-center py-8 text-neutral-500">
                        <p>No products in this category.</p>
                    </div>

                    <div x-show="!loading && products.length > 0" id="sortable-list" class="space-y-2" x-ignore>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700 flex justify-end gap-3">
                    <button @click="close()" class="btn-modern btn-modern-secondary">
                        Cancel
                    </button>
                    <button @click="saveOrder()" :disabled="saving" class="btn-modern btn-modern-primary">
                        <span x-show="!saving">Save Order</span>
                        <span x-show="saving">Saving...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<style>
    [x-cloak] { display: none !important; }
    
    /* Sortable.js classes */
    .sortable-ghost {
        opacity: 0.5;
    }
    
    .sortable-chosen {
        outline: 2px solid rgb(59 130 246);
        outline-offset: -2px;
        background-color: rgb(219 234 254);
    }
    
    .dark .sortable-chosen {
        background-color: rgb(30 58 138);
    }
    
    .sortable-drag {
        opacity: 0.75;
    }
</style>

<script>
// Get all products data for modal
const allProducts = @json($products->items());

function reorderModal() {
    return {
        isOpen: false,
        selectedCategory: '',
        products: [],
        loading: false,
        saving: false,
        sortable: null,

        open() {
            this.isOpen = true;
        },

        close() {
            this.isOpen = false;
            this.selectedCategory = '';
            this.products = [];
            if (this.sortable) {
                this.sortable.destroy();
                this.sortable = null;
            }
        },

        loadProducts() {
            if (!this.selectedCategory) return;

            this.loading = true;

            // Filter products by selected category
            this.products = allProducts
                .filter(p => p.product_category_id == this.selectedCategory)
                .sort((a, b) => a.order - b.order);

            this.loading = false;

            // Render products manually and initialize Sortable
            this.$nextTick(() => {
                this.renderProducts();
                this.initSortable();
            });
        },

        renderProducts() {
            const container = document.getElementById('sortable-list');
            if (!container) return;

            // Clear existing content
            container.innerHTML = '';

            // Render each product
            this.products.forEach((product, index) => {
                const productEl = document.createElement('div');
                productEl.className = 'flex items-center gap-3 p-3 bg-neutral-50 dark:bg-neutral-700 rounded-lg border border-neutral-200 dark:border-neutral-600 cursor-move hover:bg-neutral-100 dark:hover:bg-neutral-600 transition';
                productEl.setAttribute('data-id', product.id);

                // Drag handle
                const dragHandle = `
                    <div class="text-neutral-400">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                        </svg>
                    </div>
                `;

                // Order number
                const orderNum = `<span class="text-sm font-semibold text-neutral-500 dark:text-neutral-400 w-8 hidden">${index + 1}</span>`;

                // Product thumbnail
                let thumbnail = '';
                if (product.media && product.media.length > 0) {
                    thumbnail = `
                        <div class="flex-shrink-0">
                            <img src="${product.media[0].original_url}"
                                 alt="${product.name}"
                                 class="w-16 h-16 object-cover rounded-lg border border-neutral-200 dark:border-neutral-600">
                        </div>
                    `;
                } else {
                    thumbnail = `
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-neutral-200 dark:bg-neutral-600 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    `;
                }

                // Product name
                const productName = `
                    <div class="flex-1">
                        <p class="text-sm font-medium text-neutral-900 dark:text-neutral-100">${product.name}</p>
                    </div>
                `;

                productEl.innerHTML = dragHandle + orderNum + thumbnail + productName;
                container.appendChild(productEl);
            });
        },

        initSortable() {
            const el = document.getElementById('sortable-list');
            if (el && !this.sortable) {
                this.sortable = Sortable.create(el, {
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'sortable-drag',
                    dataIdAttr: 'data-id',
                    onEnd: (evt) => {
                        // Rebuild products array from DOM order and re-render
                        if (evt.oldIndex !== undefined && evt.newIndex !== undefined && evt.oldIndex !== evt.newIndex) {
                            // Get current DOM order using Sortable's toArray()
                            const orderedIds = this.sortable.toArray().map(id => parseInt(id));

                            // Rebuild products array based on DOM order
                            const reorderedProducts = orderedIds.map(id =>
                                this.products.find(p => p.id === id)
                            ).filter(p => p !== undefined);

                            // Update products array
                            this.products = reorderedProducts;

                            // Destroy sortable before re-render
                            this.sortable.destroy();
                            this.sortable = null;

                            // Re-render with updated order
                            this.renderProducts();

                            // Re-initialize sortable
                            this.initSortable();
                        }
                    }
                });
            }
        },

        async saveOrder() {
            this.saving = true;
            try {
                const orderedProducts = this.products.map((product, index) => ({
                    id: product.id,
                    order: index + 1
                }));

                const response = await fetch('{{ route("admin.products.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        category_id: this.selectedCategory,
                        products: orderedProducts
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    alert('Products reordered successfully!');
                    window.location.reload();
                } else {
                    alert('Failed to save order');
                }
            } catch (error) {
                console.error('Error saving order:', error);
                alert('Failed to save order');
            } finally {
                this.saving = false;
            }
        }
    }
}

async function moveProduct(productId, direction) {
    try {
        const response = await fetch(`/admin/products/${productId}/move-${direction}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        const data = await response.json();
        
        if (data.success) {
            window.location.reload();
        } else {
            alert('Failed to move product');
        }
    } catch (error) {
        console.error('Error moving product:', error);
        alert('Failed to move product');
    }
}
</script>
@endpush
