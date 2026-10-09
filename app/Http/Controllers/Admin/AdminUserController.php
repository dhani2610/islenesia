<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Yajra\DataTables\Facades\DataTables;

class AdminUserController extends Controller
{
    /**
     * Yajra DataTable AJAX endpoint for admin users.
     */
    public function data(Request $request)
    {
        $query = User::select('users.*');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('avatar_badge', function ($row) {
                return '<div class="user-avatar" style="width:36px; height:36px; font-size:0.85rem;">' . strtoupper(substr($row->name, 0, 1)) . '</div>';
            })
            ->addColumn('date_formatted', function ($row) {
                return $row->created_at->format('d/m/Y H:i');
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.users.edit', $row->id);
                $isSelf = Auth::id() === $row->id;
                
                $editBtn = '<a href="' . $editUrl . '" class="table-btn-edit" title="Edit Admin"><i class="fa-solid fa-pen-to-square"></i></a>';
                
                if ($isSelf) {
                    $delBtn = '<span style="font-size:0.75rem; color:#64748B; margin-left:4px;">(Akun Anda)</span>';
                } else {
                    $delBtn = '<button type="button" class="table-btn-del" onclick="deleteAdmin(' . $row->id . ')" title="Hapus"><i class="fa-solid fa-trash"></i></button>';
                }

                return '<div class="action-btn-group">' . $editBtn . $delBtn . '</div>';
            })
            ->rawColumns(['avatar_badge', 'action'])
            ->make(true);
    }

    /**
     * List all admin users.
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Show create admin form.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store new admin user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', Password::min(8)],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Admin baru berhasil ditambahkan!');
    }

    /**
     * Show edit admin form.
     */
    public function edit(int $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update admin user.
     */
    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => ['nullable', Password::min(8)],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data admin berhasil diperbarui!');
    }

    /**
     * Delete admin user.
     */
    public function destroy(int $id)
    {
        if (Auth::id() === $id) {
            return response()->json(['success' => false, 'message' => 'Anda tidak dapat menghapus akun Anda sendiri.'], 403);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true, 'message' => 'Admin berhasil dihapus.']);
    }
}
