<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Setting;
use App\Services\MailConfigService;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    /**
     * Handle the interactive WhatsApp & Email inquiry submission (Buyer vs Pemasok).
     * Supports European & Global Buyers preferring Official Email alongside WhatsApp.
     */
    public function storeWidget(Request $request)
    {
        // Anti-bot honeypot check
        if ($request->filled('website_trap')) {
            $adminWa = Setting::get('whatsapp_number', '6285161313914');
            return response()->json([
                'success' => true,
                'channel' => 'whatsapp',
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

        $channel = $request->input('channel', 'whatsapp');
        if (!in_array($channel, ['whatsapp', 'email', 'both'])) {
            $channel = 'whatsapp';
        }

        // Conditional validation rules based on channel
        $rules = [
            'role' => 'required|in:buyer,pemasok,petani,seller',
            'name' => 'required|string|max:150',
            'company' => 'nullable|string|max:150',
            'message' => 'required|string|max:1500',
            'product_id' => 'nullable|exists:products,id',
            'channel' => 'nullable|in:whatsapp,email,both',
        ];

        if ($channel === 'email') {
            $rules['email'] = 'required|email|max:150';
            $rules['whatsapp'] = 'nullable|string|max:35';
        } else {
            $rules['whatsapp'] = 'required|string|max:35';
            $rules['email'] = 'nullable|email|max:150';
        }

        $validated = $request->validate($rules);

        // Normalize role to buyer or pemasok
        $role = in_array($validated['role'], ['pemasok', 'petani', 'seller']) ? 'pemasok' : 'buyer';
        $isBuyer = ($role === 'buyer');

        // Consume captcha
        session()->forget('captcha_chat');

        $inquiry = Inquiry::create([
            'type' => $role,
            'name' => strip_tags($validated['name']),
            'company' => strip_tags($validated['company'] ?? $validated['name']),
            'whatsapp' => !empty($validated['whatsapp']) ? strip_tags($validated['whatsapp']) : '-',
            'email' => !empty($validated['email']) ? strip_tags($validated['email']) : null,
            'channel' => $channel,
            'message' => strip_tags($validated['message']),
            'product_id' => $validated['product_id'] ?? null,
            'ip_address' => $request->ip(),
            'status' => 'new',
        ]);

        // Trigger dynamic SMTP email dispatch (Admin Notification & English Requester Auto-Responder)
        MailConfigService::sendInquiryEmails($inquiry);

        // If channel is Email only, return instant success without WhatsApp redirection
        if ($channel === 'email') {
            $siteName = Setting::get('site_name', 'Islenesia');
            return response()->json([
                'success' => true,
                'channel' => 'email',
                'message' => "Thank you! Your official inquiry (#ISL-{$inquiry->id}) has been sent to {$siteName} Export Desk. An acknowledgment confirmation has been delivered to your email.",
                'inquiry_id' => $inquiry->id,
            ]);
        }

        // WhatsApp redirection handling
        if ($isBuyer) {
            $targetWa = Setting::get('whatsapp_buyer') ?: Setting::get('whatsapp_number', '6285161313914');
        } else {
            $targetWa = Setting::get('whatsapp_pemasok') ?: Setting::get('whatsapp_number', '6285161313914');
        }

        $targetWa = preg_replace('/[^0-9]/', '', $targetWa);
        if (empty($targetWa)) {
            $targetWa = '6285161313914';
        }

        $siteName = Setting::get('site_name', 'Islenesia');
        $roleText = $isBuyer ? 'BUYER / PEMBELI' : 'PEMASOK / SUPPLIER';
        $emailInfo = $inquiry->email ? "\n*Email:* {$inquiry->email}" : "";
        
        $waMessage = "Halo Admin Agregator {$siteName},\n\n"
            . "Saya ingin terhubung dengan sistem {$siteName}:\n"
            . "*Keperluan:* {$roleText}\n"
            . "*Nama / Perusahaan:* {$inquiry->name}\n"
            . "*No. WhatsApp:* {$inquiry->whatsapp}"
            . $emailInfo . "\n\n"
            . "*Pesan / Kebutuhan:*\n"
            . "{$inquiry->message}\n\n"
            . "*(Tercatat otomatis di Database Sistem Agregator {$siteName} - ID: #{$inquiry->id})*";

        $redirectUrl = "https://api.whatsapp.com/send?phone={$targetWa}&text=" . urlencode($waMessage);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'channel' => 'whatsapp',
                'message' => 'Data Anda telah tersimpan di sistem agregator!',
                'redirect_url' => $redirectUrl,
                'inquiry_id' => $inquiry->id,
            ]);
        }

        return redirect()->away($redirectUrl);
    }
}
