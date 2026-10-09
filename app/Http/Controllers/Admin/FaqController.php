<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    /**
     * Yajra DataTable server-side endpoint for FAQs.
     */
    public function data(Request $request)
    {
        $query = Faq::select('faqs.*')->orderBy('sort_order', 'asc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('category_badge', function ($row) {
                return '<span class="badge-custom" style="background: rgba(11, 27, 61, 0.1); color: var(--admin-navy-surface); font-weight: 600;">' . e($row->category) . '</span>';
            })
            ->addColumn('status_badge', function ($row) {
                return $row->is_active 
                    ? '<span class="status-pill status-deal">Aktif</span>' 
                    : '<span class="status-pill status-closed">Nonaktif</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.faqs.edit', $row->id);
                return '<div class="action-btn-group">
                    <a href="' . $editUrl . '" class="table-btn-edit" title="Edit FAQ"><i class="fa-solid fa-pen-to-square"></i></a>
                    <button type="button" class="table-btn-del" onclick="deleteFaq(' . $row->id . ')" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                </div>';
            })
            ->rawColumns(['category_badge', 'status_badge', 'action'])
            ->make(true);
    }

    /**
     * Display FAQ listing.
     */
    public function index()
    {
        return view('admin.faqs.index');
    }

    /**
     * Show form to create new FAQ.
     */
    public function create()
    {
        $categories = Faq::distinct()->pluck('category')->filter()->values();
        if ($categories->isEmpty()) {
            $categories = collect(['Ekspor & Pemesanan', 'Logistik & Pelabuhan', 'Kemitraan Petani', 'Legalitas & Mutu', 'Pembayaran & Kontrak', 'Umum']);
        }
        return view('admin.faqs.create', compact('categories'));
    }

    /**
     * Store a newly created FAQ.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->has('is_active');

        Faq::create($validated);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ / Tanya Jawab berhasil ditambahkan!');
    }

    /**
     * Show form to edit existing FAQ.
     */
    public function edit(Faq $faq)
    {
        $categories = Faq::distinct()->pluck('category')->filter()->values();
        if ($categories->isEmpty()) {
            $categories = collect(['Ekspor & Pemesanan', 'Logistik & Pelabuhan', 'Kemitraan Petani', 'Legalitas & Mutu', 'Pembayaran & Kontrak', 'Umum']);
        }
        return view('admin.faqs.edit', compact('faq', 'categories'));
    }

    /**
     * Update specified FAQ.
     */
    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->has('is_active');

        $faq->update($validated);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ / Tanya Jawab berhasil diperbarui!');
    }

    /**
     * Remove specified FAQ.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ berhasil dihapus.');
    }
}
