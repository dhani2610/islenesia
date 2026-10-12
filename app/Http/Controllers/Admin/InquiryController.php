<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InquiryController extends Controller
{
    /**
     * Yajra DataTable Server-side AJAX endpoint for Inquiries.
     */
    public function data(Request $request)
    {
        $query = Inquiry::with('product')->select('inquiries.*');

        if ($request->filled('type')) {
            $filterType = $request->query('type');
            if ($filterType === 'pemasok') {
                $query->whereIn('type', ['pemasok', 'petani']);
            } else {
                $query->where('type', $filterType);
            }
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('type_badge', function ($row) {
                if ($row->type === 'buyer') {
                    return '<span class="badge-custom badge-buyer"><i class="fa-solid fa-box"></i> Buyer</span>';
                } elseif (in_array($row->type, ['pemasok', 'petani', 'seller'])) {
                    return '<span class="badge-custom badge-petani"><i class="fa-solid fa-truck-ramp-box"></i> Pemasok</span>';
                }
                return '<span class="badge-custom badge-general">Umum</span>';
            })
            ->addColumn('created_date', function ($row) {
                return $row->created_at->format('d/m/Y H:i');
            })
            ->addColumn('status_badge', function ($row) {
                $statusMap = [
                    'new' => '<span class="status-pill status-new">Baru</span>',
                    'contacted' => '<span class="status-pill status-contacted">Dihubungi</span>',
                    'deal' => '<span class="status-pill status-deal">Deal</span>',
                    'closed' => '<span class="status-pill status-closed">Selesai</span>',
                ];
                return $statusMap[$row->status] ?? $row->status;
            })
            ->addColumn('action', function ($row) {
                $phone = preg_replace('/[^0-9]/', '', $row->whatsapp);
                $waBtn = '<a href="https://wa.me/' . $phone . '" target="_blank" class="table-btn-wa" title="Buka WhatsApp Langsung"><i class="fa-brands fa-whatsapp"></i> Chat</a>';
                $deleteBtn = '<button type="button" class="table-btn-del" onclick="deleteInquiry(' . $row->id . ')" title="Hapus"><i class="fa-solid fa-trash"></i></button>';
                return '<div class="action-btn-group">' . $waBtn . $deleteBtn . '</div>';
            })
            ->rawColumns(['type_badge', 'status_badge', 'action'])
            ->make(true);
    }

    /**
     * Display inquiries index view.
     */
    public function index(Request $request)
    {
        return view('admin.inquiries.index');
    }

    /**
     * Update inquiry status (e.g. contacted, deal, closed).
     */
    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:new,contacted,deal,closed',
        ]);

        $inquiry = Inquiry::findOrFail($id);
        $inquiry->update(['status' => $request->input('status')]);

        return back()->with('success', 'Status inquiry berhasil diperbarui.');
    }

    /**
     * Delete an inquiry.
     */
    public function destroy(int $id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->delete();

        return back()->with('success', 'Data inquiry berhasil dihapus.');
    }
}
