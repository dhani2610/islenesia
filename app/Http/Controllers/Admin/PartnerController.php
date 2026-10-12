<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PartnerController extends Controller
{
    /**
     * Display listing of partners.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Partner::query()->orderBy('sort_order', 'asc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('logo_preview', function ($partner) {
                    $src = htmlspecialchars($partner->logo_url, ENT_QUOTES, 'UTF-8');
                    return '<div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:6px; display:inline-flex; align-items:center; justify-content:center; width:120px; height:50px;">
                                <img src="' . $src . '" style="max-width:100%; max-height:100%; object-fit:contain;" alt="Logo">
                            </div>';
                })
                ->addColumn('partner_info', function ($partner) {
                    $name = htmlspecialchars($partner->name, ENT_QUOTES, 'UTF-8');
                    $cat = htmlspecialchars($partner->category ?? '-', ENT_QUOTES, 'UTF-8');
                    return '<div><strong>' . $name . '</strong><div style="font-size:0.75rem; color:#64748B;">' . $cat . '</div></div>';
                })
                ->addColumn('status_badge', function ($partner) {
                    return $partner->is_active 
                        ? '<span class="status-pill status-deal" style="background:#DCFCE7; color:#166534;">Aktif</span>' 
                        : '<span class="status-pill status-closed" style="background:#F1F5F9; color:#64748B;">Nonaktif</span>';
                })
                ->addColumn('action', function ($partner) {
                    $editUrl = route('admin.partners.edit', $partner->id);
                    $delUrl = route('admin.partners.destroy', $partner->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    return '
                        <div class="action-btn-group" style="justify-content: center;">
                            <a href="' . $editUrl . '" class="table-btn-edit" title="Edit Partner">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="' . $delUrl . '" method="POST" onsubmit="return confirm(\'Hapus partner ini?\')" style="display:inline;">
                                ' . $csrf . '
                                ' . $method . '
                                <button type="submit" class="table-btn-del" title="Hapus Partner">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['logo_preview', 'partner_info', 'status_badge', 'action'])
                ->make(true);
        }

        $partnersCount = Partner::count();
        return view('admin.partners.index', compact('partnersCount'));
    }

    /**
     * Show form to create new partner.
     */
    public function create()
    {
        $nextOrder = (Partner::max('sort_order') ?? 0) + 1;
        return view('admin.partners.create', compact('nextOrder'));
    }

    /**
     * Store new partner.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'logo' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'category' => 'nullable|string|max:100',
            'url' => 'nullable|url|max:255',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $logoPath = $request->file('logo')->store('partners', 'public');

        Partner::create([
            'name' => $validated['name'],
            'logo' => $logoPath,
            'category' => $validated['category'] ?? null,
            'url' => $validated['url'] ?? null,
            'sort_order' => $validated['sort_order'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Logo partner/mitra berhasil ditambahkan!');
    }

    /**
     * Show form to edit partner.
     */
    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    /**
     * Update partner.
     */
    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'category' => 'nullable|string|max:100',
            'url' => 'nullable|url|max:255',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'name' => $validated['name'],
            'category' => $validated['category'] ?? null,
            'url' => $validated['url'] ?? null,
            'sort_order' => $validated['sort_order'],
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('logo')) {
            if (!empty($partner->logo) && !str_starts_with($partner->logo, 'http') && Storage::disk('public')->exists($partner->logo)) {
                Storage::disk('public')->delete($partner->logo);
            }
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->update($data);

        return redirect()->route('admin.partners.index')->with('success', 'Data partner/mitra berhasil diperbarui!');
    }

    /**
     * Delete partner.
     */
    public function destroy(Partner $partner)
    {
        if (!empty($partner->logo) && !str_starts_with($partner->logo, 'http') && Storage::disk('public')->exists($partner->logo)) {
            Storage::disk('public')->delete($partner->logo);
        }

        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Partner/mitra berhasil dihapus!');
    }
}
