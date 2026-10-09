<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display about us page.
     */
    public function index()
    {
        $about = [
            'story' => Setting::get('about_story'),
            'vision' => Setting::get('about_vision'),
            'mission' => Setting::get('about_mission'),
            'company_name' => Setting::get('company_name', 'PT Manunggal Agro Nusantara'),
            'established' => Setting::get('company_established', '2019'),
            'countries' => Setting::get('exported_countries_count', '28+'),
            'tons' => Setting::get('metric_tons_exported', '5,400+'),
            'farmers' => Setting::get('partner_farmers_count', '1,450+'),
        ];

        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->take(3)->get();

        return view('pages.about', compact('about', 'testimonials'));
    }
}
