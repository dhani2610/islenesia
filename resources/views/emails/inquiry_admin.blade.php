<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Baru Masuk - Islenesia Export Desk</title>
</head>
<body style="margin: 0; padding: 0; background-color: #F1F5F9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1E293B;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
        <tr>
            <td align="center" style="padding: 24px 12px;">
                <!-- Main Container -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; background-color: #FFFFFF; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.06); border: 1px solid #E2E8F0;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #0B1B3D; padding: 28px 32px; border-bottom: 3px solid #D4AF37;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        <div style="font-size: 24px; font-weight: 800; color: #D4AF37; letter-spacing: 0.5px;">
                                            {{ $siteSettings['site_name'] ?? 'ISLENESIA' }}
                                        </div>
                                        <div style="font-size: 13px; color: #E2E8F0; margin-top: 4px;">
                                            Global Agro Commodity Aggregator & Direct Exporter
                                        </div>
                                    </td>
                                    <td align="right">
                                        <span style="background-color: rgba(212, 175, 55, 0.2); color: #D4AF37; border: 1px solid #D4AF37; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                                            INQUIRY #{{ $inquiry->id }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Status Notification Banner -->
                    <tr>
                        <td style="background-color: #FEF3C7; border-bottom: 1px solid #FDE68A; padding: 12px 32px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="font-size: 13px; color: #92400E; font-weight: 600;">
                                        🔔 Notifikasi Otomatis: Ada calon rekanan / buyer baru menghubungi melalui website.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 32px;">
                            <h2 style="font-size: 19px; color: #0B1B3D; margin-top: 0; margin-bottom: 8px;">
                                Rincian Pengajuan Lead / Permintaan Ekspor
                            </h2>
                            <p style="font-size: 14px; color: #64748B; margin-top: 0; margin-bottom: 24px;">
                                Diterima pada {{ $inquiry->created_at ? $inquiry->created_at->format('d F Y, H:i') : now()->format('d F Y, H:i') }} WIB dari IP: {{ $inquiry->ip_address ?? '-' }}
                            </p>

                            <!-- Summary Details Table -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; overflow: hidden; margin-bottom: 24px; font-size: 14px;">
                                <tr>
                                    <td style="padding: 12px 18px; width: 35%; font-weight: 700; color: #0B1B3D; border-bottom: 1px solid #E2E8F0;">Kategori / Keperluan</td>
                                    <td style="padding: 12px 18px; border-bottom: 1px solid #E2E8F0;">
                                        @if($inquiry->type === 'pemasok')
                                            <span style="background: #ECFDF5; color: #059669; padding: 3px 10px; border-radius: 12px; font-weight: 700; font-size: 12px;">🌿 PEMASOK / PETANI (JUAL)</span>
                                        @else
                                            <span style="background: #EFF6FF; color: #1D4ED8; padding: 3px 10px; border-radius: 12px; font-weight: 700; font-size: 12px;">📦 BUYER / PEMBELI (BELI)</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 18px; font-weight: 700; color: #0B1B3D; border-bottom: 1px solid #E2E8F0;">Nama Pemohon</td>
                                    <td style="padding: 12px 18px; color: #0B1B3D; font-weight: 600; border-bottom: 1px solid #E2E8F0;">
                                        {{ $inquiry->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 18px; font-weight: 700; color: #0B1B3D; border-bottom: 1px solid #E2E8F0;">Perusahaan</td>
                                    <td style="padding: 12px 18px; border-bottom: 1px solid #E2E8F0;">
                                        {{ !empty($inquiry->company) ? $inquiry->company : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 18px; font-weight: 700; color: #0B1B3D; border-bottom: 1px solid #E2E8F0;">Email Kontak</td>
                                    <td style="padding: 12px 18px; border-bottom: 1px solid #E2E8F0;">
                                        @if(!empty($inquiry->email))
                                            <a href="mailto:{{ $inquiry->email }}" style="color: #2563EB; font-weight: 600; text-decoration: none;">{{ $inquiry->email }}</a>
                                        @else
                                            <span style="color: #94A3B8;">(Tidak dicantumkan)</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 18px; font-weight: 700; color: #0B1B3D; border-bottom: 1px solid #E2E8F0;">WhatsApp / No. Telepon</td>
                                    <td style="padding: 12px 18px; border-bottom: 1px solid #E2E8F0;">
                                        @if(!empty($inquiry->whatsapp) && $inquiry->whatsapp !== '-')
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inquiry->whatsapp) }}" target="_blank" style="color: #059669; font-weight: 700; text-decoration: none;">
                                                {{ $inquiry->whatsapp }}
                                            </a>
                                        @else
                                            <span style="color: #94A3B8;">(Via Email)</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 18px; font-weight: 700; color: #0B1B3D; border-bottom: 1px solid #E2E8F0;">Komoditas Terkait</td>
                                    <td style="padding: 12px 18px; border-bottom: 1px solid #E2E8F0; font-weight: 600; color: #B45309;">
                                        {{ $inquiry->product ? $inquiry->product->name : ($inquiry->subject ?: 'Permintaan Umum Ekspor') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 18px; font-weight: 700; color: #0B1B3D;">Saluran Komunikasi Dipilih</td>
                                    <td style="padding: 12px 18px; text-transform: uppercase; font-weight: 700; font-size: 12px; color: #475569;">
                                        {{ $inquiry->channel ?? 'WhatsApp / Email' }}
                                    </td>
                                </tr>
                            </table>

                            <!-- Full Message Box -->
                            <div style="background-color: #FFFFFF; border-left: 4px solid #D4AF37; padding: 16px 20px; border-radius: 0 8px 8px 0; margin-bottom: 28px; background-color: #FAF5E8;">
                                <div style="font-size: 12px; font-weight: 800; color: #854D0E; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">
                                    PESAN / PERMINTAAN LENGKAP:
                                </div>
                                <div style="font-size: 14px; line-height: 1.6; color: #1E293B; white-space: pre-wrap;">{{ $inquiry->message }}</div>
                            </div>

                            <!-- Action Buttons -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    @if(!empty($inquiry->email))
                                        <td align="left" style="padding-right: 8px;">
                                            <a href="mailto:{{ $inquiry->email }}?subject=Re:%20Trade%20Inquiry%20{{ urlencode($inquiry->product ? $inquiry->product->name : 'Export') }}" style="display: block; text-align: center; background-color: #0B1B3D; color: #FFFFFF; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 13px;">
                                                ✉️ Balas via Email
                                            </a>
                                        </td>
                                    @endif
                                    @if(!empty($inquiry->whatsapp) && $inquiry->whatsapp !== '-')
                                        <td align="left" style="padding-left: 8px;">
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inquiry->whatsapp) }}" target="_blank" style="display: block; text-align: center; background-color: #25D366; color: #FFFFFF; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 13px;">
                                                💬 Chat WhatsApp
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #F8FAFC; border-top: 1px solid #E2E8F0; padding: 20px 32px; font-size: 12px; color: #64748B; text-align: center; line-height: 1.5;">
                            Pemberitahuan otomatis dari sistem aggregator <strong>{{ $siteSettings['site_name'] ?? 'Islenesia' }}</strong>.<br>
                            Anda dapat mengelola seluruh data lead ini melalui <a href="{{ url('/portal-access') }}" style="color: #0B1B3D; font-weight: 700; text-decoration: none;">Dashboard Admin Portal</a>.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
