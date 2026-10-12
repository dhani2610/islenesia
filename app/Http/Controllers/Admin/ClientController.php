<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ClientController extends Controller
{
    /**
     * Display listing of clients.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Client::query()->orderBy('sort_order', 'asc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('logo_preview', function ($client) {
                    $src = htmlspecialchars($client->logo_url, ENT_QUOTES, 'UTF-8');
                    return '<div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:6px; display:inline-flex; align-items:center; justify-content:center; width:120px; height:50px;">
                                <img src="' . $src . '" style="max-width:100%; max-height:100%; object-fit:contain;" alt="Logo">
                            </div>';
                })
                ->addColumn('client_info', function ($client) {
                    $name = htmlspecialchars($client->name, ENT_QUOTES, 'UTF-8');
                    $sub = htmlspecialchars($client->country_or_type ?? '-', ENT_QUOTES, 'UTF-8');
                    return '<div><strong>' . $name . '</strong><div style="font-size:0.75rem; color:#64748B;">' . $sub . '</div></div>';
                })
                ->addColumn('status_badge', function ($client) {
                    return $client->is_active 
                        ? '<span class="status-pill status-deal" style="background:#DCFCE7; color:#166534;">Aktif</span>' 
                        : '<span class="status-pill status-closed" style="background:#F1F5F9; color:#64748B;">Nonaktif</span>';
                })
                ->addColumn('action', function ($client) {
                    $editUrl = route('admin.clients.edit', $client->id);
                    $delUrl = route('admin.clients.destroy', $client->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    return '
                        <div class="action-btn-group" style="justify-content: center;">
                            <a href="' . $editUrl . '" class="table-btn-edit" title="Edit Klien">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="' . $delUrl . '" method="POST" onsubmit="return confirm(\'Hapus klien ini?\')" style="display:inline;">
                                ' . $csrf . '
                                ' . $method . '
                                <button type="submit" class="table-btn-del" title="Hapus Klien">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['logo_preview', 'client_info', 'status_badge', 'action'])
                ->make(true);
        }

        $clientsCount = Client::count();
        return view('admin.clients.index', compact('clientsCount'));
    }

    /**
     * Show form to create new client.
     */
    public function create()
    {
        $nextOrder = (Client::max('sort_order') ?? 0) + 1;
        return view('admin.clients.create', compact('nextOrder'));
    }

    /**
     * Store new client.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'logo' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'country_or_type' => 'nullable|string|max:100',
            'url' => 'nullable|url|max:255',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $logoPath = $request->file('logo')->store('clients', 'public');

        Client::create([
            'name' => $validated['name'],
            'logo' => $logoPath,
            'country_or_type' => $validated['country_or_type'] ?? null,
            'url' => $validated['url'] ?? null,
            'sort_order' => $validated['sort_order'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.clients.index')->with('success', 'Logo klien berhasil ditambahkan!');
    }

    /**
     * Show form to edit client.
     */
    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Update client.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'country_or_type' => 'nullable|string|max:100',
            'url' => 'nullable|url|max:255',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'name' => $validated['name'],
            'country_or_type' => $validated['country_or_type'] ?? null,
            'url' => $validated['url'] ?? null,
            'sort_order' => $validated['sort_order'],
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('logo')) {
            if (!empty($client->logo) && !str_starts_with($client->logo, 'http') && Storage::disk('public')->exists($client->logo)) {
                Storage::disk('public')->delete($client->logo);
            }
            $data['logo'] = $request->file('logo')->store('clients', 'public');
        }

        $client->update($data);

        return redirect()->route('admin.clients.index')->with('success', 'Data klien berhasil diperbarui!');
    }

    /**
     * Delete client.
     */
    public function destroy(Client $client)
    {
        if (!empty($client->logo) && !str_starts_with($client->logo, 'http') && Storage::disk('public')->exists($client->logo)) {
            Storage::disk('public')->delete($client->logo);
        }

        $client->delete();

        return redirect()->route('admin.clients.index')->with('success', 'Klien berhasil dihapus!');
    }
}
