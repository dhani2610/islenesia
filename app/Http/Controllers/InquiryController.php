<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Setting;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    /**
     * Handle the interactive WhatsApp modal submission (Buyer vs Petani).
     * Exact implementation of the client's screenshot concept!
     */
    public function storeWidget(Request $request)
    {
        // Anti-bot honeypot check
        if ($request->filled('website_trap')) {
            $adminWa = Setting::get('whatsapp_number', '6285161313914');
            return response()->json([
                'success' => true,
                'redirect_url' => "https://wa.me/{$adminWa}",
            ]);
        }

        // Anti-Bot Captcha Verification
        $expectedCaptcha = session('captcha_chat');
        $userCaptcha = $request->input('captcha_answer');
        if ($expectedCaptcha === null || (int)$userCaptcha !== (int)$expectedCaptcha) {
            return response()->json([
                'success' => false,
                'message' => 'Verifikasi keamanan (Anti-Bot) salah. Silakan coba kembali.',
                'errors' => [
                    'captcha_answer' => ['Jawaban verifikasi keamanan salah. Silakan hitung ulang.']
                ]
            ], 422);
        }

        $validated = $request->validate([
            'role' => 'required|in:buyer,pemasok,petani,seller',
            'name' => 'required|string|max:150',
            'whatsapp' => 'required|string|max:30',
            'message' => 'required|string|max:1000',
            'product_id' => 'nullable|exists:products,id',
        ]);

        // Normalize role to buyer or pemasok
        $role = in_array($validated['role'], ['pemasok', 'petani', 'seller']) ? 'pemasok' : 'buyer';
        $isBuyer = ($role === 'buyer');

        // Consume captcha
        session()->forget('captcha_chat');

        $inquiry = Inquiry::create([
            'type' => $role,
            'name' => strip_tags($validated['name']),
            'company' => strip_tags($validated['name']),
            'whatsapp' => strip_tags($validated['whatsapp']),
            'message' => strip_tags($validated['message']),
            'product_id' => $validated['product_id'] ?? null,
            'ip_address' => $request->ip(),
            'status' => 'new',
        ]);

        // Separate target WhatsApp for Buyer vs Pemasok
        if ($isBuyer) {
            $targetWa = Setting::get('whatsapp_buyer') ?: Setting::get('whatsapp_number', '6285161313914');
        } else {
            $targetWa = Setting::get('whatsapp_pemasok') ?: Setting::get('whatsapp_number', '6285161313914');
        }

        $targetWa = preg_replace('/[^0-9]/', '', $targetWa);
        if (empty($targetWa)) {
            $targetWa = '6285161313914';
        }

        $siteName = Setting::get('site_name', 'Manunggaland');
        $roleText = $isBuyer ? 'BUYER / PEMBELI' : 'PEMASOK / SUPPLIER';
        
        $waMessage = "Halo Admin Agregator {$siteName},\n\n"
            . "Saya ingin terhubung dengan sistem {$siteName}:\n"
            . "*Keperluan:* {$roleText}\n"
            . "*Nama / Perusahaan:* {$inquiry->name}\n"
            . "*No. WhatsApp:* {$inquiry->whatsapp}\n\n"
            . "*Pesan / Kebutuhan:*\n"
            . "{$inquiry->message}\n\n"
            . "*(Tercatat otomatis di Database Sistem Agregator {$siteName} - ID: #{$inquiry->id})*";

        $redirectUrl = "https://api.whatsapp.com/send?phone={$targetWa}&text=" . urlencode($waMessage);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data Anda telah tersimpan di sistem agregator!',
                'redirect_url' => $redirectUrl,
            ]);
        }

        return redirect()->away($redirectUrl);
    }
}
