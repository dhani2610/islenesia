<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Yajra DataTable AJAX endpoint for products.
     */
    public function data(Request $request)
    {
        $query = Product::select('products.*');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('thumbnail', function ($row) {
                return '<img src="' . $row->image_url . '" alt="' . e($row->name) . '" class="table-thumb">';
            })
            ->addColumn('status_badge', function ($row) {
                return $row->is_active 
                    ? '<span class="status-pill status-deal">Aktif</span>' 
                    : '<span class="status-pill status-closed">Nonaktif</span>';
            })
            ->addColumn('featured_badge', function ($row) {
                return $row->is_featured 
                    ? '<span class="badge-custom badge-buyer"><i class="fa-solid fa-star"></i> Unggulan</span>' 
                    : '-';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.products.edit', $row->id);
                $viewUrl = route('catalog.show', $row->slug);
                return '<div class="action-btn-group">
                    <a href="' . $viewUrl . '" target="_blank" class="table-btn-wa" title="Lihat di Web"><i class="fa-solid fa-eye"></i></a>
                    <a href="' . $editUrl . '" class="table-btn-edit" title="Edit Produk"><i class="fa-solid fa-pen-to-square"></i></a>
                    <button type="button" class="table-btn-del" onclick="deleteProduct(' . $row->id . ')" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                </div>';
            })
            ->rawColumns(['thumbnail', 'status_badge', 'featured_badge', 'action'])
            ->make(true);
    }

    /**
     * List all products.
     */
    public function index()
    {
        return view('admin.products.index');
    }

    /**
     * Show form to create product.
     */
    public function create()
    {
        $categories = \App\Models\Category::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store new product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'category' => 'required|string|max:100',
            'short_description' => 'nullable|string|max:1000',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'spec_keys' => 'nullable|array',
            'spec_values' => 'nullable|array',
            'gallery_items' => 'nullable|array',
            'gallery_items.*.file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'gallery_items.*.title' => 'nullable|string|max:255',
            'gallery_items.*.caption' => 'nullable|string|max:1000',
            'gallery_items.*.existing_image' => 'nullable|string|max:255',
        ]);

        $data = [
            'name' => $validated['name'],
            'slug' => !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']),
            'category' => $validated['category'],
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : true,
        ];

        // Format specifications
        $specs = [];
        if (!empty($request->input('spec_keys'))) {
            $keys = $request->input('spec_keys');
            $values = $request->input('spec_values', []);
            foreach ($keys as $idx => $key) {
                if (!empty(trim($key)) && isset($values[$idx])) {
                    $specs[trim($key)] = trim($values[$idx]);
                }
            }
        }
        $data['specifications'] = $specs;

        // Process gallery items
        $gallery = [];
        if ($request->has('gallery_items')) {
            foreach ($request->input('gallery_items', []) as $idx => $item) {
                $imgPath = null;
                if ($request->hasFile("gallery_items.{$idx}.file")) {
                    $imgPath = $request->file("gallery_items.{$idx}.file")->store('products/gallery', 'public');
                } elseif (!empty($item['existing_image'])) {
                    $imgPath = $item['existing_image'];
                }

                if (!empty($imgPath)) {
                    $gallery[] = [
                        'image' => $imgPath,
                        'title' => !empty($item['title']) ? strip_tags($item['title']) : '',
                        'caption' => !empty($item['caption']) ? strip_tags($item['caption']) : '',
                    ];
                }
            }
        }
        $data['gallery'] = $gallery;

        // Upload main image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk komoditas beserta galeri foto berhasil ditambahkan!');
    }

    /**
     * Show form to edit product.
     */
    public function edit(int $id)
    {
        $product = Product::findOrFail($id);
        $categories = \App\Models\Category::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update product.
     */
    public function update(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $id,
            'category' => 'required|string|max:100',
            'short_description' => 'nullable|string|max:1000',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'spec_keys' => 'nullable|array',
            'spec_values' => 'nullable|array',
            'gallery_items' => 'nullable|array',
            'gallery_items.*.file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'gallery_items.*.title' => 'nullable|string|max:255',
            'gallery_items.*.caption' => 'nullable|string|max:1000',
            'gallery_items.*.existing_image' => 'nullable|string|max:255',
        ]);

        $data = [
            'name' => $validated['name'],
            'slug' => !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']),
            'category' => $validated['category'],
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active'),
        ];

        // Format specifications
        $specs = [];
        if (!empty($request->input('spec_keys'))) {
            $keys = $request->input('spec_keys');
            $values = $request->input('spec_values', []);
            foreach ($keys as $idx => $key) {
                if (!empty(trim($key)) && isset($values[$idx])) {
                    $specs[trim($key)] = trim($values[$idx]);
                }
            }
        }
        $data['specifications'] = $specs;

        // Process gallery items
        $gallery = [];
        $existingKept = [];
        if ($request->has('gallery_items')) {
            foreach ($request->input('gallery_items', []) as $idx => $item) {
                $imgPath = null;
                $hasNewFile = $request->hasFile("gallery_items.{$idx}.file");

                if ($hasNewFile) {
                    $imgPath = $request->file("gallery_items.{$idx}.file")->store('products/gallery', 'public');
                    // Remove old replaced image if from public storage
                    if (!empty($item['existing_image']) && Storage::disk('public')->exists($item['existing_image'])) {
                        Storage::disk('public')->delete($item['existing_image']);
                    }
                } elseif (!empty($item['existing_image'])) {
                    $imgPath = $item['existing_image'];
                    $existingKept[] = $imgPath;
                }

                if (!empty($imgPath)) {
                    $gallery[] = [
                        'image' => $imgPath,
                        'title' => !empty($item['title']) ? strip_tags($item['title']) : '',
                        'caption' => !empty($item['caption']) ? strip_tags($item['caption']) : '',
                    ];
                }
            }
        }

        // Clean up deleted gallery images from storage (only files inside products/gallery/)
        if (!empty($product->gallery) && is_array($product->gallery)) {
            foreach ($product->gallery as $oldG) {
                $oldImg = is_array($oldG) ? ($oldG['image'] ?? '') : $oldG;
                if ($oldImg && !in_array($oldImg, $existingKept) && str_starts_with($oldImg, 'products/gallery/')) {
                    if (Storage::disk('public')->exists($oldImg)) {
                        Storage::disk('public')->delete($oldImg);
                    }
                }
            }
        }
        $data['gallery'] = $gallery;

        // Upload main image
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk komoditas dan galeri dokumentasi berhasil diperbarui!');
    }

    /**
     * Delete product.
     */
    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete gallery files
        if (!empty($product->gallery) && is_array($product->gallery)) {
            foreach ($product->gallery as $g) {
                $img = is_array($g) ? ($g['image'] ?? '') : $g;
                if ($img && Storage::disk('public')->exists($img)) {
                    Storage::disk('public')->delete($img);
                }
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
