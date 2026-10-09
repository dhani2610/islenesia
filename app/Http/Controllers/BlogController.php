<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display blog posts listing.
     */
    public function index(Request $request)
    {
        $query = Post::where('is_published', true);

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        if ($request->filled('q')) {
            $searchTerm = '%' . trim($request->query('q')) . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhere('excerpt', 'like', $searchTerm)
                  ->orWhere('content', 'like', $searchTerm);
            });
        }

        $categories = Post::where('is_published', true)
            ->distinct()
            ->pluck('category');

        $posts = $query->latest('published_at')->paginate(9)->withQueryString();

        return view('pages.blog.index', compact('posts', 'categories'));
    }

    /**
     * Show single blog post with comments and share features.
     */
    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment view count safely
        $post->increment('views_count');

        $comments = $post->approvedComments;

        $relatedPosts = Post::where('is_published', true)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        $isLiked = in_array($post->id, session()->get('liked_posts', []));

        // Generate fresh math challenge for comment captcha
        $c1 = rand(2, 9);
        $c2 = rand(1, 9);
        session(['captcha_comment' => $c1 + $c2]);
        $captchaQuestion = "{$c1} + {$c2}";

        return view('pages.blog.show', compact('post', 'comments', 'relatedPosts', 'isLiked', 'captchaQuestion'));
    }

    /**
     * Handle post like action (toggle like/unlike to prevent duplicate spam).
     */
    public function like(int $id)
    {
        $post = Post::findOrFail($id);
        
        $likedPosts = session()->get('liked_posts', []);
        $isAlreadyLiked = in_array($id, $likedPosts);

        if ($isAlreadyLiked) {
            // Cancel like / toggle unlike
            if ($post->likes_count > 0) {
                $post->decrement('likes_count');
            }
            $likedPosts = array_values(array_diff($likedPosts, [$id]));
            session()->put('liked_posts', $likedPosts);
            $liked = false;
            $msg = 'Suka dibatalkan.';
        } else {
            // Like post
            $post->increment('likes_count');
            $likedPosts[] = $id;
            session()->put('liked_posts', $likedPosts);
            $liked = true;
            $msg = 'Terima kasih atas apresiasi Anda!';
        }

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'liked' => $liked,
                'likes_count' => $post->likes_count,
                'message' => $msg,
            ]);
        }

        return back()->with('success', $msg);
    }

    /**
     * Submit comment on blog post with honeypot bot trap and math captcha.
     */
    public function comment(Request $request, int $id)
    {
        // Bot honeypot check
        if ($request->filled('website_trap')) {
            return back()->with('comment_success', 'Komentar Anda berhasil dikirim.');
        }

        // Anti-Bot Captcha Verification
        $expectedCaptcha = session('captcha_comment');
        $userCaptcha = $request->input('captcha_answer');
        if ($expectedCaptcha === null || (int)$userCaptcha !== (int)$expectedCaptcha) {
            return back()->withInput()->withErrors([
                'captcha_answer' => 'Jawaban verifikasi keamanan (Captcha) salah. Silakan coba lagi.'
            ]);
        }

        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'author_name' => 'required|string|max:100',
            'author_email' => 'required|email|max:150',
            'comment' => 'required|string|max:1000',
        ]);

        Comment::create([
            'post_id' => $post->id,
            'author_name' => strip_tags($validated['author_name']),
            'author_email' => strip_tags($validated['author_email']),
            'comment' => strip_tags($validated['comment']),
            'is_approved' => true,
            'ip_address' => $request->ip(),
        ]);

        // Consume captcha session
        session()->forget('captcha_comment');

        return back()->with('comment_success', 'Komentar Anda berhasil dipublikasikan!');
    }
}

