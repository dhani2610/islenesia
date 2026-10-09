<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display listing of catalog categories.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Category::query()->orderBy('sort_order', 'asc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('name_badge', function ($category) {
                    return '<strong style="color: var(--admin-navy-surface); font-size: 0.95rem;">' . htmlspecialchars($category->name) . '</strong>
                            <div style="font-size: 0.75rem; color: var(--admin-muted);">Slug: ' . htmlspecialchars($category->slug) . '</div>';
                })
                ->addColumn('products_count', function ($category) {
                    $cnt = $category->products()->count();
                    return '<span class="status-pill status-contacted" style="background:#E0E7FF; color:#3730A3;">' . $cnt . ' Produk</span>';
                })
                ->addColumn('status_badge', function ($category) {
                    return $category->is_active 
                        ? '<span class="status-pill status-deal" style="background:#DCFCE7; color:#166534;">Aktif</span>' 
                        : '<span class="status-pill status-closed" style="background:#F1F5F9; color:#64748B;">Nonaktif</span>';
                })
                ->addColumn('action', function ($category) {
                    $editUrl = route('admin.categories.edit', $category->id);
                    $delUrl = route('admin.categories.destroy', $category->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    return '
                        <div class="action-btn-group" style="justify-content: center;">
                            <a href="' . $editUrl . '" class="table-btn-edit" title="Edit Kategori">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="' . $delUrl . '" method="POST" onsubmit="return confirm(\'Hapus kategori ' . htmlspecialchars($category->name, ENT_QUOTES) . '?\')" style="display:inline;">
                                ' . $csrf . '
                                ' . $method . '
                                <button type="submit" class="table-btn-del" title="Hapus Kategori">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['name_badge', 'products_count', 'status_badge', 'action'])
                ->make(true);
        }

        $categoriesCount = Category::count();
        return view('admin.categories.index', compact('categoriesCount'));
    }

    /**
     * Show form to create new category.
     */
    public function create()
    {
        $nextOrder = Category::max('sort_order') + 1;
        return view('admin.categories.create', compact('nextOrder'));
    }

    /**
     * Store new category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'slug' => 'nullable|string|max:100|unique:categories,slug',
            'description' => 'nullable|string|max:500',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        Category::create([
            'name' => $validated['name'],
            'slug' => !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori produk "' . $validated['name'] . '" berhasil ditambahkan!');
    }

    /**
     * Show form to edit category.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update category.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
            'slug' => 'nullable|string|max:100|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string|max:500',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $oldName = $category->name;
        $category->update([
            'name' => $validated['name'],
            'slug' => !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'],
            'is_active' => $request->has('is_active'),
        ]);

        // If category name changed, update linked products so they stay synced
        if ($oldName !== $validated['name']) {
            \App\Models\Product::where('category', $oldName)->update(['category' => $validated['name']]);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Kategori produk "' . $validated['name'] . '" berhasil diperbarui!');
    }

    /**
     * Delete category.
     */
    public function destroy(Category $category)
    {
        $name = $category->name;
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori "' . $name . '" berhasil dihapus!');
    }
}
