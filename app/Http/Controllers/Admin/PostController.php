<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    /**
     * Yajra DataTable AJAX endpoint for blog articles.
     */
    public function data(Request $request)
    {
        $query = Post::select('posts.*');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('thumbnail', function ($row) {
                return '<img src="' . $row->image_url . '" alt="' . e($row->title) . '" class="table-thumb">';
            })
            ->addColumn('status_badge', function ($row) {
                return $row->is_published 
                    ? '<span class="status-pill status-deal">Published</span>' 
                    : '<span class="status-pill status-closed">Draft</span>';
            })
            ->addColumn('date_formatted', function ($row) {
                return $row->published_at ? $row->published_at->format('d/m/Y') : '-';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.posts.edit', $row->id);
                $viewUrl = route('blog.show', $row->slug);
                return '<div class="action-btn-group">
                    <a href="' . $viewUrl . '" target="_blank" class="table-btn-wa" title="Lihat di Web"><i class="fa-solid fa-eye"></i></a>
                    <a href="' . $editUrl . '" class="table-btn-edit" title="Edit Artikel"><i class="fa-solid fa-pen-to-square"></i></a>
                    <button type="button" class="table-btn-del" onclick="deletePost(' . $row->id . ')" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                </div>';
            })
            ->rawColumns(['thumbnail', 'status_badge', 'action'])
            ->make(true);
    }

    /**
     * List all blog articles.
     */
    public function index()
    {
        return view('admin.posts.index');
    }

    /**
     * Create article form.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store new article.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'category' => 'required|string|max:100',
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'is_published' => 'nullable|boolean',
        ]);

        $data = [
            'title' => $validated['title'],
            'slug' => !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']),
            'category' => $validated['category'],
            'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160),
            'content' => $validated['content'],
            'meta_title' => $validated['meta_title'] ?? $validated['title'],
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
            'is_published' => $request->has('is_published') ? $request->boolean('is_published') : true,
            'published_at' => now(),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blog', 'public');
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Artikel berhasil dipublikasikan!');
    }

    /**
     * Edit article form.
     */
    public function edit(int $id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update article.
     */
    public function update(Request $request, int $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug,' . $id,
            'category' => 'required|string|max:100',
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'is_published' => 'nullable|boolean',
        ]);

        $data = [
            'title' => $validated['title'],
            'slug' => !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']),
            'category' => $validated['category'],
            'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160),
            'content' => $validated['content'],
            'meta_title' => $validated['meta_title'] ?? $validated['title'],
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
            'is_published' => $request->boolean('is_published'),
        ];

        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('blog', 'public');
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Delete article.
     */
    public function destroy(int $id)
    {
        $post = Post::findOrFail($id);
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
