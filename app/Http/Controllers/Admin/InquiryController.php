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
            ->addColumn('contact_info', function ($row) {
                $html = '';
                if (!empty($row->whatsapp) && $row->whatsapp !== '-') {
                    $html .= '<div style="margin-bottom: 2px;"><i class="fa-brands fa-whatsapp text-success"></i> ' . e($row->whatsapp) . '</div>';
                }
                if (!empty($row->email)) {
                    $html .= '<div style="font-size: 0.8rem; color: #1D4ED8;"><i class="fa-regular fa-envelope"></i> ' . e($row->email) . '</div>';
                }
                if ($row->channel === 'email') {
                    $html .= '<span style="display: inline-block; margin-top: 3px; font-size: 0.68rem; background: #EFF6FF; color: #1D4ED8; padding: 1px 6px; border-radius: 4px; font-weight: 700;">Via Email</span>';
                } elseif ($row->channel === 'both') {
                    $html .= '<span style="display: inline-block; margin-top: 3px; font-size: 0.68rem; background: #F3F4F6; color: #4B5563; padding: 1px 6px; border-radius: 4px; font-weight: 700;">WA + Email</span>';
                }
                return $html ?: '-';
            })
            ->addColumn('action', function ($row) {
                $btns = '';
                if (!empty($row->email)) {
                    $btns .= '<a href="mailto:' . e($row->email) . '?subject=Re:%20Trade%20Inquiry%20Islenesia" class="table-btn-wa" style="background: #0B1B3D; color: #FFFFFF;" title="Balas via Email"><i class="fa-regular fa-envelope"></i> Email</a>';
                }
                if (!empty($row->whatsapp) && $row->whatsapp !== '-') {
                    $phone = preg_replace('/[^0-9]/', '', $row->whatsapp);
                    $btns .= '<a href="https://wa.me/' . $phone . '" target="_blank" class="table-btn-wa" title="Buka WhatsApp Langsung"><i class="fa-brands fa-whatsapp"></i> WA</a>';
                }
                $btns .= '<button type="button" class="table-btn-del" onclick="deleteInquiry(' . $row->id . ')" title="Hapus"><i class="fa-solid fa-trash"></i></button>';
                return '<div class="action-btn-group">' . $btns . '</div>';
            })
            ->rawColumns(['type_badge', 'contact_info', 'status_badge', 'action'])
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
