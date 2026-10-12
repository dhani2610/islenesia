<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display settings dashboard with tabs.
     */
    public function index()
    {
        $settings = Setting::allMap();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'company_name' => 'nullable|string|max:255',
            'company_established' => 'nullable|string|max:50',
            'exported_countries_count' => 'nullable|string|max:50',
            'metric_tons_exported' => 'nullable|string|max:50',
            'partner_farmers_count' => 'nullable|string|max:50',
            'buyer_satisfaction' => 'nullable|string|max:50',
            
            // Contact
            'email' => 'nullable|string|max:150',
            'phone' => 'nullable|string|max:100',
            'whatsapp_number' => 'nullable|string|max:50',
            'whatsapp_buyer' => 'nullable|string|max:50',
            'whatsapp_pemasok' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'maps_embed' => 'nullable|string',
            
            // Dynamic Social Media
            'social_instagram' => 'nullable|string|max:255',
            'social_facebook' => 'nullable|string|max:255',
            'social_tiktok' => 'nullable|string|max:255',
            'social_youtube' => 'nullable|string|max:255',
            'social_linkedin' => 'nullable|string|max:255',
            'social_twitter' => 'nullable|string|max:255',
            
            // SEO Meta
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            
            // Home & Hero Content
            'hero_badge' => 'nullable|string|max:255',
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string',
            'loading_port' => 'nullable|string|max:255',
            'home_catalog_badge' => 'nullable|string|max:255',
            'home_catalog_title' => 'nullable|string|max:255',
            'home_catalog_subtitle' => 'nullable|string',
            'home_portfolio_badge' => 'nullable|string|max:255',
            'home_portfolio_title' => 'nullable|string|max:255',
            'workflow_badge' => 'nullable|string|max:255',
            'workflow_title' => 'nullable|string|max:255',
            'workflow_subtitle' => 'nullable|string',
            'why_choose_badge' => 'nullable|string|max:255',
            'why_choose_title' => 'nullable|string|max:255',
            'why_choose_subtitle' => 'nullable|string',
            'cta_badge' => 'nullable|string|max:255',
            'cta_title' => 'nullable|string|max:255',
            'cta_subtitle' => 'nullable|string',

            // About Us Content
            'about_hero_badge' => 'nullable|string|max:255',
            'about_hero_title' => 'nullable|string|max:255',
            'about_hero_subtitle' => 'nullable|string',
            'about_story_badge' => 'nullable|string|max:255',
            'about_story' => 'nullable|string',
            'about_story_p2' => 'nullable|string',
            'about_vision' => 'nullable|string',
            'about_mission' => 'nullable|string',
            'about_market_title' => 'nullable|string|max:255',
            'about_market_subtitle' => 'nullable|string',
            
            // Media Files
            'site_logo' => 'nullable|file|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'site_favicon' => 'nullable|file|mimes:jpeg,png,jpg,webp,svg,ico|max:1024',
            'meta_og_image' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:2048',
            'hero_slider_1' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:3072',
            'hero_slider_2' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:3072',
            'hero_slider_3' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        // Handle uploaded logo
        if ($request->hasFile('site_logo')) {
            $oldLogo = Setting::get('site_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            $logoPath = $request->file('site_logo')->store('branding', 'public');
            Setting::set('site_logo', $logoPath, 'branding');
        }

        // Handle uploaded favicon
        if ($request->hasFile('site_favicon')) {
            $oldFavicon = Setting::get('site_favicon');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }
            $favPath = $request->file('site_favicon')->store('branding', 'public');
            Setting::set('site_favicon', $favPath, 'branding');
        }

        // Handle uploaded OG Image
        if ($request->hasFile('meta_og_image')) {
            $oldOg = Setting::get('meta_og_image');
            if ($oldOg && Storage::disk('public')->exists($oldOg)) {
                Storage::disk('public')->delete($oldOg);
            }
            $ogPath = $request->file('meta_og_image')->store('branding', 'public');
            Setting::set('meta_og_image', $ogPath, 'seo');
        }

        // Handle uploaded hero sliders
        for ($s = 1; $s <= 3; $s++) {
            $sliderKey = "hero_slider_{$s}";
            if ($request->hasFile($sliderKey)) {
                $oldSlider = Setting::get($sliderKey);
                if ($oldSlider && Storage::disk('public')->exists($oldSlider)) {
                    Storage::disk('public')->delete($oldSlider);
                }
                $sliderPath = $request->file($sliderKey)->store('sliders', 'public');
                Setting::set($sliderKey, $sliderPath, 'home');
            }
        }

        // Save all text fields
        $fieldsToSave = [
            'site_name', 'site_tagline', 'site_description', 'company_name',
            'company_established', 'exported_countries_count', 'metric_tons_exported',
            'partner_farmers_count', 'buyer_satisfaction', 'email', 'phone',
            'whatsapp_number', 'whatsapp_buyer', 'whatsapp_pemasok', 'address', 'maps_embed', 'social_instagram',
            'social_facebook', 'social_tiktok', 'social_youtube', 'social_linkedin',
            'social_twitter', 'meta_title', 'meta_description', 'meta_keywords',
            'hero_badge', 'hero_title', 'hero_subtitle', 'loading_port',
            'home_catalog_badge', 'home_catalog_title', 'home_catalog_subtitle',
            'home_portfolio_badge', 'home_portfolio_title', 'workflow_badge',
            'workflow_title', 'workflow_subtitle', 'why_choose_badge',
            'why_choose_title', 'why_choose_subtitle', 'cta_badge', 'cta_title',
            'cta_subtitle', 'about_hero_badge', 'about_hero_title',
            'about_hero_subtitle', 'about_story_badge', 'about_story',
            'about_story_p2', 'about_vision', 'about_mission',
            'about_market_title', 'about_market_subtitle'
        ];

        foreach ($fieldsToSave as $field) {
            if ($request->has($field)) {
                Setting::set($field, $request->input($field), 'general');
            }
        }

        Cache::forget('all_settings');

        return back()->with('success', 'Pengaturan website, branding, dan SEO berhasil disimpan!');
    }
}
