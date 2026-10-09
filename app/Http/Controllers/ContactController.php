<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Setting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display contact page with maps and dynamic social media.
     */
    public function index()
    {
        $contact = [
            'email' => Setting::get('email', 'info@manunggaland.com'),
            'phone' => Setting::get('phone', '+62 851-6131-3914'),
            'whatsapp' => Setting::get('whatsapp_number', '6285161313914'),
            'address' => Setting::get('address', 'Jakarta Utara, Indonesia'),
            'maps' => Setting::get('maps_embed'),
            'social_instagram' => Setting::get('social_instagram'),
            'social_facebook' => Setting::get('social_facebook'),
            'social_tiktok' => Setting::get('social_tiktok'),
            'social_youtube' => Setting::get('social_youtube'),
            'social_linkedin' => Setting::get('social_linkedin'),
        ];

        return view('pages.contact', compact('contact'));
    }

    /**
     * Store contact form inquiry with honeypot and rate limit protection.
     */
    public function store(Request $request)
    {
        $siteName = Setting::get('site_name', 'Manunggaland');

        // Anti-bot honeypot check: if filled, quietly succeed without doing anything
        if ($request->filled('website_trap')) {
            return back()->with('success', "Pesan Anda berhasil dikirim! Tim {$siteName} akan segera menghubungi Anda.");
        }

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'company' => 'nullable|string|max:150',
            'email' => 'required|email|max:150',
            'whatsapp' => 'required|string|max:30',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|max:2000',
            'type' => 'nullable|string|in:buyer,petani,general',
        ]);

        Inquiry::create([
            'type' => $validated['type'] ?? 'general',
            'name' => strip_tags($validated['name']),
            'company' => strip_tags($validated['company'] ?? ''),
            'email' => strip_tags($validated['email']),
            'whatsapp' => strip_tags($validated['whatsapp']),
            'subject' => strip_tags($validated['subject'] ?? 'Pesan dari Kontak Web'),
            'message' => strip_tags($validated['message']),
            'ip_address' => $request->ip(),
            'status' => 'new',
        ]);

        return back()->with('success', "Terima kasih! Pesan dan kebutuhan Anda telah terhubung langsung ke Admin {$siteName}. Kami akan segera merespons melalui WhatsApp/Email.");
    }
}
