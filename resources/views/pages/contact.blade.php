@extends('layouts.app')

@section('title', 'Kontak Meja Ekspor Resmi | ' . ($siteSettings['site_name'] ?? 'Islenesia'))
@section('meta_description', 'Hubungi tim ekspor dan agregator ' . ($siteSettings['site_name'] ?? 'Islenesia') . ' untuk konsultasi kontrak komoditas, sampel uji lab, dan kemitraan pasok hasil panen petani.')

@section('content')

<!-- Header Banner -->
<div style="background: radial-gradient(circle at 70% 30%, #152E5E 0%, #0B1B3D 70%, #061124 100%); color: #FFFFFF; padding: 4.5rem 0 3.5rem; border-bottom: 2px solid rgba(212, 175, 55, 0.3);">
    <div class="container text-center" style="max-width: 800px; margin: 0 auto;">
        <span class="section-subtitle" style="color: var(--gold-light);">OFFICIAL CONTACT & INQUIRY</span>
        <h1 style="color: #FFFFFF; font-size: 2.75rem; margin-bottom: 1rem;">Hubungi Tim Ekspor {{ $siteSettings['site_name'] ?? 'Islenesia' }}</h1>
        <p style="color: #CBD5E1; font-size: 1.05rem;">
            Tim ekspor multibahasa kami siap merespons kebutuhan pembeli internasional serta menyambut kemitraan kelompok tani nusantara.
        </p>
    </div>
</div>

<section class="section" style="background-color: #F8FAFC;">
    <div class="container">
        @if(session('success'))
            <div style="background: #ECFDF5; border: 1.5px solid #10B981; color: #065F46; padding: 1.25rem 1.5rem; border-radius: 12px; margin-bottom: 2.5rem; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fa-solid fa-circle-check" style="font-size: 1.5rem; color: #10B981;"></i>
                <div>
                    <strong>Pesan Terkirim!</strong> {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="contact-layout-grid">
            <!-- Left: Contact Details & Social Media -->
            <div>
                <div style="background: #FFFFFF; border-radius: 20px; padding: 2.5rem; border: 1px solid var(--slate-border); box-shadow: var(--shadow-sm); margin-bottom: 2rem;">
                    <span class="section-subtitle">INFORMASI KANTOR</span>
                    <h3 style="font-size: 1.35rem; color: var(--navy-primary); margin-bottom: 1.5rem;">Kantor Pusat & Operasional</h3>

                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="display: flex; gap: 1rem; align-items: flex-start;">
                            <div style="width: 44px; height: 44px; background: rgba(212, 175, 55, 0.15); color: var(--gold-dark); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 0.925rem; color: var(--navy-primary); margin-bottom: 0.25rem;">Alamat Kantor</h4>
                                <p style="font-size: 0.875rem; color: var(--slate-muted); line-height: 1.5;">{{ $contact['address'] }}</p>
                            </div>
                        </div>

                        <div style="display: flex; gap: 1rem; align-items: flex-start;">
                            <div style="width: 44px; height: 44px; background: rgba(212, 175, 55, 0.15); color: var(--gold-dark); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 0.925rem; color: var(--navy-primary); margin-bottom: 0.25rem;">Email Resmi</h4>
                                <a href="mailto:{{ $contact['email'] }}" style="font-size: 0.875rem; color: var(--navy-primary); font-weight: 600;">{{ $contact['email'] }}</a>
                            </div>
                        </div>

                        <div style="display: flex; gap: 1rem; align-items: flex-start;">
                            <div style="width: 44px; height: 44px; background: rgba(16, 185, 129, 0.15); color: #059669; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 0.925rem; color: var(--navy-primary); margin-bottom: 0.25rem;">WhatsApp Meja Ekspor</h4>
                                <a href="javascript:void(0)" onclick="openWhatsAppModal('buyer')" style="font-size: 0.875rem; color: #059669; font-weight: 700;">{{ $contact['phone'] }}</a>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Social Media Channels -->
                    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--slate-border);">
                        <h4 style="font-size: 0.925rem; color: var(--navy-primary); margin-bottom: 0.75rem;">Media Sosial Resmi</h4>
                        <div class="social-links-list">
                            @if(!empty($contact['social_instagram']))
                                <a href="{{ $contact['social_instagram'] }}" target="_blank" rel="noopener" class="social-icon-btn" title="Instagram" style="background: #F1F5F9; color: #0F172A;"><i class="fa-brands fa-instagram"></i></a>
                            @endif
                            @if(!empty($contact['social_facebook']))
                                <a href="{{ $contact['social_facebook'] }}" target="_blank" rel="noopener" class="social-icon-btn" title="Facebook" style="background: #F1F5F9; color: #0F172A;"><i class="fa-brands fa-facebook-f"></i></a>
                            @endif
                            @if(!empty($contact['social_tiktok']))
                                <a href="{{ $contact['social_tiktok'] }}" target="_blank" rel="noopener" class="social-icon-btn" title="TikTok" style="background: #F1F5F9; color: #0F172A;"><i class="fa-brands fa-tiktok"></i></a>
                            @endif
                            @if(!empty($contact['social_youtube']))
                                <a href="{{ $contact['social_youtube'] }}" target="_blank" rel="noopener" class="social-icon-btn" title="YouTube" style="background: #F1F5F9; color: #0F172A;"><i class="fa-brands fa-youtube"></i></a>
                            @endif
                            @if(!empty($contact['social_linkedin']))
                                <a href="{{ $contact['social_linkedin'] }}" target="_blank" rel="noopener" class="social-icon-btn" title="LinkedIn" style="background: #F1F5F9; color: #0F172A;"><i class="fa-brands fa-linkedin-in"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Interactive Contact Form -->
            <div>
                <div style="background: #FFFFFF; border-radius: 20px; padding: 2.5rem; border: 1px solid var(--slate-border); box-shadow: var(--shadow-sm);">
                    <span class="section-subtitle">FORMULIR INQUIRY</span>
                    <h3 style="font-size: 1.35rem; color: var(--navy-primary); margin-bottom: 0.5rem;">Kirim Pesan atau Permintaan Penawaran</h3>
                    <p style="font-size: 0.875rem; color: var(--slate-muted); margin-bottom: 1.5rem;">
                        Data Anda langsung tercatat di sistem agregator dan ditindaklanjuti oleh staf ekspor kami.
                    </p>

                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        
                        <!-- Anti-bot honeypot trap field (hidden from legitimate users) -->
                        <input type="text" name="website_trap" style="display:none;" tabindex="-1" autocomplete="off">

                        <!-- Keperluan Selection -->
                        <div style="margin-bottom: 1.25rem;">
                            <label style="display: block; font-size: 0.8125rem; font-weight: 700; color: var(--navy-primary); margin-bottom: 0.5rem;">Kategori Keperluan</label>
                            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0.5rem;">
                                <label style="display: flex; align-items: center; gap: 0.4rem; padding: 0.6rem; border: 1.5px solid var(--slate-border); border-radius: 8px; font-size: 0.8125rem; cursor: pointer;">
                                    <input type="radio" name="type" value="buyer" checked>
                                    <span>Saya Buyer</span>
                                </label>
                                <label style="display: flex; align-items: center; gap: 0.4rem; padding: 0.6rem; border: 1.5px solid var(--slate-border); border-radius: 8px; font-size: 0.8125rem; cursor: pointer;">
                                    <input type="radio" name="type" value="petani">
                                    <span>Saya Petani</span>
                                </label>
                                <label style="display: flex; align-items: center; gap: 0.4rem; padding: 0.6rem; border: 1.5px solid var(--slate-border); border-radius: 8px; font-size: 0.8125rem; cursor: pointer;">
                                    <input type="radio" name="type" value="general">
                                    <span>Lainnya</span>
                                </label>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                            <div>
                                <label style="display: block; font-size: 0.8125rem; font-weight: 700; color: var(--navy-primary); margin-bottom: 0.35rem;">Nama Lengkap *</label>
                                <input type="text" name="name" required class="wa-form-input" placeholder="Contoh: Mr. Klaus Schmidt / Bpk. Rudi">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.8125rem; font-weight: 700; color: var(--navy-primary); margin-bottom: 0.35rem;">Perusahaan / Kelompok Tani</label>
                                <input type="text" name="company" class="wa-form-input" placeholder="Contoh: EuroSpice GmbH / Poktan Makmur">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                            <div>
                                <label style="display: block; font-size: 0.8125rem; font-weight: 700; color: var(--navy-primary); margin-bottom: 0.35rem;">Email Aktif *</label>
                                <input type="email" name="email" required class="wa-form-input" placeholder="buyer@example.com">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.8125rem; font-weight: 700; color: var(--navy-primary); margin-bottom: 0.35rem;">Nomor WhatsApp *</label>
                                <input type="tel" name="whatsapp" required class="wa-form-input" placeholder="+62 812xxxx / +49 xxx">
                            </div>
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-size: 0.8125rem; font-weight: 700; color: var(--navy-primary); margin-bottom: 0.35rem;">Subjek Pesan</label>
                            <input type="text" name="subject" class="wa-form-input" placeholder="Permintaan Penawaran Harga FCL Vanili / Pengajuan Panen Kopi">
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; font-size: 0.8125rem; font-weight: 700; color: var(--navy-primary); margin-bottom: 0.35rem;">Pesan / Kebutuhan Detail *</label>
                            <textarea name="message" rows="4" required class="wa-form-textarea" placeholder="Tuliskan spesifikasi komoditas, estimasi volume yang dibutuhkan/tersedia..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-navy btn-lg" style="width: 100%;">
                            <i class="fa-regular fa-paper-plane"></i>
                            <span>Kirim Formulir Inquiry</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Google Maps Embed Section -->
        @if(!empty($contact['maps']))
            <div style="background: #FFFFFF; border-radius: 20px; overflow: hidden; border: 1px solid var(--slate-border); box-shadow: var(--shadow-sm); padding: 1.5rem;">
                <h3 style="font-size: 1.25rem; color: var(--navy-primary); margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-map-location-dot text-gold"></i>
                    <span>Lokasi Kantor Pusat & Operasional</span>
                </h3>
                <div style="border-radius: 12px; overflow: hidden; width: 100%; aspect-ratio: 21/9; min-height: 380px;">
                    {!! $contact['maps'] !!}
                </div>
            </div>
        @endif
    </div>
</section>

@endsection
