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
                    $badge = $slider->type === 'video' 
                        ? '<span style="position:absolute; bottom:4px; right:4px; background:#DC2626; color:#FFF; font-size:10px; font-weight:700; padding:2px 6px; border-radius:4px;"><i class="fa-brands fa-youtube"></i> Video</span>' 
                        : '<span style="position:absolute; bottom:4px; right:4px; background:#0F172A; color:#FFF; font-size:10px; font-weight:700; padding:2px 6px; border-radius:4px;"><i class="fa-regular fa-image"></i> Foto</span>';

                    return '<div style="position:relative; width:110px; height:60px; display:inline-block;">
                                <img src="' . $src . '" class="table-thumb" style="width: 100%; height: 100%; border-radius: 8px; object-fit: cover;" alt="Slide Preview">
                                ' . $badge . '
                            </div>';
                })
                ->addColumn('title_display', function ($slider) {
                    $title = $slider->title ? htmlspecialchars($slider->title, ENT_QUOTES, 'UTF-8') : '<span style="color:#94a3b8; font-style:italic;">(Visual Banner)</span>';
                    if ($slider->type === 'video') {
                        $yt = htmlspecialchars($slider->youtube_url ?? '', ENT_QUOTES, 'UTF-8');
                        return '<div><strong>' . $title . '</strong><div style="font-size:0.75rem; color:#DC2626; margin-top:2px;"><i class="fa-brands fa-youtube"></i> ' . ($yt ?: 'YouTube Video') . '</div></div>';
                    }
                    return '<div><strong>' . $title . '</strong><div style="font-size:0.75rem; color:#64748B; margin-top:2px;"><i class="fa-regular fa-image"></i> Gambar / Foto Banner</div></div>';
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
                ->rawColumns(['image_preview', 'title_display', 'status_badge', 'action'])
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
        $nextOrder = (Slider::max('sort_order') ?? 0) + 1;
        return view('admin.sliders.create', compact('nextOrder'));
    }

    /**
     * Store new slider.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:150',
            'type' => 'required|in:image,video',
            'youtube_url' => 'required_if:type,video|nullable|string|max:255',
            'image' => 'required_if:type,image|nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sliders', 'public');
        }

        Slider::create([
            'title' => $validated['title'] ?? null,
            'type' => $validated['type'],
            'youtube_url' => $validated['youtube_url'] ?? null,
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
            'type' => 'required|in:image,video',
            'youtube_url' => 'required_if:type,video|nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'title' => $validated['title'] ?? null,
            'type' => $validated['type'],
            'youtube_url' => $validated['youtube_url'] ?? null,
            'sort_order' => $validated['sort_order'],
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('image')) {
            if (!empty($slider->image) && !str_starts_with($slider->image, 'http') && Storage::disk('public')->exists($slider->image)) {
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
        if (!empty($slider->image) && !str_starts_with($slider->image, 'http') && Storage::disk('public')->exists($slider->image)) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Banner slider berhasil dihapus!');
    }
}
