<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the main admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_inquiries' => Inquiry::count(),
            'buyer_inquiries' => Inquiry::where('type', 'buyer')->count(),
            'petani_inquiries' => Inquiry::where('type', 'petani')->count(),
            'total_products' => Product::count(),
            'total_posts' => Post::count(),
            'pending_comments' => Comment::where('is_approved', false)->count(),
        ];

        $recentInquiries = Inquiry::with('product')
            ->latest()
            ->take(8)
            ->get();

        $recentPosts = Post::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentInquiries', 'recentPosts'));
    }
}
