<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller
{
    /**
     * Display listing of hero image sliders.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Slider::query()->orderBy('sort_order', 'asc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('image_preview', function ($slider) {
                    $src = htmlspecialchars($slider->image_url, ENT_QUOTES, 'UTF-8');
                    return '<img src="' . $src . '" class="table-thumb" style="width: 100px; height: 55px; border-radius: 8px; object-fit: cover;" alt="Slide Preview">';
                })
                ->addColumn('status_badge', function ($slider) {
                    return $slider->is_active 
                        ? '<span class="status-pill status-deal" style="background:#DCFCE7; color:#166534;">Aktif</span>' 
                        : '<span class="status-pill status-closed" style="background:#F1F5F9; color:#64748B;">Nonaktif</span>';
                })
                ->addColumn('action', function ($slider) {
                    $editUrl = route('admin.sliders.edit', $slider->id);
                    $delUrl = route('admin.sliders.destroy', $slider->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    return '
                        <div class="action-btn-group" style="justify-content: center;">
                            <a href="' . $editUrl . '" class="table-btn-edit" title="Edit Slider">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="' . $delUrl . '" method="POST" onsubmit="return confirm(\'Hapus slider ini?\')" style="display:inline;">
                                ' . $csrf . '
                                ' . $method . '
                                <button type="submit" class="table-btn-del" title="Hapus Slider">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['image_preview', 'status_badge', 'action'])
                ->make(true);
        }

        $slidersCount = Slider::count();
        return view('admin.sliders.index', compact('slidersCount'));
    }

    /**
     * Show form to create new slider.
     */
    public function create()
    {
        $nextOrder = Slider::max('sort_order') + 1;
        return view('admin.sliders.create', compact('nextOrder'));
    }

    /**
     * Store new slider.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:150',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $imagePath = $request->file('image')->store('sliders', 'public');

        Slider::create([
            'title' => $validated['title'] ?? null,
            'image' => $imagePath,
            'sort_order' => $validated['sort_order'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Banner slider baru berhasil ditambahkan!');
    }

    /**
     * Show form to edit slider.
     */
    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Update slider.
     */
    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:150',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'title' => $validated['title'] ?? null,
            'sort_order' => $validated['sort_order'],
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('image')) {
            // Delete old image if stored locally
            if (!str_starts_with($slider->image, 'http') && Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        $slider->update($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Banner slider berhasil diperbarui!');
    }

    /**
     * Delete slider.
     */
    public function destroy(Slider $slider)
    {
        if (!str_starts_with($slider->image, 'http') && Storage::disk('public')->exists($slider->image)) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Banner slider berhasil dihapus!');
    }
}
