<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TestimonialController extends Controller
{
    /**
     * Yajra DataTable AJAX endpoint for testimonials.
     */
    public function data(Request $request)
    {
        $query = Testimonial::select('testimonials.*');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('avatar_img', function ($row) {
                return '<img src="' . $row->avatar_url . '" alt="' . e($row->client_name) . '" class="table-avatar">';
            })
            ->addColumn('stars', function ($row) {
                $stars = '';
                for ($i = 0; $i < $row->rating; $i++) {
                    $stars .= '<i class="fa-solid fa-star text-gold" style="font-size:0.75rem;"></i> ';
                }
                return $stars;
            })
            ->addColumn('status_badge', function ($row) {
                return $row->is_active 
                    ? '<span class="status-pill status-deal">Aktif</span>' 
                    : '<span class="status-pill status-closed">Nonaktif</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.testimonials.edit', $row->id);
                return '<div class="action-btn-group">
                    <a href="' . $editUrl . '" class="table-btn-edit" title="Edit Testimoni"><i class="fa-solid fa-pen-to-square"></i></a>
                    <button type="button" class="table-btn-del" onclick="deleteTestimonial(' . $row->id . ')" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                </div>';
            })
            ->rawColumns(['avatar_img', 'stars', 'status_badge', 'action'])
            ->make(true);
    }

    /**
     * List all testimonials.
     */
    public function index()
    {
        return view('admin.testimonials.index');
    }

    /**
     * Show create testimonial form.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store new testimonial.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:150',
            'client_company' => 'nullable|string|max:150',
            'client_country' => 'nullable|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'client_name' => $validated['client_name'],
            'client_company' => $validated['client_company'] ?? null,
            'client_country' => $validated['client_country'] ?? null,
            'rating' => $validated['rating'],
            'content' => $validated['content'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : true,
        ];

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil ditambahkan!');
    }

    /**
     * Show edit testimonial form.
     */
    public function edit(int $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update testimonial.
     */
    public function update(Request $request, int $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $validated = $request->validate([
            'client_name' => 'required|string|max:150',
            'client_company' => 'nullable|string|max:150',
            'client_country' => 'nullable|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'client_name' => $validated['client_name'],
            'client_company' => $validated['client_company'] ?? null,
            'client_country' => $validated['client_country'] ?? null,
            'rating' => $validated['rating'],
            'content' => $validated['content'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar && Storage::disk('public')->exists($testimonial->avatar)) {
                Storage::disk('public')->delete($testimonial->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil diperbarui!');
    }

    /**
     * Delete testimonial.
     */
    public function destroy(int $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        if ($testimonial->avatar && Storage::disk('public')->exists($testimonial->avatar)) {
            Storage::disk('public')->delete($testimonial->avatar);
        }
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil dihapus.');
    }
}
