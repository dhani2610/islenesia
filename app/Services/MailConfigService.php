<?php

namespace App\Services;

use App\Models\Inquiry;
use App\Models\Setting;
use App\Mail\InquiryAdminNotification;
use App\Mail\InquiryRequesterConfirmation;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailConfigService
{
    /**
     * Dynamically configure SMTP transport from database settings or environment fallbacks.
     */
    public static function configure(): void
    {
        $host = Setting::get('smtp_host', env('MAIL_HOST', 'mail.islenesia.com'));
        $port = (int) Setting::get('smtp_port', env('MAIL_PORT', 465));
        $encryption = Setting::get('smtp_encryption', env('MAIL_ENCRYPTION', 'ssl'));
        $username = Setting::get('smtp_username', env('MAIL_USERNAME', 'noreply@islenesia.com'));
        $password = Setting::get('smtp_password', env('MAIL_PASSWORD', '=}' . 'Wv#(oYPS)S#Y.2'));
        $fromAddress = Setting::get('mail_from_address', env('MAIL_FROM_ADDRESS', 'noreply@islenesia.com'));
        $fromName = Setting::get('mail_from_name', env('MAIL_FROM_NAME', 'Islenesia Agro Export Desk'));

        // Normalize encryption
        if ($encryption === 'none' || empty($encryption)) {
            $encryption = null;
        }

        Config::set('mail.default', 'smtp');
        Config::set('mail.mailers.smtp', [
            'transport' => 'smtp',
            'host' => $host,
            'port' => $port,
            'encryption' => $encryption,
            'username' => $username,
            'password' => $password,
            'timeout' => 15,
            'local_domain' => env('MAIL_EHLO_DOMAIN'),
        ]);

        Config::set('mail.from.address', $fromAddress);
        Config::set('mail.from.name', $fromName);
    }

    /**
     * Send email notifications for an incoming inquiry:
     * 1. Notification to Admin / Export Desk (in Indonesian)
     * 2. Confirmation auto-responder to Requester / Buyer (in English)
     */
    public static function sendInquiryEmails(Inquiry $inquiry): array
    {
        $status = [
            'admin_sent' => false,
            'requester_sent' => false,
            'errors' => [],
        ];

        // Check if SMTP is activated
        if (Setting::get('smtp_active', '1') === '0') {
            return $status;
        }

        try {
            self::configure();
        } catch (\Throwable $e) {
            Log::error('SMTP Configuration Error: ' . $e->getMessage());
            $status['errors'][] = 'Config error: ' . $e->getMessage();
            return $status;
        }

        // 1. Send Admin Notification
        try {
            $adminEmail = Setting::get('mail_receive_address');
            if (empty($adminEmail)) {
                $adminEmail = Setting::get('email', 'noreply@islenesia.com');
            }

            if (!empty($adminEmail) && filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
                Mail::to($adminEmail)->send(new InquiryAdminNotification($inquiry));
                $status['admin_sent'] = true;
            }
        } catch (\Throwable $e) {
            Log::error('Admin Inquiry Mail Dispatch Failed: ' . $e->getMessage(), [
                'inquiry_id' => $inquiry->id,
            ]);
            $status['errors'][] = 'Admin mail error: ' . $e->getMessage();
        }

        // 2. Send Auto-Responder to Requester / Buyer (in English)
        try {
            if (!empty($inquiry->email) && filter_var($inquiry->email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($inquiry->email)->send(new InquiryRequesterConfirmation($inquiry));
                $status['requester_sent'] = true;
            }
        } catch (\Throwable $e) {
            Log::error('Requester Inquiry Mail Dispatch Failed: ' . $e->getMessage(), [
                'inquiry_id' => $inquiry->id,
            ]);
            $status['errors'][] = 'Requester mail error: ' . $e->getMessage();
        }

        return $status;
    }

    /**
     * Send a test email to verify SMTP configuration from Admin Panel.
     */
    public static function testConnection(?string $targetEmail = null): array
    {
        try {
            self::configure();

            $recipient = $targetEmail ?: Setting::get('mail_receive_address', Setting::get('email', 'info@islenesia.com'));
            if (empty($recipient) || !filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
                return [
                    'success' => false,
                    'message' => 'Alamat email tujuan pengujian tidak valid.',
                ];
            }

            $siteName = Setting::get('site_name', 'Islenesia');
            $serverTime = now()->format('d M Y - H:i:s T');
            $host = Setting::get('smtp_host', 'mail.islenesia.com');
            $port = Setting::get('smtp_port', '465');

            $htmlContent = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; background: #ffffff; border: 1px solid #E2E8F0; border-radius: 12px; overflow: hidden;'>
                    <div style='background: #0B1B3D; padding: 24px; text-align: center; border-bottom: 3px solid #D4AF37;'>
                        <h2 style='color: #D4AF37; margin: 0; font-size: 22px; letter-spacing: 0.5px;'>{$siteName} Mail System</h2>
                        <p style='color: #E2E8F0; margin: 6px 0 0; font-size: 13px;'>Uji Coba Koneksi SMTP cPanel Berhasil!</p>
                    </div>
                    <div style='padding: 24px; color: #1E293B; line-height: 1.6;'>
                        <p style='margin-top: 0;'>Halo Administrator <strong>{$siteName}</strong>,</p>
                        <p>Ini adalah email konfirmasi bahwa integrasi <strong>SMTP cPanel / Hosting</strong> pada website Anda telah aktif, terhubung dengan aman (SSL/TLS), dan siap mengirimkan notifikasi inquiry serta auto-responder kepada buyer internasional (Eropa, China, dll).</p>
                        <table style='width: 100%; border-collapse: collapse; margin: 20px 0; background: #F8FAFC; border-radius: 8px; font-size: 14px;'>
                            <tr>
                                <td style='padding: 10px 14px; font-weight: bold; width: 40%; border-bottom: 1px solid #E2E8F0;'>SMTP Host</td>
                                <td style='padding: 10px 14px; border-bottom: 1px solid #E2E8F0;'>{$host}</td>
                            </tr>
                            <tr>
                                <td style='padding: 10px 14px; font-weight: bold; border-bottom: 1px solid #E2E8F0;'>SMTP Port & Enkripsi</td>
                                <td style='padding: 10px 14px; border-bottom: 1px solid #E2E8F0;'>Port {$port} (SSL/TLS)</td>
                            </tr>
                            <tr>
                                <td style='padding: 10px 14px; font-weight: bold; border-bottom: 1px solid #E2E8F0;'>Waktu Pengujian</td>
                                <td style='padding: 10px 14px; border-bottom: 1px solid #E2E8F0;'>{$serverTime}</td>
                            </tr>
                            <tr>
                                <td style='padding: 10px 14px; font-weight: bold;'>Status Sistem</td>
                                <td style='padding: 10px 14px; color: #10B981; font-weight: bold;'>&check; READY & ACTIVE</td>
                            </tr>
                        </table>
                        <p style='font-size: 13px; color: #64748B; margin-bottom: 0;'>
                            Email ini dihasilkan secara otomatis oleh sistem admin panel {$siteName}.
                        </p>
                    </div>
                </div>
            ";

            Mail::html($htmlContent, function ($msg) use ($recipient, $siteName) {
                $msg->to($recipient)
                    ->subject("[{$siteName}] Uji Coba Koneksi Email SMTP Berhasil");
            });

            return [
                'success' => true,
                'message' => "Email uji coba berhasil dikirim ke {$recipient} melalui server cPanel!",
            ];
        } catch (\Throwable $e) {
            Log::error('SMTP Test Failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Gagal mengirim email: ' . $e->getMessage(),
            ];
        }
    }
}
