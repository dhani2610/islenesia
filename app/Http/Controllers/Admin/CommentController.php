<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CommentController extends Controller
{
    /**
     * Yajra DataTable AJAX endpoint for comments.
     */
    public function data(Request $request)
    {
        $query = Comment::with('post')->select('comments.*');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('post_title', function ($row) {
                return $row->post ? e($row->post->title) : '-';
            })
            ->addColumn('status_badge', function ($row) {
                return $row->is_approved 
                    ? '<span class="status-pill status-deal">Disetujui</span>' 
                    : '<span class="status-pill status-new">Tertunda</span>';
            })
            ->addColumn('date_formatted', function ($row) {
                return $row->created_at->format('d/m/Y H:i');
            })
            ->addColumn('action', function ($row) {
                $toggleText = $row->is_approved ? '<i class="fa-solid fa-ban"></i> Batal' : '<i class="fa-solid fa-check"></i> Setujui';
                $toggleBtn = '<button type="button" class="table-btn-wa" onclick="toggleComment(' . $row->id . ')" title="Ubah Status">' . $toggleText . '</button>';
                $deleteBtn = '<button type="button" class="table-btn-del" onclick="deleteComment(' . $row->id . ')" title="Hapus"><i class="fa-solid fa-trash"></i></button>';
                return '<div class="action-btn-group">' . $toggleBtn . $deleteBtn . '</div>';
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }

    /**
     * List all comments.
     */
    public function index()
    {
        return view('admin.comments.index');
    }

    /**
     * Toggle approve / unapprove status.
     */
    public function toggleApprove(int $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['is_approved' => !$comment->is_approved]);

        $statusText = $comment->is_approved ? 'disetujui' : 'dibatalkan persetujuannya';
        return back()->with('success', "Komentar berhasil {$statusText}.");
    }

    /**
     * Delete comment.
     */
    public function destroy(int $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
