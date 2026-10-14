@extends('layouts.admin')

@section('title', 'Pengaturan Website & SEO')
@section('header_title', 'Pengaturan Website, Branding & SEO')

@section('content')

<style>
    .settings-nav-tabs {
        display: flex;
        gap: 0.5rem;
        border-bottom: 2px solid var(--admin-border);
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }
    .settings-tab-btn {
        background: transparent;
        border: none;
        padding: 0.85rem 1.25rem;
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--admin-muted);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
        transition: all 0.2s;
    }
    .settings-tab-btn:hover {
        color: var(--admin-navy-surface);
    }
    .settings-tab-btn.active {
        color: var(--admin-navy-surface);
        border-bottom-color: var(--admin-gold);
    }
    .settings-tab-pane {
        display: none;
    }
    .settings-tab-pane.active {
        display: block;
    }
</style>

<div class="admin-card">
    <div class="settings-nav-tabs">
        <button type="button" class="settings-tab-btn active" onclick="switchSettingTab('tab-branding')">
            <i class="fa-solid fa-paintbrush text-gold"></i>
            <span>Identitas & Logo</span>
        </button>
        <button type="button" class="settings-tab-btn" onclick="switchSettingTab('tab-home')">
            <i class="fa-solid fa-house text-gold"></i>
            <span>Beranda & Slider</span>
        </button>
        <button type="button" class="settings-tab-btn" onclick="switchSettingTab('tab-about')">
            <i class="fa-solid fa-building text-gold"></i>
            <span>Tentang Kami</span>
        </button>
        <button type="button" class="settings-tab-btn" onclick="switchSettingTab('tab-contact')">
            <i class="fa-solid fa-address-book text-gold"></i>
            <span>Kontak & Maps</span>
        </button>
        <button type="button" class="settings-tab-btn" onclick="switchSettingTab('tab-social')">
            <i class="fa-solid fa-share-nodes text-gold"></i>
            <span>Media Sosial</span>
        </button>
        <button type="button" class="settings-tab-btn" onclick="switchSettingTab('tab-seo')">
            <i class="fa-solid fa-chart-line text-gold"></i>
            <span>SEO & Meta Tag</span>
        </button>
        <button type="button" class="settings-tab-btn" onclick="switchSettingTab('tab-stats')">
            <i class="fa-solid fa-chart-simple text-gold"></i>
            <span>Statistik Counter</span>
        </button>
        <button type="button" class="settings-tab-btn" onclick="switchSettingTab('tab-smtp')">
            <i class="fa-solid fa-envelope-open-text text-gold"></i>
            <span>Email SMTP & Hosting</span>
        </button>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- TAB 1: Identitas & Logo -->
        <div class="settings-tab-pane active" id="tab-branding">
            <h3 style="font-size: 1.15rem; color: var(--admin-navy-surface); margin-bottom: 1.25rem;">Identitas Website & Upload Logo/Favicon</h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Nama Website / Brand *</label>
                    <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Islenesia' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                    <span style="font-size: 0.75rem; color: var(--admin-muted);">Nama ini akan otomatis tampil di navbar, footer, dan pesan WhatsApp.</span>
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Tagline Slogan</label>
                    <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? 'Premium Indonesian Agricultural & Natural Commodity Exporter' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Nama Badan Usaha / PT Resmi</label>
                    <input type="text" name="company_name" value="{{ $settings['company_name'] ?? 'PT Islenesia Agro Nusantara' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Tahun Berdiri Perusahaan</label>
                    <input type="text" name="company_established" value="{{ $settings['company_established'] ?? '2019' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Deskripsi Singkat Perusahaan (Tampil di Footer)</label>
                <textarea name="site_description" rows="3" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">{{ $settings['site_description'] ?? '' }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <!-- Logo Upload -->
                <div style="background: #F8FAFC; border: 1px solid var(--admin-border); border-radius: 12px; padding: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Logo Website (PNG, SVG, WebP)</label>
                    <div style="margin-bottom: 0.75rem;">
                        @if(!empty($settings['site_logo']) && (file_exists(public_path('storage/' . $settings['site_logo'])) || file_exists(storage_path('app/public/' . $settings['site_logo']))))
                            <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo" style="height: 48px; width: auto; background: #0B1B3D; padding: 6px; border-radius: 6px;">
                        @else
                            <img src="{{ asset('images/branding/logo.svg') }}" alt="Logo" style="height: 48px; width: auto; background: #0B1B3D; padding: 6px; border-radius: 6px;">
                        @endif
                    </div>
                    <input type="file" name="site_logo" accept="image/*" class="form-input" style="width: 100%; padding: 0.5rem; border: 1.5px solid var(--admin-border); border-radius: 6px; font-size: 0.8125rem;">
                </div>

                <!-- Favicon Upload -->
                <div style="background: #F8FAFC; border: 1px solid var(--admin-border); border-radius: 12px; padding: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Favicon Browser (ICO, SVG, PNG)</label>
                    <div style="margin-bottom: 0.75rem;">
                        @if(!empty($settings['site_favicon']) && (file_exists(public_path('storage/' . $settings['site_favicon'])) || file_exists(storage_path('app/public/' . $settings['site_favicon']))))
                            <img src="{{ asset('storage/' . $settings['site_favicon']) }}" alt="Favicon" style="height: 32px; width: 32px;">
                        @else
                            <img src="{{ asset('images/branding/favicon.svg') }}" alt="Favicon" style="height: 32px; width: 32px;">
                        @endif
                    </div>
                    <input type="file" name="site_favicon" accept="image/*" class="form-input" style="width: 100%; padding: 0.5rem; border: 1.5px solid var(--admin-border); border-radius: 6px; font-size: 0.8125rem;">
                </div>
            </div>
        </div>

        <!-- TAB 2: Kontak & Maps -->
        <div class="settings-tab-pane" id="tab-contact">
            <h3 style="font-size: 1.15rem; color: var(--admin-navy-surface); margin-bottom: 1.25rem;">Informasi Kontak & Embed Google Maps</h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.25rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Email Resmi *</label>
                    <input type="email" name="email" value="{{ $settings['email'] ?? 'info@islenesia.com' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Nomor Telepon Kantor</label>
                    <input type="text" name="phone" value="{{ $settings['phone'] ?? '+62 851-6131-3914' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Nomor WhatsApp Utama (Default) *</label>
                    <input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? '6285161313914' }}" placeholder="62812xxxx (tanpa tanda + atau spasi)" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
            </div>

            <!-- Pengaturan WhatsApp Terpisah: Buyer vs Pemasok -->
            <div style="background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 12px; padding: 1.25rem; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <i class="fa-brands fa-whatsapp text-gold" style="font-size: 1.2rem; color: #10B981;"></i>
                    <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--admin-navy-surface); margin: 0;">Pengaturan WhatsApp Khusus (Buyer vs Pemasok)</h4>
                </div>
                <p style="font-size: 0.8rem; color: var(--admin-muted); margin-bottom: 1rem;">
                    Anda dapat membedakan nomor WhatsApp admin yang menangani <strong>Buyer (Pembeli Komoditas)</strong> dan <strong>Pemasok (Supplier / Penjual)</strong>. Jika dikosongkan, sistem akan otomatis menggunakan Nomor WhatsApp Utama di atas.
                </p>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #1E40AF; margin-bottom: 0.4rem;">
                            <i class="fa-solid fa-box" style="margin-right: 0.3rem;"></i> Nomor WhatsApp Khusus Buyer (Beli)
                        </label>
                        <input type="text" name="whatsapp_buyer" value="{{ $settings['whatsapp_buyer'] ?? '' }}" placeholder="Contoh: 6281234567890 (kosongkan jika sama)" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; background: #FFFFFF;">
                        <span style="font-size: 0.72rem; color: #64748B; margin-top: 0.25rem; display: block;">Target tujuan saat pengunjung memilih tab "Saya Buyer (Beli)"</span>
                    </div>

                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #065F46; margin-bottom: 0.4rem;">
                            <i class="fa-solid fa-truck-ramp-box" style="margin-right: 0.3rem;"></i> Nomor WhatsApp Khusus Pemasok (Jual)
                        </label>
                        <input type="text" name="whatsapp_pemasok" value="{{ $settings['whatsapp_pemasok'] ?? '' }}" placeholder="Contoh: 6289876543210 (kosongkan jika sama)" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; background: #FFFFFF;">
                        <span style="font-size: 0.72rem; color: #64748B; margin-top: 0.25rem; display: block;">Target tujuan saat pengunjung memilih tab "Saya Pemasok (Jual)"</span>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Alamat Kantor Lengkap</label>
                <textarea name="address" rows="3" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">{{ $settings['address'] ?? '' }}</textarea>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Embed Google Maps (&lt;iframe ...&gt;&lt;/iframe&gt;)</label>
                <textarea name="maps_embed" rows="4" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;" placeholder="Salin kode semat peta HTML dari Google Maps di sini...">{{ $settings['maps_embed'] ?? '' }}</textarea>
            </div>
        </div>

        <!-- TAB 3: Media Sosial Dinamis -->
        <div class="settings-tab-pane" id="tab-social">
            <h3 style="font-size: 1.15rem; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">Media Sosial Resmi Perusahaan</h3>
            <p style="font-size: 0.825rem; color: var(--admin-muted); margin-bottom: 1.5rem;">Masukkan tautan profil media sosial Anda (TikTok, Facebook, Instagram, YouTube, LinkedIn, X).</p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">
                        <i class="fa-brands fa-instagram" style="color: #E1306C; margin-right: 0.35rem;"></i> Instagram URL
                    </label>
                    <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}" placeholder="https://instagram.com/akun" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">
                        <i class="fa-brands fa-facebook" style="color: #1877F2; margin-right: 0.35rem;"></i> Facebook URL
                    </label>
                    <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}" placeholder="https://facebook.com/halaman" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">
                        <i class="fa-brands fa-tiktok" style="color: #000000; margin-right: 0.35rem;"></i> TikTok URL
                    </label>
                    <input type="url" name="social_tiktok" value="{{ $settings['social_tiktok'] ?? '' }}" placeholder="https://tiktok.com/@akun" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">
                        <i class="fa-brands fa-youtube" style="color: #FF0000; margin-right: 0.35rem;"></i> YouTube Channel URL
                    </label>
                    <input type="url" name="social_youtube" value="{{ $settings['social_youtube'] ?? '' }}" placeholder="https://youtube.com/@channel" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">
                        <i class="fa-brands fa-linkedin" style="color: #0A66C2; margin-right: 0.35rem;"></i> LinkedIn Company URL
                    </label>
                    <input type="url" name="social_linkedin" value="{{ $settings['social_linkedin'] ?? '' }}" placeholder="https://linkedin.com/company/nama" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">
                        <i class="fa-brands fa-x-twitter" style="color: #0F172A; margin-right: 0.35rem;"></i> Twitter / X URL
                    </label>
                    <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}" placeholder="https://x.com/akun" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
            </div>
        </div>

        <!-- TAB 4: SEO Meta Global -->
        <div class="settings-tab-pane" id="tab-seo">
            <h3 style="font-size: 1.15rem; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">Optimasi Mesin Pencari (SEO Google & Social Sharing)</h3>
            <p style="font-size: 0.825rem; color: var(--admin-muted); margin-bottom: 1.5rem;">Konfigurasi tag meta untuk peringkat pencarian internasional di Google.</p>

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Default Meta Title *</label>
                <input type="text" name="meta_title" value="{{ $settings['meta_title'] ?? '' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Default Meta Description *</label>
                <textarea name="meta_description" rows="3" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">{{ $settings['meta_description'] ?? '' }}</textarea>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Default Meta Keywords</label>
                <input type="text" name="meta_keywords" value="{{ $settings['meta_keywords'] ?? '' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            </div>

            <div style="background: #F8FAFC; border: 1px solid var(--admin-border); border-radius: 12px; padding: 1.25rem; margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">OpenGraph Share Image (Preview WhatsApp, Facebook, LinkedIn)</label>
                @if(!empty($settings['meta_og_image']) && (file_exists(public_path('storage/' . $settings['meta_og_image'])) || file_exists(storage_path('app/public/' . $settings['meta_og_image']))))
                    <div style="margin-bottom: 0.75rem; max-width: 240px; border-radius: 8px; overflow: hidden; border: 1px solid var(--admin-border);">
                        <img src="{{ asset('storage/' . $settings['meta_og_image']) }}" alt="OG Image" style="width: 100%; height: auto;">
                    </div>
                @endif
                <input type="file" name="meta_og_image" accept="image/*" class="form-input" style="width: 100%; padding: 0.5rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.8125rem;">
            </div>
        </div>

        <!-- TAB 5: Statistik Counter Beranda -->
        <div class="settings-tab-pane" id="tab-stats">
            <h3 style="font-size: 1.15rem; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">Statistik & Angka Counter di Beranda</h3>
            <p style="font-size: 0.825rem; color: var(--admin-muted); margin-bottom: 1.5rem;">Angka-angka pencapaian ekspor yang tampil di bagian Hero beranda.</p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Jumlah Negara Tujuan Ekspor</label>
                    <input type="text" name="exported_countries_count" value="{{ $settings['exported_countries_count'] ?? '28+' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Volume Komoditas Terkirim (Metrik Ton)</label>
                    <input type="text" name="metric_tons_exported" value="{{ $settings['metric_tons_exported'] ?? '5,400+' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Jumlah Petani Mitra Nusantara</label>
                    <input type="text" name="partner_farmers_count" value="{{ $settings['partner_farmers_count'] ?? '1,450+' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Persentase Kepuasan Buyer</label>
                    <input type="text" name="buyer_satisfaction" value="{{ $settings['buyer_satisfaction'] ?? '99.4%' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
            </div>
        </div>

        <!-- TAB: Konten Beranda & Slider CMS -->
        <div class="settings-tab-pane" id="tab-home">
            <div style="background: linear-gradient(135deg, rgba(6, 17, 36, 0.03) 0%, rgba(212, 175, 55, 0.08) 100%); border: 1.5px dashed var(--admin-gold); border-radius: 12px; padding: 1.5rem; margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h4 style="font-size: 1.05rem; color: var(--admin-navy-surface); margin-bottom: 0.35rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-images" style="color: var(--admin-gold);"></i>
                        <span>Hero Image Slider (Kini Dinamis - Bebas Tambah / Hapus Slide)</span>
                    </h4>
                    <p style="font-size: 0.825rem; color: var(--admin-muted); margin: 0;">
                        Anda dapat menambah sebanyak mungkin foto slider, menghapus foto yang tidak terpakai (misal hanya 1 atau 2 slide), dan mengatur urutannya dengan mudah.
                    </p>
                </div>
                <a href="{{ route('admin.sliders.index') }}" class="btn-admin btn-admin-gold">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>Kelola Hero Slider (CRUD) &rarr;</span>
                </a>
            </div>

            <h3 style="font-size: 1.15rem; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">Teks Bagian Hero Utama Beranda</h3>
            <p style="font-size: 0.825rem; color: var(--admin-muted); margin-bottom: 1.5rem;">Atur judul, deskripsi, jaminan mutu ekspor, dan kartu preview komoditas.</p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Badge Atas Hero</label>
                    <input type="text" name="hero_badge" value="{{ $settings['hero_badge'] ?? 'INDONESIA COMMODITY EXPORTER' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Jaminan Mutu & Sertifikasi Ekspor *</label>
                    <input type="text" name="loading_port" value="{{ $settings['loading_port'] ?? 'Lab Tested & Single Origin' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                    <span style="font-size: 0.75rem; color: var(--admin-muted);">Tampil di kartu hero: "Jaminan Mutu: [Teks]"</span>
                </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Judul Utama Hero (H1)</label>
                <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? 'Agregator Komoditas Ekspor Pertanian Unggulan Indonesia' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Subjudul / Paragraf Pengantar Hero</label>
                <textarea name="hero_subtitle" rows="3" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">{{ $settings['hero_subtitle'] ?? 'Menghubungkan petani lokal nusantara dengan buyer pasar ekspor internasional di Eropa, China, dan Asia dengan kepastian volume kontainer, pengujian lab tersertifikasi, dan integritas bisnis terpercaya.' }}</textarea>
            </div>

            <h3 style="font-size: 1.15rem; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">Teks Header Bagian Katalog di Beranda (CMS)</h3>
            <p style="font-size: 0.825rem; color: var(--admin-muted); margin-bottom: 1.5rem;">Atur badge, judul utama, dan subjudul bagian katalog produk di halaman depan agar klien dapat mengubahnya sewaktu-waktu.</p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Badge Header Bagian Katalog</label>
                    <input type="text" name="home_catalog_badge" value="{{ $settings['home_catalog_badge'] ?? 'KATALOG KOMODITAS UNGGULAN' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Judul Utama Bagian Katalog</label>
                    <input type="text" name="home_catalog_title" value="{{ $settings['home_catalog_title'] ?? 'Hasil Bumi Terbaik dari Perkebunan Nusantara' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Deskripsi / Subjudul Bagian Katalog</label>
                <textarea name="home_catalog_subtitle" rows="2" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">{{ $settings['home_catalog_subtitle'] ?? 'Pasokan langsung dari petani mitra terpilih, dikurasi ketat sesuai standar mutu pasar Eropa, China, dan global.' }}</textarea>
            </div>

            <h3 style="font-size: 1.15rem; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">Teks Alur Rantai Pasok & Keunggulan Ekspor</h3>
            <p style="font-size: 0.825rem; color: var(--admin-muted); margin-bottom: 1.5rem;">Atur judul dan deskripsi seksi alur kerja (Farm to Port) dan keunggulan.</p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Judul Alur Pasok Global</label>
                    <input type="text" name="workflow_title" value="{{ $settings['workflow_title'] ?? 'Bagaimana Islenesia Menjaga Rantai Pasok Global' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Subjudul Alur Pasok</label>
                    <input type="text" name="workflow_subtitle" value="{{ $settings['workflow_subtitle'] ?? 'Kami merestrukturisasi rantai pasok tradisional menjadi jalur ekspor yang transparan, aman, dan berdaya saing tinggi.' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Judul Keunggulan Ekspor</label>
                    <input type="text" name="why_choose_title" value="{{ $settings['why_choose_title'] ?? 'Mengapa Buyer Eropa & China Memilih Islenesia' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Subjudul Keunggulan</label>
                    <input type="text" name="why_choose_subtitle" value="{{ $settings['why_choose_subtitle'] ?? 'Integritas transaksi bisnis internasional, kepastian volume kontainer, dan transparansi standar mutu tanpa perantara gelap.' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
            </div>

            <h3 style="font-size: 1.15rem; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">Teks Call-To-Action (CTA) Bawah Beranda</h3>
            <p style="font-size: 0.825rem; color: var(--admin-muted); margin-bottom: 1.5rem;">Atur judul dan penjelasan di bagian banner ajakan kerja sama sebelum footer.</p>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Judul CTA</label>
                <input type="text" name="cta_title" value="{{ $settings['cta_title'] ?? 'Siap Menghubungkan Kebutuhan Komoditas Anda dengan Sumber Terbaik?' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Deskripsi CTA</label>
                <textarea name="cta_subtitle" rows="3" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">{{ $settings['cta_subtitle'] ?? 'Baik Anda Buyer Internasional yang mencari kuota komoditas premium, maupun Petani Lokal yang ingin menjual hasil panen, sistem agregator kami siap melayani.' }}</textarea>
            </div>
        </div>

        <!-- TAB: Konten Tentang Kami CMS -->
        <div class="settings-tab-pane" id="tab-about">
            <h3 style="font-size: 1.15rem; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">Header Banner Halaman Tentang Kami</h3>
            <p style="font-size: 0.825rem; color: var(--admin-muted); margin-bottom: 1.5rem;">Atur judul dan deskripsi di banner atas halaman Tentang Kami.</p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Badge Header</label>
                    <input type="text" name="about_hero_badge" value="{{ $settings['about_hero_badge'] ?? 'TENTANG ISLENESIA' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Judul Banner (H1)</label>
                    <input type="text" name="about_hero_title" value="{{ $settings['about_hero_title'] ?? 'Membangun Reputasi Agro Nusantara di Dunia' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Subjudul / Paragraf Banner</label>
                <textarea name="about_hero_subtitle" rows="2" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">{{ $settings['about_hero_subtitle'] ?? 'Agregator komoditas agrikultur terpercaya dengan komitmen mutu internasional, transparansi rantai pasok, dan pemberdayaan petani lokal.' }}</textarea>
            </div>

            <h3 style="font-size: 1.15rem; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">Kisah & Sejarah Perusahaan (Story)</h3>
            <p style="font-size: 0.825rem; color: var(--admin-muted); margin-bottom: 1.5rem;">Latar belakang dan narasi profesional perusahaan.</p>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Kisah Perusahaan - Paragraf 1</label>
                <textarea name="about_story" rows="4" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">{{ $settings['about_story'] ?? 'Islenesia didirikan dengan tekad kuat untuk mengangkat komoditas pertanian terbaik Indonesia ke panggung internasional. Beroperasi sebagai agregator terpercaya, kami bekerja sama langsung dengan lebih dari 1.400 petani mitra di berbagai sentra perkebunan nusantara.' }}</textarea>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Kisah Perusahaan - Paragraf 2 (Pemangkasan Perantara & Transparansi)</label>
                <textarea name="about_story_p2" rows="3" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">{{ $settings['about_story_p2'] ?? 'Dengan memangkas rantai perantara yang tidak efisien, kami memastikan petani memperoleh harga yang adil serta pembeli internasional (Eropa, China, Asia Timur, dan Amerika) mendapatkan kepastian pasokan, transparansi mutu laboratorium, dan harga yang sangat kompetitif.' }}</textarea>
            </div>

            <h3 style="font-size: 1.15rem; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">Visi & Misi Strategis</h3>
            <p style="font-size: 0.825rem; color: var(--admin-muted); margin-bottom: 1.5rem;">Arah strategis dan komitmen kualitas bisnis ekspor.</p>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Visi Perusahaan</label>
                <textarea name="about_vision" rows="3" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">{{ $settings['about_vision'] ?? 'Menjadi agregator komoditas agrikultur nomor satu di Asia Tenggara yang menghubungkan ribuan petani nusantara ke jaringan pasar internasional dengan standar mutu dunia, transparansi, dan keberlanjutan.' }}</textarea>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Misi Strategis (Dapat berupa poin-poin 1, 2, 3)</label>
                <textarea name="about_mission" rows="4" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">{{ $settings['about_mission'] ?? "1. Menjaga standar kualitas ekspor tertinggi melalui kontrol laboratorium bersertifikasi dan proses QC ketat.\n2. Memberdayakan petani lokal melalui kemitraan yang adil dan pelatihan pasca-panen berstandar global.\n3. Memberikan kepastian suplai, legalitas ekspor terpercaya, dan kecepatan logistik ke pelabuhan utama Eropa, China, dan dunia." }}</textarea>
            </div>

            <h3 style="font-size: 1.15rem; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">Pasar Destinasi Ekspor</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Judul Seksi Destinasi Pasar</label>
                    <input type="text" name="about_market_title" value="{{ $settings['about_market_title'] ?? 'Pasar Global yang Kami Layani' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Subjudul Seksi Destinasi Pasar</label>
                    <input type="text" name="about_market_subtitle" value="{{ $settings['about_market_subtitle'] ?? 'Jaringan logistik terintegrasi kami mengirimkan kontainer komoditas secara rutin ke pelabuhan-pelabuhan utama dunia.' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>
            </div>
        </div>

        <!-- TAB 8: Email SMTP & cPanel Hosting -->
        <div class="settings-tab-pane" id="tab-smtp">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h3 style="font-size: 1.15rem; color: var(--admin-navy-surface); margin-bottom: 0.35rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-envelope-open-text text-gold"></i>
                        <span>Pengaturan Email SMTP & Hosting (cPanel)</span>
                    </h3>
                    <p style="font-size: 0.85rem; color: var(--admin-muted); margin: 0;">
                        Konfigurasi pengiriman email otomatis menggunakan akun email hosting cPanel (seperti <code>noreply@islenesia.com</code>).
                    </p>
                </div>
                <div style="display: flex; align-items: center; gap: 0.75rem; background: #F8FAFC; border: 1.5px solid var(--admin-border); padding: 0.5rem 1rem; border-radius: 10px;">
                    <label style="font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin: 0; cursor: pointer;" for="smtp_active_toggle">
                        Aktifkan Layanan Email SMTP:
                    </label>
                    <input type="hidden" name="smtp_active" value="0">
                    <input type="checkbox" name="smtp_active" value="1" id="smtp_active_toggle" {{ ($settings['smtp_active'] ?? '1') == '1' ? 'checked' : '' }} style="width: 1.25rem; height: 1.25rem; accent-color: var(--admin-gold); cursor: pointer;">
                </div>
            </div>

            <!-- cPanel Quick Info Banner -->
            <div style="background: linear-gradient(135deg, rgba(11,27,61,0.04), rgba(212,175,55,0.08)); border: 1.5px solid rgba(212,175,55,0.35); border-radius: 12px; padding: 1.25rem 1.5rem; margin-bottom: 2rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                    <i class="fa-solid fa-server text-gold" style="font-size: 1.25rem;"></i>
                    <h4 style="font-size: 0.95rem; color: var(--admin-navy-surface); margin: 0; font-weight: 700;">Integrasi Email Hosting cPanel Resmi</h4>
                </div>
                <p style="font-size: 0.85rem; color: var(--admin-navy-surface); line-height: 1.6; margin: 0;">
                    Website ini terhubung langsung ke akun email hosting cPanel Anda. Setiap ada buyer (khususnya dari Eropa / luar negeri) yang mengajukan <strong>Request a Quote</strong> via Email, sistem akan otomatis:
                </p>
                <ul style="font-size: 0.825rem; color: var(--admin-muted); margin: 0.5rem 0 0 1.25rem; padding: 0; line-height: 1.6;">
                    <li>Mengirimkan notifikasi lengkap data lead & inquiry ke <strong>Email Admin / Meja Ekspor</strong>.</li>
                    <li>Mengirimkan <strong>Auto-Responder resmi dalam Bahasa Inggris</strong> (Trade Inquiry Acknowledgment) ke inbox email buyer, memastikan reputasi profesional dan respon instan 24 jam.</li>
                </ul>
            </div>

            <!-- Server Settings Form Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Outgoing Mail Server (SMTP Host) *</label>
                    <input type="text" name="smtp_host" value="{{ $settings['smtp_host'] ?? 'mail.islenesia.com' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;" placeholder="Contoh: mail.islenesia.com">
                    <span style="font-size: 0.75rem; color: var(--admin-muted);">Biasanya berupa <code>mail.domainanda.com</code> atau hostname server cPanel.</span>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">SMTP Port *</label>
                        <input type="number" name="smtp_port" value="{{ $settings['smtp_port'] ?? '465' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;" placeholder="465 / 587">
                        <span style="font-size: 0.75rem; color: var(--admin-muted);">Port 465 (SSL) atau 587 (TLS).</span>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Enkripsi Keamanan</label>
                        <select name="smtp_encryption" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                            <option value="ssl" {{ ($settings['smtp_encryption'] ?? 'ssl') === 'ssl' ? 'selected' : '' }}>SSL (Port 465 - Rekomendasi)</option>
                            <option value="tls" {{ ($settings['smtp_encryption'] ?? '') === 'tls' ? 'selected' : '' }}>TLS (Port 587)</option>
                            <option value="none" {{ ($settings['smtp_encryption'] ?? '') === 'none' ? 'selected' : '' }}>None (Tidak Enkripsi)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Username SMTP (Email Akun cPanel) *</label>
                    <input type="text" name="smtp_username" value="{{ $settings['smtp_username'] ?? 'noreply@islenesia.com' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;" placeholder="noreply@islenesia.com">
                    <span style="font-size: 0.75rem; color: var(--admin-muted);">Alamat email lengkap yang terdaftar di Email Accounts cPanel.</span>
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Password Akun Email cPanel *</label>
                    <div style="position: relative;">
                        <input type="password" name="smtp_password" id="smtpPasswordInput" value="{{ $settings['smtp_password'] ?? '=}Wv#(oYPS)S#Y.2' }}" class="form-input" style="width: 100%; padding: 0.75rem 2.5rem 0.75rem 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                        <button type="button" onclick="toggleSmtpPassword()" style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--admin-muted); cursor: pointer;" title="Lihat / Sembunyikan Password">
                            <i class="fa-regular fa-eye" id="smtpPasswordEye"></i>
                        </button>
                    </div>
                    <span style="font-size: 0.75rem; color: var(--admin-muted);">Password akun email yang dibuat di cPanel.</span>
                </div>
            </div>

            <h4 style="font-size: 1rem; color: var(--admin-navy-surface); margin-top: 1.5rem; margin-bottom: 1rem; font-weight: 700;">Pengirim & Penerima Email</h4>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Alamat Email Pengirim (From Address) *</label>
                    <input type="email" name="mail_from_address" value="{{ $settings['mail_from_address'] ?? 'noreply@islenesia.com' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;" placeholder="noreply@islenesia.com">
                    <span style="font-size: 0.75rem; color: var(--admin-muted);">Sebaiknya sama dengan username SMTP agar tidak ditolak filter spam.</span>
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Nama Pengirim (From Name) *</label>
                    <input type="text" name="mail_from_name" value="{{ $settings['mail_from_name'] ?? 'Islenesia Agro Export Desk' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;" placeholder="Islenesia Agro Export Desk">
                    <span style="font-size: 0.75rem; color: var(--admin-muted);">Nama pengirim yang tampil di kotak masuk buyer / penerima.</span>
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Target Email Penerima Notifikasi Inquiry Lead (Admin) *</label>
                <input type="email" name="mail_receive_address" value="{{ $settings['mail_receive_address'] ?? 'noreply@islenesia.com' }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;" placeholder="info@islenesia.com atau email pribadi Anda">
                <span style="font-size: 0.75rem; color: var(--admin-muted);">Kemana notifikasi rincian inquiry lead pembeli/pemasok akan dikirimkan.</span>
            </div>

            <!-- Test Connection Box -->
            <div style="background: #FFFFFF; border: 1.5px solid var(--admin-border); border-radius: 12px; padding: 1.5rem; margin-top: 1.5rem; box-shadow: var(--shadow-sm);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; flex-wrap: wrap; gap: 0.5rem;">
                    <h4 style="font-size: 0.95rem; color: var(--admin-navy-surface); margin: 0; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-paper-plane text-gold"></i>
                        <span>Uji Coba Pengiriman Email (Test SMTP Connection)</span>
                    </h4>
                    <span style="font-size: 0.75rem; color: var(--admin-muted);">Uji langsung koneksi server email hosting</span>
                </div>
                <p style="font-size: 0.825rem; color: var(--admin-muted); margin-bottom: 1rem;">
                    Masukkan alamat email tujuan untuk memastikan server cPanel berhasil terhubung dan mengirimkan pesan tanpa kendala:
                </p>
                <div style="display: flex; gap: 0.75rem; max-width: 550px;">
                    <input type="email" id="testEmailInput" value="{{ $settings['mail_receive_address'] ?? 'noreply@islenesia.com' }}" placeholder="Ketik email tujuan test..." class="form-input" style="flex: 1; padding: 0.65rem 0.85rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem;">
                    <button type="button" id="btnTestSmtp" onclick="sendTestSmtpEmail()" class="btn-admin btn-admin-navy" style="white-space: nowrap; padding: 0.65rem 1.25rem;">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Test Kirim Sekarang</span>
                    </button>
                </div>
                <div id="testSmtpFeedback" style="display: none; margin-top: 1rem; padding: 0.85rem 1rem; border-radius: 8px; font-size: 0.85rem;"></div>
            </div>
        </div>

        <div style="margin-top: 2.5rem; padding-top: 1.5rem; border-top: 1px solid var(--admin-border);">
            <button type="submit" class="btn-admin btn-admin-gold" style="padding: 0.85rem 2.5rem; font-size: 1rem;">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Simpan Seluruh Pengaturan</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function switchSettingTab(tabId) {
        $('.settings-tab-btn').removeClass('active');
        $('.settings-tab-pane').removeClass('active');
        
        event.currentTarget.classList.add('active');
        $('#' + tabId).addClass('active');
    }

    function toggleSmtpPassword() {
        var input = document.getElementById('smtpPasswordInput');
        var eye = document.getElementById('smtpPasswordEye');
        if (!input) return;
        if (input.type === 'password') {
            input.type = 'text';
            if (eye) eye.className = 'fa-regular fa-eye-slash';
        } else {
            input.type = 'password';
            if (eye) eye.className = 'fa-regular fa-eye';
        }
    }

    function sendTestSmtpEmail() {
        var btn = document.getElementById('btnTestSmtp');
        var input = document.getElementById('testEmailInput');
        var feedback = document.getElementById('testSmtpFeedback');
        var email = input ? input.value.trim() : '';

        if (!email) {
            alert('Mohon masukkan email tujuan uji coba.');
            return;
        }

        var origHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menghubungkan Server...';
        
        if (feedback) {
            feedback.style.display = 'block';
            feedback.style.background = '#EFF6FF';
            feedback.style.color = '#1D4ED8';
            feedback.style.border = '1px solid #BFDBFE';
            feedback.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sedang melakukan handshake SMTP dan mengirimkan email uji coba ke <strong>' + email + '</strong>...';
        }

        fetch("{{ route('admin.settings.test-smtp') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ test_email: email })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.success) {
                feedback.style.background = '#ECFDF5';
                feedback.style.color = '#065F46';
                feedback.style.border = '1px solid #A7F3D0';
                feedback.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + data.message;
            } else {
                feedback.style.background = '#FEF2F2';
                feedback.style.color = '#991B1B';
                feedback.style.border = '1px solid #FECACA';
                feedback.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> ' + data.message;
            }
        })
        .catch(function(err) {
            console.error(err);
            feedback.style.background = '#FEF2F2';
            feedback.style.color = '#991B1B';
            feedback.style.border = '1px solid #FECACA';
            feedback.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> Gagal menghubungi endpoint server. Pastikan koneksi internet stabil.';
        })
        .finally(function() {
            btn.disabled = false;
            btn.innerHTML = origHtml;
        });
    }
</script>
@endpush

@endsection
