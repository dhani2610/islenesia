<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- Dynamic SEO Meta Tags -->
    <title>@yield('title', $siteSettings['meta_title'] ?? 'Islenesia | Indonesian Agricultural & Commodity Exporter')</title>
    <meta name="description" content="@yield('meta_description', $siteSettings['meta_description'] ?? 'Eksportir & agregator komoditas agrikultur Indonesia terpercaya ke pasar China, Eropa, dan dunia. Menyediakan Vanili, Kratom, Kopi, dan Cengkeh berkualitas ekspor.')">
    <meta name="keywords" content="@yield('meta_keywords', $siteSettings['meta_keywords'] ?? 'islenesia, agro exporter indonesia, ekspor vanili, kratom wholesale, biji kopi arabika, cengkeh lalpari')">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook / LinkedIn / WhatsApp Preview -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', $siteSettings['meta_title'] ?? 'Islenesia Export Indonesia')">
    <meta property="og:description" content="@yield('meta_description', $siteSettings['meta_description'] ?? 'Direct agro exporter & aggregator connecting Indonesian farmers with European and Chinese buyers.')">
    @php
        $ogImg = !empty($siteSettings['meta_og_image']) ? asset('storage/' . $siteSettings['meta_og_image']) : asset('images/products/vanilla.jpg');
    @endphp
    <meta property="og:image" content="@yield('og_image', $ogImg)">

    <!-- Favicon -->
    @php
        $fav = !empty($siteSettings['site_favicon']) ? asset('storage/' . $siteSettings['site_favicon']) : asset('images/branding/favicon.svg');
    @endphp
    <link rel="icon" type="image/svg+xml" href="{{ $fav }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}?v={{ time() }}">
    
    <style>
        /* Forcefully destroy Google Translate top banner & toolbar */
        .goog-te-banner-frame,
        .goog-te-banner-frame.skiptranslate,
        iframe.goog-te-banner-frame,
        iframe.skiptranslate,
        body > .skiptranslate,
        body > div.skiptranslate,
        .VIpgJd-ZVi9I-OR9Mb-sMiClc,
        .VIpgJd-y60fut-tAbLfc,
        .VIpgJd-ZVi9I-aZ2wEe-wOHMyf,
        .VIpgJd-ZVi9I-bOHHs-tp13ne,
        #goog-gt-tt,
        .goog-te-balloon-frame {
            display: none !important;
            visibility: hidden !important;
            height: 0px !important;
            width: 0px !important;
            max-height: 0px !important;
            opacity: 0 !important;
            pointer-events: none !important;
            z-index: -9999 !important;
        }

        body {
            top: 0px !important;
            position: static !important;
        }

        body > .skiptranslate:first-child {
            display: none !important;
            height: 0px !important;
        }

        .goog-text-highlight {
            background: none !important;
            box-shadow: none !important;
        }

        #google_translate_element {
            display: none !important;
        }
    </style>

    @livewireStyles
    @stack('styles')
</head>
<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-notice">
                <i class="fa-solid fa-earth-asia text-gold"></i>
                <span>Direct Agricultural Exporter to China, Europe & Global Markets</span>
            </div>
            <div class="top-bar-links">
                @php
                    $phone = $siteSettings['phone'] ?? '+62 851-6131-3914';
                    $email = $siteSettings['email'] ?? 'info@islenesia.com';
                @endphp
                <a href="mailto:{{ $email }}">
                    <i class="fa-regular fa-envelope text-gold"></i>
                    <span>{{ $email }}</span>
                </a>
                <a href="javascript:void(0)" onclick="openWhatsAppModal('buyer')">
                    <i class="fa-brands fa-whatsapp text-gold"></i>
                    <span>{{ $phone }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation Header -->
    <header class="site-navbar">
        <div class="container">
            <a href="{{ route('home') }}" class="brand-logo">
                @if(!empty($siteSettings['site_logo']) && (file_exists(public_path('storage/' . $siteSettings['site_logo'])) || file_exists(storage_path('app/public/' . $siteSettings['site_logo']))))
                    <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" alt="{{ $siteSettings['site_name'] ?? 'Islenesia' }}">
                @else
                    <img src="{{ asset('images/branding/logo.svg') }}" alt="Islenesia Export Indonesia">
                @endif
            </a>

            <nav>
                <ul class="nav-menu" id="navMenu">
                    <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
                    <li><a href="{{ route('catalog.index') }}" class="nav-link {{ request()->routeIs('catalog.*') ? 'active' : '' }}">Katalog Produk</a></li>
                    <li><a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">Tentang Kami</a></li>
                    <li><a href="{{ route('blog.index') }}" class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog & Berita</a></li>
                    <li><a href="{{ route('contact.index') }}" class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}">Kontak</a></li>
                </ul>
            </nav>

            <div class="nav-actions">
                <!-- Cool Language Dropdown (In Navbar) -->
                <div class="cool-lang-dropdown" id="coolLangDropdown">
                    <button type="button" class="cool-lang-btn" id="coolLangBtn" onclick="toggleCoolLang(event)" aria-label="Pilih Bahasa" aria-expanded="false">
                        <span class="cool-lang-flag" id="coolLangFlag">🇮🇩</span>
                        <span class="cool-lang-code" id="coolLangCode">ID</span>
                        <i class="fa-solid fa-chevron-down cool-lang-chevron" id="coolLangChevron"></i>
                    </button>
                    <div class="cool-lang-menu" id="coolLangMenu">
                        <div class="cool-lang-header">PILIHAN BAHASA</div>
                        <button type="button" class="cool-lang-item active" data-lang="id" onclick="selectCoolLanguage('id', '🇮🇩', 'ID')">
                            <span class="cool-flag-badge">🇮🇩</span>
                            <div class="cool-lang-text">
                                <span class="cool-lang-name">Indonesia</span>
                                <span class="cool-lang-desc">Bahasa Indonesia</span>
                            </div>
                            <i class="fa-solid fa-circle-check cool-check-icon"></i>
                        </button>
                        <button type="button" class="cool-lang-item" data-lang="en" onclick="selectCoolLanguage('en', '🇬🇧', 'EN')">
                            <span class="cool-flag-badge">🇬🇧</span>
                            <div class="cool-lang-text">
                                <span class="cool-lang-name">English</span>
                                <span class="cool-lang-desc">International (EN)</span>
                            </div>
                            <i class="fa-solid fa-circle-check cool-check-icon"></i>
                        </button>
                        <button type="button" class="cool-lang-item" data-lang="zh-CN" onclick="selectCoolLanguage('zh-CN', '🇨🇳', 'CN')">
                            <span class="cool-flag-badge">🇨🇳</span>
                            <div class="cool-lang-text">
                                <span class="cool-lang-name">中文 (Mandarin)</span>
                                <span class="cool-lang-desc">Chinese (CN)</span>
                            </div>
                            <i class="fa-solid fa-circle-check cool-check-icon"></i>
                        </button>
                    </div>
                </div>

                <button type="button" class="btn btn-gold btn-sm" onclick="openWhatsAppModal('buyer')">
                    <i class="fa-brands fa-whatsapp"></i>
                    <span>Inquiry Ekspor</span>
                </button>

                <button type="button" class="mobile-toggle" id="mobileToggle" aria-label="Toggle Navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <!-- Brand Info -->
                <div class="footer-brand">
                    <a href="{{ route('home') }}" class="brand-logo footer-brand-link">
                        @if(!empty($siteSettings['site_logo']) && (file_exists(public_path('storage/' . $siteSettings['site_logo'])) || file_exists(storage_path('app/public/' . $siteSettings['site_logo']))))
                            <span class="footer-logo-badge">
                                <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" alt="{{ $siteSettings['site_name'] ?? 'Islenesia' }}" class="footer-custom-logo">
                            </span>
                        @else
                            <img src="{{ asset('images/branding/logo.svg') }}" alt="Islenesia" style="filter: brightness(0) invert(1); height: 48px;">
                        @endif
                    </a>
                    <p>
                        {{ $siteSettings['site_description'] ?? 'Agregator dan eksportir komoditas pertanian nusantara terkemuka dengan kontrol mutu laboratorium bersertifikasi dan kemitraan petani berkelanjutan.' }}
                    </p>
                    <div class="social-links-list">
                        @if(!empty($siteSettings['social_instagram']))
                            <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" rel="noopener" class="social-icon-btn" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        @endif
                        @if(!empty($siteSettings['social_facebook']))
                            <a href="{{ $siteSettings['social_facebook'] }}" target="_blank" rel="noopener" class="social-icon-btn" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        @endif
                        @if(!empty($siteSettings['social_tiktok']))
                            <a href="{{ $siteSettings['social_tiktok'] }}" target="_blank" rel="noopener" class="social-icon-btn" title="TikTok"><i class="fa-brands fa-tiktok"></i></a>
                        @endif
                        @if(!empty($siteSettings['social_youtube']))
                            <a href="{{ $siteSettings['social_youtube'] }}" target="_blank" rel="noopener" class="social-icon-btn" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                        @endif
                        @if(!empty($siteSettings['social_linkedin']))
                            <a href="{{ $siteSettings['social_linkedin'] }}" target="_blank" rel="noopener" class="social-icon-btn" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        @endif
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="footer-col">
                    <h4>Eksplorasi</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('catalog.index') }}">Katalog Produk Ekspor</a></li>
                        <li><a href="{{ route('about') }}">Tentang {{ $siteSettings['site_name'] ?? 'Islenesia' }}</a></li>
                        <li><a href="{{ route('blog.index') }}">Artikel & Wawasan Ekspor</a></li>
                        <li><a href="{{ route('contact.index') }}">Hubungi Tim Ekspor</a></li>
                    </ul>
                </div>

                <!-- Featured Commodities -->
                <div class="footer-col">
                    <h4>Komoditas Utama</h4>
                    <ul class="footer-links">
                        @php
                            $footerCommodities = \App\Models\Product::where('is_active', true)->orderBy('sort_order')->take(4)->get();
                        @endphp
                        @foreach($footerCommodities as $fc)
                            <li><a href="{{ route('catalog.show', $fc->slug) }}">{{ $fc->name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Contact & Office -->
                <div class="footer-col">
                    <h4>Kantor & Operasional</h4>
                    @if(!empty($siteSettings['address']))
                        <p style="color: #CBD5E1; font-size: 0.85rem; margin-bottom: 0.75rem;">
                            <i class="fa-solid fa-location-dot text-gold" style="margin-right: 0.4rem;"></i>
                            {{ $siteSettings['address'] }}
                        </p>
                    @endif
                    <p style="color: #CBD5E1; font-size: 0.85rem; margin-bottom: 0.75rem;">
                        <i class="fa-solid fa-phone text-gold" style="margin-right: 0.4rem;"></i>
                        {{ $siteSettings['phone'] ?? '+62 851-6131-3914' }}
                    </p>
                    <p style="color: #CBD5E1; font-size: 0.85rem; margin-bottom: 0.75rem;">
                        <i class="fa-regular fa-envelope text-gold" style="margin-right: 0.4rem;"></i>
                        {{ $siteSettings['email'] ?? 'info@islenesia.com' }}
                    </p>
                </div>
            </div>

            <div class="footer-bottom">
                <div>
                    &copy; {{ date('Y') }} <strong>{{ $siteSettings['company_name'] ?? 'PT Islenesia Agro Nusantara' }}</strong>. All Rights Reserved.
                </div>
                <div style="color: #64748B;">
                    Indonesia • China • Europe Global Supply Chain Network
                </div>
            </div>
        </div>
    </footer>

    @if(request()->routeIs('home', 'catalog.show') || request()->is('/'))
    <!-- Interactive Floating WhatsApp & Email Widget Button (Tampil di Beranda & Detail Produk) -->
    <div class="wa-floating-btn" onclick="openWhatsAppModal('buyer')" id="waFloatingBtn">
        <div class="wa-btn-icon">
            <div class="wa-pulse"></div>
            <i class="fa-brands fa-whatsapp"></i>
        </div>
        <div class="wa-btn-text">
            <h5>Chat & Inquiry {{ $siteSettings['site_name'] ?? 'Islenesia' }}</h5>
            <span>WhatsApp / Email</span>
        </div>
    </div>
    @endif

    <!-- Modal Dialog Backdrop -->
    <div class="wa-modal-backdrop" id="waModalBackdrop" onclick="closeWhatsAppModal(event)">
        <div class="wa-modal-box" onclick="event.stopPropagation()">
            <!-- Header -->
            <div class="wa-modal-header">
                <div class="wa-header-top">
                    <div class="wa-header-brand">
                        <div class="wa-avatar">🌴</div>
                        <div class="wa-header-title">
                            <h4 id="waModalTitle">Meja Ekspor {{ $siteSettings['site_name'] ?? 'Islenesia' }}</h4>
                            <p><span class="online-dot"></span> Online &bull; Layanan WhatsApp / Email Resmi</p>
                        </div>
                    </div>
                    <button type="button" class="wa-close-btn" onclick="closeWhatsAppModal(null)">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="wa-header-security-badge">
                    <i class="fa-solid fa-shield-halved text-gold"></i>
                    <span>Transaksi & negosiasi komoditas terhubung ke Meja Ekspor</span>
                </div>
            </div>

            <!-- Modal Body Form -->
            <div class="wa-modal-body" id="waModalBodyContainer">
                <form id="waInquiryForm" onsubmit="submitWhatsAppWidget(event)">
                    @csrf
                    
                    <input type="text" name="website_trap" style="display:none;" tabindex="-1" autocomplete="off">

                    <!-- Channel Selector: WhatsApp / Email -->
                    <div style="margin-bottom: 1.15rem;">
                        <div style="font-size: 0.725rem; font-weight: 800; color: var(--navy-primary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.4rem; display: flex; justify-content: space-between; align-items: center;">
                            <span>PILIH JALUR KOMUNIKASI:</span>
                            <span style="font-size: 0.7rem; color: var(--gold-dark); font-weight: 700;">WHATSAPP / EMAIL</span>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; background: #E2E8F0; padding: 3px; border-radius: 10px;">
                            <button type="button" class="channel-tab-btn active" id="channelTabWa" onclick="switchInquiryChannel('whatsapp')" style="border: none; padding: 0.55rem 0.75rem; border-radius: 8px; font-weight: 700; font-size: 0.825rem; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 0.4rem; background: #FFFFFF; color: var(--navy-primary); box-shadow: 0 2px 4px rgba(0,0,0,0.06);">
                                <i class="fa-brands fa-whatsapp" style="color: #25D366; font-size: 1rem;"></i>
                                <span>WhatsApp</span>
                            </button>
                            <button type="button" class="channel-tab-btn" id="channelTabEmail" onclick="switchInquiryChannel('email')" style="border: none; padding: 0.55rem 0.75rem; border-radius: 8px; font-weight: 700; font-size: 0.825rem; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 0.4rem; background: transparent; color: var(--slate-muted);">
                                <i class="fa-regular fa-envelope text-gold" style="font-size: 0.95rem;"></i>
                                <span>Official Email</span>
                            </button>
                        </div>
                        <input type="hidden" name="channel" id="inquiryChannelInput" value="whatsapp">
                    </div>

                    <!-- Role Tab Selector -->
                    <div class="wa-role-selector-label">PILIH KEPERLUAN ANDA:</div>
                    <div class="wa-role-tabs">
                        <div class="wa-role-tab active" id="tabBuyer" onclick="switchWaRole('buyer')">
                            <span>📦</span>
                            <span>Saya Buyer (Beli)</span>
                        </div>
                        <div class="wa-role-tab" id="tabPemasok" onclick="switchWaRole('pemasok')">
                            <span>🌿</span>
                            <span>Saya Pemasok (Jual)</span>
                        </div>
                    </div>
                    <input type="hidden" name="role" id="waRoleInput" value="buyer">
                    <input type="hidden" name="product_id" id="waProductIdInput" value="">

                    <!-- Input Nama / Perusahaan -->
                    <div class="wa-form-group">
                        <label for="waInputName">Nama / Perusahaan <span style="color: #EF4444;">*</span></label>
                        <input type="text" name="name" id="waInputName" class="wa-form-input" placeholder="Contoh: PT Sumber Pangan / Mr. Hans Schmidt (GmbH)" required>
                    </div>

                    <!-- Input Email Bisnis -->
                    <div class="wa-form-group" id="groupInputEmail">
                        <label for="waInputEmail">
                            <span>Email Kantor / Perusahaan</span>
                            <span id="emailRequiredMarker" style="color: #EF4444; display: none;">*</span>
                            <span id="emailOptionalLabel" style="font-size: 0.72rem; color: var(--slate-muted); font-weight: normal; margin-left: 0.35rem;">(Disarankan untuk Buyer Internasional)</span>
                        </label>
                        <input type="email" name="email" id="waInputEmail" class="wa-form-input" placeholder="buyer@company.de / name@domain.com">
                    </div>

                    <!-- Input Nomor WhatsApp -->
                    <div class="wa-form-group" id="groupInputPhone">
                        <label for="waInputPhone">
                            <span>Nomor WhatsApp / Phone</span>
                            <span id="phoneRequiredMarker" style="color: #EF4444;">*</span>
                            <span id="phoneOptionalLabel" style="font-size: 0.72rem; color: var(--slate-muted); font-weight: normal; margin-left: 0.35rem; display: none;">(Opsional jika via Email)</span>
                        </label>
                        <input type="tel" name="whatsapp" id="waInputPhone" class="wa-form-input" placeholder="+49 ... atau 08xxxxxxxxxx" required>
                    </div>

                    <!-- Input Pesan / Kebutuhan -->
                    <div class="wa-form-group">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.35rem;">
                            <label for="waInputMessage" style="margin-bottom: 0;">Pesan / Kebutuhan <span style="color: #EF4444;">*</span></label>
                            <span id="waMsgCounter" style="font-size: 0.72rem; color: var(--slate-muted);">Template Siap Kirim</span>
                        </div>
                        <textarea name="message" id="waInputMessage" class="wa-form-textarea" required></textarea>
                        
                        <!-- Quick Template Chips -->
                        <div class="wa-template-chips">
                            <button type="button" class="wa-template-chip" id="chipQuote" onclick="applyWaTemplate('quote')">
                                <i class="fa-solid fa-file-invoice-dollar text-gold"></i> Template Quote (Harga, COA, Sampel, Ongkir)
                            </button>
                            <button type="button" class="wa-template-chip" id="chipGeneral" onclick="applyWaTemplate('general')">
                                <i class="fa-regular fa-comment-dots text-gold"></i> Pesan Umum
                            </button>
                        </div>
                    </div>

                    <!-- Anti-Bot Captcha Verification Field -->
                    <div class="wa-form-group" style="background: #F8FAFC; border: 1.5px solid var(--slate-border); border-radius: 12px; padding: 0.85rem; margin-bottom: 1.25rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.35rem;">
                            <label for="waCaptchaInput" style="font-size: 0.8rem; font-weight: 700; color: var(--navy-primary); margin: 0; display: flex; align-items: center; gap: 0.35rem;">
                                <i class="fa-solid fa-shield-halved text-gold"></i>
                                <span>Verifikasi Anti-Bot</span>
                            </label>
                            <button type="button" onclick="refreshChatCaptcha()" style="background: none; border: none; color: var(--slate-muted); font-size: 0.75rem; cursor: pointer; display: flex; align-items: center; gap: 0.25rem;" title="Ganti Pertanyaan">
                                <i class="fa-solid fa-arrows-rotate" id="chatCaptchaSpin"></i> Ganti
                            </button>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.65rem;">
                            <div style="background: #E2E8F0; padding: 0.45rem 0.85rem; border-radius: 8px; font-weight: 800; font-family: monospace; font-size: 1.05rem; letter-spacing: 1px; color: var(--navy-primary); user-select: none;">
                                <span id="chatCaptchaQuestion">6 + 3</span> = ?
                            </div>
                            <input type="number" name="captcha_answer" id="waCaptchaInput" class="wa-form-input" style="padding: 0.5rem 0.75rem;" placeholder="Jawaban..." required autocomplete="off">
                        </div>
                        <div id="waCaptchaError" style="display: none; color: #EF4444; font-size: 0.775rem; margin-top: 0.35rem; font-weight: 600;"></div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="wa-submit-btn" id="waSubmitBtn">
                        <i class="fa-regular fa-paper-plane" id="waSubmitBtnIcon"></i>
                        <span id="waSubmitBtnText">Lanjut ke WhatsApp Admin {{ $siteSettings['site_name'] ?? 'Islenesia' }} &rarr;</span>
                    </button>

                    <div class="wa-footer-notice">
                        *Tercatat otomatis di database sistem agregator {{ $siteSettings['site_name'] ?? 'Islenesia' }}
                    </div>
                </form>

                <!-- Success Screen for Email Submissions -->
                <div id="waInquirySuccessBox" style="display: none; text-align: center; padding: 2.25rem 1rem;">
                    <div style="width: 72px; height: 72px; background: #ECFDF5; border: 2px solid #A7F3D0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; color: #059669; font-size: 2.25rem;">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <h3 style="color: var(--navy-primary); font-size: 1.35rem; margin-bottom: 0.65rem; font-weight: 800;">
                        Inquiry Received!
                    </h3>
                    <p style="color: var(--slate-body); font-size: 0.9rem; line-height: 1.6; max-width: 440px; margin: 0 auto 1.25rem;">
                        Permintaan penawaran resmi Anda telah berhasil kami terima. Email konfirmasi (Trade Inquiry Acknowledgment) telah otomatis dikirimkan ke alamat email Anda.
                    </p>
                    <div style="background: #F8FAFC; border: 1px solid var(--slate-border); border-radius: 10px; padding: 0.85rem 1rem; margin-bottom: 1.5rem; font-size: 0.825rem; color: var(--slate-muted);">
                        Tim Meja Ekspor <strong>{{ $siteSettings['company_name'] ?? 'PT Islenesia Agro Nusantara' }}</strong> akan meninjau spesifikasi Anda dan merespons dalam <strong>24 jam kerja</strong>.
                    </div>
                    <button type="button" onclick="closeWhatsAppModal(null); resetInquiryModalForm();" class="btn btn-navy btn-sm" style="padding: 0.65rem 1.75rem;">
                        <i class="fa-solid fa-check"></i>
                        <span>Selesai & Tutup</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Google Translate Element Container -->
    <div id="google_translate_element"></div>

    <!-- Google Translate API Script -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'id,en,zh-CN',
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <!-- Core Global JavaScript (Robust, No Syntax Errors, Fully Scoped) -->
    <script>
        window.SITE_NAME = "{{ addslashes($siteSettings['site_name'] ?? 'Islenesia') }}";

        /* Cool Language Dropdown Functions */
        window.toggleCoolLang = function(e) {
            if (e) e.stopPropagation();
            var dropdown = document.getElementById('coolLangDropdown');
            var btn = document.getElementById('coolLangBtn');
            if (!dropdown) return;
            var isOpen = dropdown.classList.toggle('open');
            if (btn) btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        };

        window.selectCoolLanguage = function(lang, flag, code) {
            /* Set cookie for root path and hostname */
            var val = '/id/' + lang;
            var d = new Date();
            d.setTime(d.getTime() + (30 * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = "googtrans=" + val + "; " + expires + "; path=/;";
            document.cookie = "googtrans=" + val + "; " + expires + "; path=/; domain=" + window.location.hostname + ";";
            localStorage.setItem('islenesia_lang', lang);

            /* Update UI */
            var flagEl = document.getElementById('coolLangFlag');
            var codeEl = document.getElementById('coolLangCode');
            if (flagEl) flagEl.textContent = flag;
            if (codeEl) codeEl.textContent = code;

            /* Highlight active */
            var items = document.querySelectorAll('.cool-lang-item');
            items.forEach(function(item) {
                if (item.getAttribute('data-lang') === lang) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });

            /* Close menu */
            var dropdown = document.getElementById('coolLangDropdown');
            if (dropdown) dropdown.classList.remove('open');

            /* Trigger Google Translate combo if available */
            var selectEl = document.querySelector('.goog-te-combo');
            if (selectEl) {
                selectEl.value = lang;
                selectEl.dispatchEvent(new Event('change'));
            } else {
                window.location.reload();
            }
        };

        /* Close Dropdown on Outside Click */
        document.addEventListener('click', function(e) {
            var dropdown = document.getElementById('coolLangDropdown');
            if (dropdown && !dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
                var btn = document.getElementById('coolLangBtn');
                if (btn) btn.setAttribute('aria-expanded', 'false');
            }
        });

        /* WhatsApp Modal State & Actions */
        var waModal = document.getElementById('waModalBackdrop');
        var tabBuyer = document.getElementById('tabBuyer');
        var tabPemasok = document.getElementById('tabPemasok') || document.getElementById('tabPetani');
        var waRoleInput = document.getElementById('waRoleInput');
        var waInputMessage = document.getElementById('waInputMessage');
        window.currentProductName = '';

        var buyerPlaceholder = "Saya tertarik untuk membeli komoditas ekspor " + window.SITE_NAME + " (Vanili / Kratom / Kopi / Cengkeh). Mohon info spesifikasi teknis dan penawaran harga FOB/CIF.";
        var pemasokPlaceholder = "Saya pemasok / supplier komoditas, ingin menawarkan pasokan hasil komoditas ke agregator " + window.SITE_NAME + ".";

        window.switchWaRole = function(role) {
            if (role === 'petani' || role === 'seller') role = 'pemasok';
            if (waRoleInput) waRoleInput.value = role;
            if (role === 'buyer') {
                if (tabBuyer) tabBuyer.classList.add('active');
                if (tabPemasok) tabPemasok.classList.remove('active');
                if (waInputMessage) waInputMessage.value = buyerPlaceholder;
            } else {
                if (tabPemasok) tabPemasok.classList.add('active');
                if (tabBuyer) tabBuyer.classList.remove('active');
                if (waInputMessage) waInputMessage.value = pemasokPlaceholder;
            }
        };

        window.requestQuoteModal = function(productName, productId) {
            window.currentProductName = productName || '';
            var site = window.SITE_NAME || 'Islenesia';
            var quoteTemplate = "Halo Admin Agregator " + site + ", saya tertarik dengan komoditas *" + (productName || 'Komoditas') + "*.\n\n" +
                "Saya ingin mengajukan *Request a Quote* resmi untuk rincian berikut:\n" +
                "1. Penawaran Harga (FOB / CIF)\n" +
                "2. Certificate of Analysis (COA) / Spesifikasi Lab\n" +
                "3. Ketersediaan Sampel Produk\n" +
                "4. Estimasi Biaya Kirim (Freight / Shipping Cost)\n\n" +
                "Target Pelabuhan / Negara Tujuan:\n" +
                "Estimasi Kebutuhan / Volume:\n\n" +
                "Mohon informasi ketersediaan stok dan syarat pemesanan. Terima kasih.";

            window.openWhatsAppModal('buyer', quoteTemplate, productId, 'Request a Quote: ' + (productName || 'Komoditas'));
        };

        window.applyWaTemplate = function(type) {
            var site = window.SITE_NAME || 'Islenesia';
            var chipQuote = document.getElementById('chipQuote');
            var chipGeneral = document.getElementById('chipGeneral');
            if (chipQuote) chipQuote.classList.toggle('active', type === 'quote');
            if (chipGeneral) chipGeneral.classList.toggle('active', type === 'general');

            if (type === 'quote') {
                var pName = window.currentProductName || 'Komoditas Ekspor';
                var quoteTemplate = "Halo Admin Agregator " + site + ", saya tertarik dengan komoditas *" + pName + "*.\n\n" +
                    "Saya ingin mengajukan *Request a Quote* resmi untuk rincian berikut:\n" +
                    "1. Penawaran Harga (FOB / CIF)\n" +
                    "2. Certificate of Analysis (COA) / Spesifikasi Lab\n" +
                    "3. Ketersediaan Sampel Produk\n" +
                    "4. Estimasi Biaya Kirim (Freight / Shipping Cost)\n\n" +
                    "Target Pelabuhan / Negara Tujuan:\n" +
                    "Estimasi Kebutuhan / Volume:\n\n" +
                    "Mohon informasi ketersediaan stok dan syarat pemesanan. Terima kasih.";
                if (waInputMessage) waInputMessage.value = quoteTemplate;
            } else {
                if (waInputMessage) waInputMessage.value = buyerPlaceholder;
            }
        };

        window.refreshChatCaptcha = function() {
            var spin = document.getElementById('chatCaptchaSpin');
            if (spin) spin.classList.add('fa-spin');
            fetch("{{ route('captcha.refresh') }}?scope=chat")
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    var qEl = document.getElementById('chatCaptchaQuestion');
                    if (qEl && data.question) qEl.textContent = data.question;
                    var errEl = document.getElementById('waCaptchaError');
                    if (errEl) errEl.style.display = 'none';
                })
                .catch(function(err) { console.error(err); })
                .finally(function() {
                    if (spin) spin.classList.remove('fa-spin');
                });
        };

        /* WhatsApp & Email Channel Switch */
        window.switchInquiryChannel = function(channel) {
            var channelInput = document.getElementById('inquiryChannelInput');
            if (channelInput) channelInput.value = channel;

            var tabWa = document.getElementById('channelTabWa');
            var tabEmail = document.getElementById('channelTabEmail');
            var emailReq = document.getElementById('emailRequiredMarker');
            var emailOpt = document.getElementById('emailOptionalLabel');
            var phoneReq = document.getElementById('phoneRequiredMarker');
            var phoneOpt = document.getElementById('phoneOptionalLabel');
            var inputEmail = document.getElementById('waInputEmail');
            var inputPhone = document.getElementById('waInputPhone');
            var btnIcon = document.getElementById('waSubmitBtnIcon');
            var btnText = document.getElementById('waSubmitBtnText');

            if (channel === 'email') {
                if (tabEmail) {
                    tabEmail.style.background = '#FFFFFF';
                    tabEmail.style.color = 'var(--navy-primary)';
                    tabEmail.style.boxShadow = '0 2px 4px rgba(0,0,0,0.06)';
                }
                if (tabWa) {
                    tabWa.style.background = 'transparent';
                    tabWa.style.color = 'var(--slate-muted)';
                    tabWa.style.boxShadow = 'none';
                }

                if (emailReq) emailReq.style.display = 'inline';
                if (emailOpt) emailOpt.style.display = 'none';
                if (inputEmail) inputEmail.required = true;

                if (phoneReq) phoneReq.style.display = 'none';
                if (phoneOpt) phoneOpt.style.display = 'inline';
                if (inputPhone) inputPhone.required = false;

                if (btnIcon) btnIcon.className = 'fa-regular fa-envelope';
                if (btnText) btnText.innerHTML = 'Kirim Inquiry Resmi via Email &rarr;';
            } else {
                if (tabWa) {
                    tabWa.style.background = '#FFFFFF';
                    tabWa.style.color = 'var(--navy-primary)';
                    tabWa.style.boxShadow = '0 2px 4px rgba(0,0,0,0.06)';
                }
                if (tabEmail) {
                    tabEmail.style.background = 'transparent';
                    tabEmail.style.color = 'var(--slate-muted)';
                    tabEmail.style.boxShadow = 'none';
                }

                if (emailReq) emailReq.style.display = 'none';
                if (emailOpt) emailOpt.style.display = 'inline';
                if (inputEmail) inputEmail.required = false;

                if (phoneReq) phoneReq.style.display = 'inline';
                if (phoneOpt) phoneOpt.style.display = 'none';
                if (inputPhone) inputPhone.required = true;

                if (btnIcon) btnIcon.className = 'fa-regular fa-paper-plane';
                if (btnText) btnText.innerHTML = 'Lanjut ke WhatsApp Admin ' + (window.SITE_NAME || 'Islenesia') + ' &rarr;';
            }
        };

        window.resetInquiryModalForm = function() {
            var form = document.getElementById('waInquiryForm');
            var successBox = document.getElementById('waInquirySuccessBox');
            if (form) {
                form.reset();
                form.style.display = 'block';
            }
            if (successBox) successBox.style.display = 'none';
            window.switchInquiryChannel('whatsapp');
            window.switchWaRole('buyer');
            window.refreshChatCaptcha();
        };

        window.openWhatsAppModal = function(role, defaultText, productId, modalTitle) {
            window.resetInquiryModalForm();
            if (!role) role = 'buyer';
            window.switchWaRole(role);
            if (defaultText && waInputMessage) {
                waInputMessage.value = defaultText;
            }
            if (productId) {
                var pInput = document.getElementById('waProductIdInput');
                if (pInput) pInput.value = productId;
            }
            var titleEl = document.getElementById('waModalTitle');
            if (titleEl) {
                titleEl.textContent = modalTitle || ("Meja Ekspor " + window.SITE_NAME);
            }
            var chipQuote = document.getElementById('chipQuote');
            var chipGeneral = document.getElementById('chipGeneral');
            if (defaultText && defaultText.indexOf('Request a Quote') !== -1) {
                if (chipQuote) chipQuote.classList.add('active');
                if (chipGeneral) chipGeneral.classList.remove('active');
            } else {
                if (chipQuote) chipQuote.classList.remove('active');
                if (chipGeneral) chipGeneral.classList.add('active');
            }
            if (waModal) waModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        };

        window.closeWhatsAppModal = function(e) {
            if (e === null || e.target === waModal) {
                if (waModal) waModal.classList.remove('active');
                document.body.style.overflow = '';
            }
        };

        window.submitWhatsAppWidget = function(event) {
            event.preventDefault();
            var form = document.getElementById('waInquiryForm');
            var submitBtn = document.getElementById('waSubmitBtn');
            var originalBtnHtml = submitBtn ? submitBtn.innerHTML : '';

            var channelInput = document.getElementById('inquiryChannelInput');
            var channel = channelInput ? channelInput.value : 'whatsapp';

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses Pengiriman...';
            }

            var formData = new FormData(form);

            fetch("{{ route('inquiry.widget') }}", {
                method: "POST",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(function(res) {
                if (!res.ok) {
                    return res.json().then(function(errData) {
                        throw errData;
                    });
                }
                return res.json();
            })
            .then(function(data) {
                if (data.channel === 'email') {
                    /* Show in-modal success acknowledgment screen */
                    if (form) form.style.display = 'none';
                    var successBox = document.getElementById('waInquirySuccessBox');
                    if (successBox) successBox.style.display = 'block';
                } else if (data.redirect_url) {
                    window.open(data.redirect_url, '_blank');
                    window.closeWhatsAppModal(null);
                    window.resetInquiryModalForm();
                } else {
                    window.closeWhatsAppModal(null);
                    window.resetInquiryModalForm();
                }
            })
            .catch(function(err) {
                console.error(err);
                if (err && err.errors && err.errors.captcha_answer) {
                    var errEl = document.getElementById('waCaptchaError');
                    if (errEl) {
                        errEl.textContent = err.errors.captcha_answer[0] || 'Jawaban verifikasi keamanan salah.';
                        errEl.style.display = 'block';
                    }
                    var inputEl = document.getElementById('waCaptchaInput');
                    if (inputEl) {
                        inputEl.value = '';
                        inputEl.focus();
                    }
                    window.refreshChatCaptcha();
                    return;
                }

                /* If user selected Email but network failed */
                if (channel === 'email') {
                    alert('Gagal mengirimkan inquiry email. Silakan periksa kembali isian form Anda atau hubungi kami langsung via WhatsApp.');
                    return;
                }

                /* WhatsApp fallback */
                var buyerPhone = "{{ preg_replace('/[^0-9]/', '', !empty($siteSettings['whatsapp_buyer']) ? $siteSettings['whatsapp_buyer'] : ($siteSettings['whatsapp_number'] ?? '6285161313914')) }}";
                var pemasokPhone = "{{ preg_replace('/[^0-9]/', '', !empty($siteSettings['whatsapp_pemasok']) ? $siteSettings['whatsapp_pemasok'] : ($siteSettings['whatsapp_number'] ?? '6285161313914')) }}";
                var currentRole = waRoleInput ? waRoleInput.value : 'buyer';
                var targetPhone = (currentRole === 'buyer') ? buyerPhone : pemasokPhone;
                var text = encodeURIComponent(waInputMessage ? waInputMessage.value : buyerPlaceholder);
                window.open("https://api.whatsapp.com/send?phone=" + targetPhone + "&text=" + text, '_blank');
                window.closeWhatsAppModal(null);
            })
            .finally(function() {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnHtml;
                }
            });
        };

        /* Continuously kill Google Translate Top Banner and reset body offset */
        function killGoogleTranslateBanner() {
            if (document.body) {
                if (document.body.style.top && document.body.style.top !== '0px') {
                    document.body.style.top = '0px';
                }
                if (document.body.style.position === 'relative') {
                    document.body.style.position = 'static';
                }
            }
            var banners = document.querySelectorAll('.goog-te-banner-frame, iframe.skiptranslate, body > .skiptranslate, .VIpgJd-ZVi9I-OR9Mb-sMiClc, .VIpgJd-y60fut-tAbLfc');
            banners.forEach(function(b) {
                b.style.setProperty('display', 'none', 'important');
                b.style.setProperty('visibility', 'hidden', 'important');
                b.style.setProperty('height', '0px', 'important');
                b.style.setProperty('width', '0px', 'important');
            });
        }
        setInterval(killGoogleTranslateBanner, 200);

        /* Initialize State on DOMContentLoaded */
        document.addEventListener('DOMContentLoaded', function() {
            killGoogleTranslateBanner();

            /* Mobile Nav Toggle */
            var mobileToggle = document.getElementById('mobileToggle');
            var navMenu = document.getElementById('navMenu');
            if (mobileToggle && navMenu) {
                mobileToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    navMenu.classList.toggle('active');
                });
            }

            /* Initialize default WA message */
            if (waInputMessage && !waInputMessage.value) {
                waInputMessage.value = buyerPlaceholder;
            }

            /* Restore saved language preference */
            var savedLang = localStorage.getItem('islenesia_lang') || localStorage.getItem('manunggaland_lang');
            if (savedLang) {
                var langMap = {
                    'id': { flag: '🇮🇩', code: 'ID' },
                    'en': { flag: '🇬🇧', code: 'EN' },
                    'zh-CN': { flag: '🇨🇳', code: 'CN' }
                };
                if (langMap[savedLang]) {
                    var flagEl = document.getElementById('coolLangFlag');
                    var codeEl = document.getElementById('coolLangCode');
                    if (flagEl) flagEl.textContent = langMap[savedLang].flag;
                    if (codeEl) codeEl.textContent = langMap[savedLang].code;
                    var items = document.querySelectorAll('.cool-lang-item');
                    items.forEach(function(item) {
                        if (item.getAttribute('data-lang') === savedLang) {
                            item.classList.add('active');
                        } else {
                            item.classList.remove('active');
                        }
                    });
                }
            }
        });
    </script>

    <!-- Instant Page Speed Prefetching -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/instant.page/5.2.0/instantpage.min.js" type="module"></script>

    @livewireScripts
    @stack('scripts')
</body>
</html>
