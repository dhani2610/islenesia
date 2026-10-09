<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the company profile homepage.
     */
    public function index()
    {
        $products = Product::where('is_active', true)
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $latestPosts = Post::where('is_published', true)
            ->latest('published_at')
            ->take(3)
            ->get();

        $faqs = Faq::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $sliders = Slider::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $stats = [
            'countries' => Setting::get('exported_countries_count', '28+'),
            'tons' => Setting::get('metric_tons_exported', '5,400+'),
            'farmers' => Setting::get('partner_farmers_count', '1,450+'),
            'satisfaction' => Setting::get('buyer_satisfaction', '99.4%'),
        ];

        return view('pages.home', compact('products', 'testimonials', 'latestPosts', 'stats', 'faqs', 'sliders'));
    }
}

