@extends('layouts.app')

@section('title', ($siteSettings['meta_title'] ?? 'Manunggaland') . ' | Direct Agro Commodity Exporter')

@section('content')

<style>
    /* Top Hero Image Slider Styles (Pure Visual, Responsive, No Text Overlays) */
    .hero-slider-section {
        background: radial-gradient(circle at 50% 0%, #152E5E 0%, #0B1B3D 70%, #061124 100%);
        padding: 2rem 0 1.5rem;
    }

    .hero-slider-wrapper {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.45);
        border: 2px solid rgba(212, 175, 55, 0.35);
        aspect-ratio: 21 / 9;
        min-height: 250px;
        max-height: 500px;
        background: #061124;
    }

    @media (max-width: 991px) {
        .hero-slider-wrapper {
            aspect-ratio: 16 / 9;
            min-height: 220px;
        }
    }

    @media (max-width: 576px) {
        .hero-slider-wrapper {
            aspect-ratio: 4 / 3;
            min-height: 200px;
            border-radius: 14px;
        }
    }

    .hero-slider-track {
        width: 100%;
        height: 100%;
        position: relative;
    }

    .hero-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        transform: scale(1.035);
    }

    .hero-slide.active {
        opacity: 1;
        visibility: visible;
        transform: scale(1);
    }

    .hero-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .slider-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: rgba(11, 27, 61, 0.7);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        color: #FFFFFF;
        border: 1.5px solid rgba(212, 175, 55, 0.5);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        transition: all 0.25s ease;
        z-index: 10;
    }

    .slider-nav-btn:hover {
        background: var(--gold-primary);
        color: var(--navy-deep);
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
    }

    .slider-prev-btn { left: 1.25rem; }
    .slider-next-btn { right: 1.25rem; }

    @media (max-width: 768px) {
        .slider-nav-btn {
            width: 36px;
            height: 36px;
            font-size: 0.9rem;
        }
        .slider-prev-btn { left: 0.5rem; }
        .slider-next-btn { right: 0.5rem; }
    }

    .slider-dots-bar {
        position: absolute;
        bottom: 1.25rem;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 0.6rem;
        z-index: 10;
        background: rgba(6, 17, 36, 0.6);
        padding: 0.4rem 0.85rem;
        border-radius: 9999px;
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .slider-dots-bar .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.45);
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        padding: 0;
    }

    .slider-dots-bar .dot.active {
        width: 30px;
        border-radius: 9999px;
        background: var(--gold-primary);
    }
</style>

<!-- Top Hero Image / Video Slider (Dynamic Images & YouTube Background Autoplay) -->
<section class="hero-slider-section">
    <div class="container">
        <div class="hero-slider-wrapper" id="homeHeroSlider">
            <div class="hero-slider-track">
                @php
                    $displaySlides = [];
                    if (isset($sliders) && $sliders->count() > 0) {
                        foreach ($sliders as $s) {
                            $displaySlides[] = [
                                'type' => $s->type ?? 'image',
                                'image_url' => $s->image_url,
                                'youtube_embed_url' => $s->youtube_embed_url,
                                'youtube_id' => $s->youtube_id,
                                'title' => $s->title ?? 'Hero Slide',
                            ];
                        }
                    } else {
                        $displaySlides = [
                            ['type' => 'image', 'image_url' => 'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?q=80&w=1920&auto=format&fit=crop', 'youtube_embed_url' => null, 'title' => 'Komoditas Premium'],
                            ['type' => 'image', 'image_url' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?q=80&w=1920&auto=format&fit=crop', 'youtube_embed_url' => null, 'title' => 'Pengapalan Global'],
                            ['type' => 'image', 'image_url' => 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?q=80&w=1920&auto=format&fit=crop', 'youtube_embed_url' => null, 'title' => 'Gudang & Sortir'],
                        ];
                    }
                    $slideCount = count($displaySlides);
                @endphp
                @foreach($displaySlides as $idx => $slideItem)
                    <div class="hero-slide {{ $slideItem['type'] === 'video' ? 'hero-slide-video' : '' }} {{ $idx === 0 ? 'active' : '' }}" data-slide="{{ $idx }}" data-type="{{ $slideItem['type'] }}">
                        @if($slideItem['type'] === 'video' && !empty($slideItem['youtube_embed_url']))
                            <div class="video-iframe-container">
                                <iframe 
                                    src="{{ $slideItem['youtube_embed_url'] }}" 
                                    title="{{ $slideItem['title'] }}"
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                    allowfullscreen
                                    loading="{{ $idx === 0 ? 'eager' : 'lazy' }}">
                                </iframe>
                            </div>
                        @else
                            <img src="{{ $slideItem['image_url'] }}" alt="{{ $slideItem['title'] }}" loading="{{ $idx === 0 ? 'eager' : 'lazy' }}">
                        @endif
                    </div>
                @endforeach
            </div>

            @if($slideCount > 1)
                <!-- Slider Navigation Arrows -->
                <button type="button" class="slider-nav-btn slider-prev-btn" onclick="prevHeroSlide()" aria-label="Previous Banner">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button type="button" class="slider-nav-btn slider-next-btn" onclick="nextHeroSlide()" aria-label="Next Banner">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>

                <!-- Slider Dot Indicators -->
                <div class="slider-dots-bar">
                    @foreach($displaySlides as $idx => $slideItem)
                        <button type="button" class="dot {{ $idx === 0 ? 'active' : '' }}" onclick="goToHeroSlide({{ $idx }})" aria-label="Slide {{ $idx + 1 }}"></button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Hero Section -->
<section class="hero-section" style="padding-top: 3.5rem;">
    <div class="container">
        <div class="hero-grid" style="display: block; max-width: 960px; margin: 0 auto; text-align: center;">
            <div class="hero-text-content" style="max-width: 100%;">
                <div class="hero-badge" style="margin-left: auto; margin-right: auto;">
                    <i class="fa-solid fa-certificate text-gold"></i>
                    <span>{{ $siteSettings['hero_badge'] ?? 'VERIFIED AGRO EXPORTER & COMMODITY AGGREGATOR' }}</span>
                </div>
                <h1 class="hero-title" style="margin-left: auto; margin-right: auto;">
                    {!! !empty($siteSettings['hero_title']) ? e($siteSettings['hero_title']) : 'Jembatan Pasok Komoditas Nusantara ke <span class="text-gold">Pasar Global</span>' !!}
                </h1>
                <p class="hero-desc" style="max-width: 820px; margin-left: auto; margin-right: auto;">
                    {{ $siteSettings['hero_subtitle'] ?? 'Menghubungkan ribuan petani pilihan Indonesia langsung ke pembeli industri di Eropa, China, Asia, dan dunia. Kualitas mutu teruji laboratorium, jaminan pasokan kontainer, dan kepatuhan standar ekspor internasional.' }}
                </p>

                <div style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center; margin-bottom: 2rem;">
                    <a href="{{ route('catalog.index') }}" class="btn btn-gold btn-lg">
                        <i class="fa-solid fa-boxes-stacked"></i>
                        <span>Katalog Komoditas Ekspor</span>
                    </a>
                    <button type="button" class="btn btn-outline-gold btn-lg" onclick="openWhatsAppModal('buyer')">
                        <i class="fa-brands fa-whatsapp"></i>
                        <span>Diskusi Kontrak Pembeli</span>
                    </button>
                </div>

                <!-- Live Counter Stats -->
                <div class="hero-stats-bar" style="max-width: 880px; margin-left: auto; margin-right: auto;">
                    <div class="stat-item">
                        <h3>{{ $stats['countries'] }}</h3>
                        <p>Negara Tujuan Ekspor</p>
                    </div>
                    <div class="stat-item">
                        <h3>{{ $stats['tons'] }} MT</h3>
                        <p>Komoditas Terkirim</p>
                    </div>
                    <div class="stat-item">
                        <h3>{{ $stats['farmers'] }}</h3>
                        <p>Petani Mitra Nusantara</p>
                    </div>
                    <div class="stat-item">
                        <h3>{{ $stats['satisfaction'] }}</h3>
                        <p>Kepuasan Buyer Global</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section 1: Our Global Clients (1-Row Infinite Auto-Slide Marquee) -->
<section class="trust-marquee-section trust-marquee-clients">
    <div class="container">
        <div class="marquee-header">
            <div class="marquee-badge">
                <i class="fa-solid fa-earth-americas"></i>
                <span>Our Global Buyers & Importers</span>
            </div>
            <h2 class="marquee-title">Jaringan Klien & Importir Global</h2>
            <p class="marquee-subtitle">
                Dipercaya oleh puluhan korporasi manufaktur pangan, industri ekstraksi, dan distributor grosir komoditas di lebih dari 28 negara.
            </p>
        </div>
    </div>

    <div class="marquee-wrapper">
        <div class="marquee-track">
            @php
                $clientList = $clients ?? collect();
                $defaultClients = [
                    ['name' => 'Nordic Bio Imports GmbH', 'country' => 'Hamburg, Germany'],
                    ['name' => 'Shanghai Agri Trading Corp', 'country' => 'Shanghai, China'],
                    ['name' => 'Yamato Spices Ltd', 'country' => 'Osaka, Japan'],
                    ['name' => 'Rotterdam Port Foods BV', 'country' => 'Rotterdam, Netherlands'],
                    ['name' => 'Al-Maktoum Global Commodity', 'country' => 'Dubai, UAE'],
                    ['name' => 'Antwerp Cacao & Coffee SA', 'country' => 'Antwerp, Belgium'],
                    ['name' => 'Pacific Rim Botanicals Inc', 'country' => 'California, USA'],
                ];
            @endphp

            @if($clientList->count() > 0)
                {{-- Loop twice for infinite scroll --}}
                @foreach($clientList as $client)
                    <div class="marquee-card">
                        <div class="marquee-logo-box">
                            <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" loading="lazy">
                        </div>
                        <div class="marquee-info">
                            <span class="marquee-name">{{ $client->name }}</span>
                            @if(!empty($client->country_or_type))
                                <span class="marquee-sub"><i class="fa-solid fa-location-dot" style="font-size:0.65rem;"></i> {{ $client->country_or_type }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
                @foreach($clientList as $client)
                    <div class="marquee-card">
                        <div class="marquee-logo-box">
                            <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" loading="lazy">
                        </div>
                        <div class="marquee-info">
                            <span class="marquee-name">{{ $client->name }}</span>
                            @if(!empty($client->country_or_type))
                                <span class="marquee-sub"><i class="fa-solid fa-location-dot" style="font-size:0.65rem;"></i> {{ $client->country_or_type }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                @foreach($defaultClients as $c)
                    <div class="marquee-card">
                        <div class="marquee-logo-box" style="background:#F1F5F9; border-radius:8px;">
                            <i class="fa-solid fa-building-wheat text-gold" style="font-size:1.5rem; color:#D4AF37;"></i>
                        </div>
                        <div class="marquee-info">
                            <span class="marquee-name">{{ $c['name'] }}</span>
                            <span class="marquee-sub"><i class="fa-solid fa-location-dot" style="font-size:0.65rem;"></i> {{ $c['country'] }}</span>
                        </div>
                    </div>
                @endforeach
                @foreach($defaultClients as $c)
                    <div class="marquee-card">
                        <div class="marquee-logo-box" style="background:#F1F5F9; border-radius:8px;">
                            <i class="fa-solid fa-building-wheat text-gold" style="font-size:1.5rem; color:#D4AF37;"></i>
                        </div>
                        <div class="marquee-info">
                            <span class="marquee-name">{{ $c['name'] }}</span>
                            <span class="marquee-sub"><i class="fa-solid fa-location-dot" style="font-size:0.65rem;"></i> {{ $c['country'] }}</span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<!-- Section: Featured Products / Commodities -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">{{ $siteSettings['home_catalog_badge'] ?? 'KATALOG KOMODITAS UNGGULAN' }}</span>
            <h2 class="section-title">{{ $siteSettings['home_catalog_title'] ?? 'Hasil Bumi Terbaik dari Perkebunan Nusantara' }}</h2>
            <p class="section-desc">
                {{ $siteSettings['home_catalog_subtitle'] ?? 'Setiap produk melalui proses kurasi ketat, pengeringan higienis, dan pengujian laboratorium independen sebelum pengapalan internasional.' }}
            </p>
        </div>

        <div class="product-grid">
            @foreach($products as $product)
                <div class="product-card">
                    <div class="product-image-wrap">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                        <span class="product-badge">{{ $product->category }}</span>
                    </div>
                    <div class="product-body">
                        <span class="product-category">{{ $product->category }}</span>
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <p class="product-desc">{{ $product->short_description }}</p>

                        @if(!empty($product->specifications) && is_array($product->specifications))
                            <div class="product-specs-list">
                                @php $count = 0; @endphp
                                @foreach($product->specifications as $k => $v)
                                    @if($count < 3)
                                        <span class="spec-chip"><strong>{{ $k }}:</strong> {{ $v }}</span>
                                        @php $count++; @endphp
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        <div style="display: flex; gap: 0.5rem; margin-top: auto;">
                            <a href="{{ route('catalog.show', $product->slug) }}" class="btn btn-outline-navy btn-sm" style="flex: 1; text-align: center; justify-content: center; padding: 0.45rem 0.5rem;">
                                <span>Detail</span>
                            </a>
                            <button type="button" class="btn btn-gold btn-sm" onclick="requestQuoteModal('{{ addslashes($product->name) }}', {{ $product->id }})" style="flex: 1.5; justify-content: center; padding: 0.45rem 0.65rem;" title="Request a Quote (Harga, COA, Sampel & Ongkir)">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                <span>Request a Quote</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: 3.5rem;">
            <a href="{{ route('catalog.index') }}" class="btn btn-navy btn-lg">
                <i class="fa-solid fa-list-check"></i>
                <span>Lihat Seluruh Katalog & Spesifikasi Lengkap</span>
            </a>
        </div>
    </div>
</section>

<!-- Section: Agro Aggregator Workflow (Farm to Port) -->
<section class="section workflow-section">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle" style="color: var(--gold-light);">{{ $siteSettings['workflow_badge'] ?? 'MODEL AGREGATOR TERPADU' }}</span>
            <h2 class="section-title">{{ $siteSettings['workflow_title'] ?? ('Bagaimana ' . ($siteSettings['site_name'] ?? 'Manunggaland') . ' Menjaga Rantai Pasok Global') }}</h2>
            <p class="section-desc">
                {{ $siteSettings['workflow_subtitle'] ?? 'Kami merestrukturisasi rantai pasok tradisional menjadi jalur ekspor yang transparan, aman, dan berdaya saing tinggi.' }}
            </p>
        </div>

        <div class="workflow-steps">
            <div class="step-card">
                <div class="step-number">01</div>
                <div style="font-size: 1.75rem; color: var(--gold-primary); margin-bottom: 0.75rem;">
                    <i class="fa-solid fa-handshake"></i>
                </div>
                <h3>Kemitraan Petani Langsung</h3>
                <p>Bermitra langsung dengan 1.450+ petani lokal nusantara dengan jaminan pembelian harga wajar dan pembinaan pasca-panen.</p>
            </div>

            <div class="step-card">
                <div class="step-number">02</div>
                <div style="font-size: 1.75rem; color: var(--gold-primary); margin-bottom: 0.75rem;">
                    <i class="fa-solid fa-microscope"></i>
                </div>
                <h3>Kontrol Mutu & Uji Lab</h3>
                <p>Uji laboratorium kadar air (moisture), residu pestisida, kemurnian mikrobiologi, dan sertifikasi Phytosanitary resmi.</p>
            </div>

            <div class="step-card">
                <div class="step-number">03</div>
                <div style="font-size: 1.75rem; color: var(--gold-primary); margin-bottom: 0.75rem;">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h3>Pengemasan Food-Grade</h3>
                <p>Kemasan vakum kedap udara dan GrainPro hermetic liner guna menjaga kesegaran dan profil aroma selama pelayaran lintas benua.</p>
            </div>

            <div class="step-card">
                <div class="step-number">04</div>
                <div style="font-size: 1.75rem; color: var(--gold-primary); margin-bottom: 0.75rem;">
                    <i class="fa-solid fa-ship"></i>
                </div>
                <h3>Pengapalan Port-to-Port</h3>
                <p>Dokumentasi kepabeanan lengkap (Bill of Lading, Certificate of Origin, Phytosanitary) dengan kepatuhan regulasi ekspor global dan asuransi kargo terpercaya.</p>
            </div>
        </div>
    </div>
</section>

<!-- Section: Why Choose Us (Pillars) -->
<section class="section" style="background-color: #F8FAFC;">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">{{ $siteSettings['why_choose_badge'] ?? 'KEUNGGULAN EKSPOR' }}</span>
            <h2 class="section-title">{{ $siteSettings['why_choose_title'] ?? ('Mengapa Buyer Eropa & China Memilih ' . ($siteSettings['site_name'] ?? 'Islenesia')) }}</h2>
            <p class="section-desc">
                {{ $siteSettings['why_choose_subtitle'] ?? 'Integritas transaksi bisnis internasional, kepastian volume kontainer, dan transparansi standar mutu tanpa perantara gelap.' }}
            </p>
        </div>

        <div class="pillars-grid">
            <div class="pillar-card">
                <div class="pillar-icon">
                    <i class="fa-solid fa-shield-virus"></i>
                </div>
                <h3>Sertifikasi & Kepatuhan Legal</h3>
                <p>Memenuhi protokol karantina pertanian, standar EU MRL Uni Eropa, serta registrasi GACC untuk pasar ekspor China.</p>
            </div>

            <div class="pillar-card">
                <div class="pillar-icon">
                    <i class="fa-solid fa-warehouse"></i>
                </div>
                <h3>Kapasitas Pasokan Kontainer</h3>
                <p>Didukung fasilitas gudang agregasi dan sistem inventori terjadwal untuk memenuhi kontrak FCL bulanan tanpa jeda.</p>
            </div>

            <div class="pillar-card">
                <div class="pillar-icon">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <h3>Transparansi Harga & Spesifikasi</h3>
                <p>Penetapan harga acuan pasar komoditas yang transparan dengan sertifikat hasil uji mutu independen (COA) di setiap pengiriman.</p>
            </div>

            <div class="pillar-card">
                <div class="pillar-icon">
                    <i class="fa-solid fa-users-gear"></i>
                </div>
                <h3>Pemberdayaan Petani Berkelanjutan</h3>
                <p>Kemitraan etis yang menguntungkan petani, menjaga kelestarian tanah, serta memastikan keaslian asal komoditas (traceability).</p>
            </div>
        </div>
    </div>
</section>

<!-- Section 2: Our Strategic Partners (1-Row Infinite Auto-Slide Marquee) -->
<section class="trust-marquee-section trust-marquee-partners">
    <div class="container">
        <div class="marquee-header">
            <div class="marquee-badge">
                <i class="fa-solid fa-handshake-simple"></i>
                <span>Strategic Ecosystem & Alliances</span>
            </div>
            <h2 class="marquee-title">Partner & Mitra Strategis Kami</h2>
            <p class="marquee-subtitle">
                Berkolaborasi dengan lembaga pengujian mutu terakreditasi internasional, perusahaan logistik samudra, dan asosiasi petani nusantara.
            </p>
        </div>
    </div>

    <div class="marquee-wrapper">
        <div class="marquee-track marquee-track-reverse">
            @php
                $partnerList = $partners ?? collect();
                $defaultPartners = [
                    ['name' => 'Sucofindo Indonesia', 'category' => 'Laboratorium & Sertifikasi Mutu'],
                    ['name' => 'Karantina Pertanian RI', 'category' => 'Phytosanitary Inspection'],
                    ['name' => 'Maersk Ocean Line', 'category' => 'Mitra Logistik Kontainer Global'],
                    ['name' => 'SGS International', 'category' => 'Inspeksi Kualitas Independen'],
                    ['name' => 'Gabungan Koperasi Petani', 'category' => 'Rantai Pasok Tani Berkelanjutan'],
                    ['name' => 'Kamar Dagang Indonesia', 'category' => 'Fasilitator Ekspor Internasional'],
                    ['name' => 'Halal Certification Board', 'category' => 'Jaminan Standar Higienitas'],
                ];
            @endphp

            @if($partnerList->count() > 0)
                @foreach($partnerList as $partner)
                    <div class="marquee-card">
                        <div class="marquee-logo-box">
                            <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" loading="lazy">
                        </div>
                        <div class="marquee-info">
                            <span class="marquee-name">{{ $partner->name }}</span>
                            @if(!empty($partner->category))
                                <span class="marquee-sub"><i class="fa-solid fa-certificate" style="font-size:0.65rem;"></i> {{ $partner->category }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
                {{-- Loop twice for seamless infinite marquee scroll --}}
                @foreach($partnerList as $partner)
                    <div class="marquee-card">
                        <div class="marquee-logo-box">
                            <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" loading="lazy">
                        </div>
                        <div class="marquee-info">
                            <span class="marquee-name">{{ $partner->name }}</span>
                            @if(!empty($partner->category))
                                <span class="marquee-sub"><i class="fa-solid fa-certificate" style="font-size:0.65rem;"></i> {{ $partner->category }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                @foreach($defaultPartners as $p)
                    <div class="marquee-card">
                        <div class="marquee-logo-box">
                            <i class="fa-solid fa-shield-halved text-gold" style="font-size:1.5rem; color:#D4AF37;"></i>
                        </div>
                        <div class="marquee-info">
                            <span class="marquee-name">{{ $p['name'] }}</span>
                            <span class="marquee-sub"><i class="fa-solid fa-certificate" style="font-size:0.65rem;"></i> {{ $p['category'] }}</span>
                        </div>
                    </div>
                @endforeach
                @foreach($defaultPartners as $p)
                    <div class="marquee-card">
                        <div class="marquee-logo-box">
                            <i class="fa-solid fa-shield-halved text-gold" style="font-size:1.5rem; color:#D4AF37;"></i>
                        </div>
                        <div class="marquee-info">
                            <span class="marquee-name">{{ $p['name'] }}</span>
                            <span class="marquee-sub"><i class="fa-solid fa-certificate" style="font-size:0.65rem;"></i> {{ $p['category'] }}</span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<!-- Section: Global Buyer Testimonials (Ultra Modern UI) -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">TESTIMONIAL INTERNASIONAL</span>
            <h2 class="section-title">Kepercayaan Pembeli dari Berbagai Benua</h2>
            <p class="section-desc">
                Pengalaman kerja sama nyata bersama mitra pembeli di Jerman, Belanda, China, dan industri manufaktur terkemuka.
            </p>
        </div>

        <div class="testimonials-grid">
            @foreach($testimonials as $testi)
                @php
                    $cName = $testi->client_name ?: 'Global Importer';
                    $cCompany = $testi->client_company ?: 'International Trade Partner';
                    $cCountry = $testi->client_country ?: 'Global';
                    
                    // Flag mapping
                    $cFlag = '🌍';
                    $cLower = strtolower($cCountry);
                    if (str_contains($cLower, 'germany') || str_contains($cLower, 'jerman')) $cFlag = '🇩🇪';
                    elseif (str_contains($cLower, 'china') || str_contains($cLower, 'tiongkok')) $cFlag = '🇨🇳';
                    elseif (str_contains($cLower, 'france') || str_contains($cLower, 'prancis')) $cFlag = '🇫🇷';
                    elseif (str_contains($cLower, 'indonesia')) $cFlag = '🇮🇩';
                    elseif (str_contains($cLower, 'netherlands') || str_contains($cLower, 'belanda')) $cFlag = '🇳🇱';
                    elseif (str_contains($cLower, 'united states') || str_contains($cLower, 'usa')) $cFlag = '🇺🇸';

                    $initials = strtoupper(substr($cName, 0, 2));
                @endphp
                <div class="testimonial-card-modern">
                    <div>
                        <div class="testimonial-header-flex">
                            <div class="testimonial-stars-wrap">
                                @for($s = 0; $s < ($testi->rating ?? 5); $s++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                            </div>
                            <i class="fa-solid fa-quote-right testimonial-quote-icon"></i>
                        </div>
                        <p class="testimonial-quote-text">"{{ $testi->content }}"</p>
                    </div>
                    
                    <div class="testimonial-footer-buyer">
                        @if(!empty($testi->avatar_url) && !str_contains($testi->avatar_url, 'ui-avatars'))
                            <img src="{{ $testi->avatar_url }}" alt="{{ $cName }}" style="width: 46px; height: 46px; border-radius: 50%; object-fit: cover; border: 2px solid var(--gold-primary); flex-shrink: 0;">
                        @else
                            <div class="testimonial-avatar-badge">
                                {{ $initials }}
                            </div>
                        @endif
                        <div class="testimonial-meta">
                            <h4>
                                <span>{{ $cName }}</span>
                                <span style="font-size: 1.1rem; margin-left: 0.25rem;">{{ $cFlag }}</span>
                            </h4>
                            <p>{{ $cCompany }} • {{ $cCountry }}</p>
                            <span class="verified-buyer-tag">
                                <i class="fa-solid fa-circle-check"></i> Verified Importer
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Section: Latest Market Insights / Blog -->
<section class="section" style="background-color: #F8FAFC;">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">WAWASAN PASAR AGRIKULTUR</span>
            <h2 class="section-title">Analisis Komoditas & Berita Ekspor Terbaru</h2>
            <p class="section-desc">
                Pelajari tren harga pasar global, regulasi karantina, dan wawasan teknis pengolahan komoditas nusantara.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem;">
            @foreach($latestPosts as $post)
                <div class="blog-card" style="background: #FFFFFF; border-radius: 16px; overflow: hidden; border: 1px solid var(--slate-border); box-shadow: var(--shadow-sm); display: flex; flex-direction: column;">
                    <div style="aspect-ratio: 16/9; overflow: hidden; position: relative;">
                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        <span style="position: absolute; top: 1rem; left: 1rem; background: var(--navy-primary); color: #FFFFFF; font-size: 0.75rem; font-weight: 600; padding: 0.25rem 0.75rem; border-radius: 9999px;">
                            {{ $post->category }}
                        </span>
                    </div>
                    <div style="padding: 1.5rem; display: flex; flex-direction: column; flex: 1;">
                        <div style="font-size: 0.8rem; color: var(--slate-muted); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fa-regular fa-calendar"></i>
                            <span>{{ $post->published_at ? $post->published_at->format('d M Y') : date('d M Y') }}</span>
                            <span>•</span>
                            <i class="fa-regular fa-eye"></i>
                            <span>{{ $post->views_count }} views</span>
                        </div>
                        <h3 style="font-size: 1.15rem; color: var(--navy-primary); margin-bottom: 0.75rem; line-height: 1.4;">
                            <a href="{{ route('blog.show', $post->slug) }}" style="color: inherit; text-decoration: none;">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p style="font-size: 0.875rem; color: var(--slate-body); margin-bottom: 1.25rem; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $post->excerpt }}
                        </p>
                        <div style="margin-top: auto; padding-top: 1rem; border-top: 1px solid var(--slate-border);">
                            <a href="{{ route('blog.show', $post->slug) }}" style="color: var(--navy-primary); font-weight: 600; font-size: 0.875rem; display: flex; align-items: center; gap: 0.35rem;">
                                <span>Baca Selengkapnya</span>
                                <i class="fa-solid fa-arrow-right" style="font-size: 0.75rem;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Section: FAQ Accordion (Frequently Asked Questions from CMS) -->
@if(!empty($faqs) && $faqs->count() > 0)
<section class="section" style="background-color: #FFFFFF;" id="faq-section">
    <div class="container" style="max-width: 900px;">
        <div class="section-header text-center" style="margin-bottom: 3rem;">
            <span class="section-subtitle">TANYA JAWAB EKSPOR</span>
            <h2 class="section-title">Pertanyaan yang Sering Diajukan (FAQ)</h2>
            <p class="section-desc">
                Informasi penting seputar prosedur pemesanan kontainer ekspor, kepatuhan regulasi, verifikasi mutu karantina, serta kemitraan hasil panen petani nusantara.
            </p>
        </div>

        <div class="faq-accordion-list" style="display: flex; flex-direction: column; gap: 1rem;">
            @foreach($faqs as $idx => $faq)
                <div class="faq-accordion-item" style="background: #F8FAFC; border-radius: 14px; border: 1.5px solid var(--slate-border); overflow: hidden; box-shadow: var(--shadow-sm); transition: all 0.2s ease;">
                    <button type="button" class="faq-accordion-header" onclick="toggleFaq({{ $idx }})" style="width: 100%; padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: center; background: none; border: none; text-align: left; cursor: pointer; font-family: inherit;">
                        <div style="display: flex; align-items: center; gap: 0.85rem; padding-right: 1rem;">
                            <span class="badge-custom" style="background: rgba(11, 27, 61, 0.08); color: var(--navy-primary); font-size: 0.75rem; white-space: nowrap;">
                                {{ $faq->category }}
                            </span>
                            <span style="font-size: 1.05rem; font-weight: 700; color: var(--navy-primary);">
                                {{ $faq->question }}
                            </span>
                        </div>
                        <i class="fa-solid fa-chevron-down faq-chevron-icon" id="faqChevron_{{ $idx }}" style="color: var(--gold-dark); transition: transform 0.3s ease; transform: {{ $idx === 0 ? 'rotate(180deg)' : 'rotate(0)' }}; flex-shrink: 0;"></i>
                    </button>
                    <div class="faq-accordion-body" id="faqBody_{{ $idx }}" style="padding: 0 1.5rem 1.25rem; display: {{ $idx === 0 ? 'block' : 'none' }}; border-top: 1px solid var(--slate-border); padding-top: 1rem;">
                        <p style="font-size: 0.95rem; color: var(--slate-body); line-height: 1.7; margin: 0;">
                            {{ $faq->answer }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: 2.5rem; background: rgba(11, 27, 61, 0.03); border-radius: 16px; padding: 2rem; border: 1.5px dashed rgba(212, 175, 55, 0.5);">
            <h4 style="color: var(--navy-primary); font-size: 1.15rem; margin-bottom: 0.5rem;">Masih Memiliki Pertanyaan Lain?</h4>
            <p style="color: var(--slate-muted); font-size: 0.9rem; margin-bottom: 1.25rem;">Admin ekspor kami siap memberikan klarifikasi teknis spesifikasi komoditas atau menjadwalkan konsultasi.</p>
            <button type="button" class="btn btn-gold btn-sm" onclick="openWhatsAppModal('buyer')">
                <i class="fa-brands fa-whatsapp"></i>
                <span>Tanyakan Langsung ke Admin Ekspor</span>
            </button>
        </div>
    </div>
</section>
@endif

<!-- Call to Action Section (Dynamic CMS Texts) -->
<section style="background: radial-gradient(circle at 50% 50%, #152E5E 0%, #0B1B3D 100%); color: #FFFFFF; padding: 5rem 0; text-align: center;">
    <div class="container" style="max-width: 800px;">
        <span style="color: var(--gold-light); font-size: 0.875rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 1rem; display: block;">
            {{ $siteSettings['cta_badge'] ?? 'MULAI KEMITRAAN BISNIS EKSPOR' }}
        </span>
        <h2 style="color: #FFFFFF; font-size: 2.5rem; margin-bottom: 1.25rem;">
            {{ $siteSettings['cta_title'] ?? 'Siap Menghubungkan Kebutuhan Komoditas Anda dengan Sumber Terbaik?' }}
        </h2>
        <p style="color: #CBD5E1; font-size: 1.05rem; margin-bottom: 2.5rem;">
            {!! !empty($siteSettings['cta_subtitle']) ? nl2br(e($siteSettings['cta_subtitle'])) : 'Baik Anda <strong>Buyer Internasional</strong> yang mencari kuota komoditas premium, maupun <strong>Pemasok / Supplier</strong> yang ingin menawarkan pasokan komoditas, sistem agregator ' . e($siteSettings['site_name'] ?? 'Manunggaland') . ' siap melayani.' !!}
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <button type="button" class="btn btn-gold btn-lg" onclick="openWhatsAppModal('buyer')">
                <i class="fa-solid fa-boxes-packing"></i>
                <span>Saya Buyer (Pesan Komoditas)</span>
            </button>
            <button type="button" class="btn btn-outline-gold btn-lg" onclick="openWhatsAppModal('pemasok')">
                <i class="fa-solid fa-truck-ramp-box"></i>
                <span>Saya Pemasok (Jual Komoditas)</span>
            </button>
        </div>
    </div>
</section>

@push('scripts')
<script>
    var currentSlide = 0;
    var sliderInterval = null;

    window.goToHeroSlide = function(index) {
        var slides = document.querySelectorAll('#homeHeroSlider .hero-slide');
        var dots = document.querySelectorAll('#homeHeroSlider .dot');
        var totalSlides = slides.length;
        if (totalSlides === 0) return;
        currentSlide = (index + totalSlides) % totalSlides;

        slides.forEach(function(slide, i) {
            if (i === currentSlide) {
                slide.classList.add('active');
            } else {
                slide.classList.remove('active');
            }
        });

        dots.forEach(function(dot, i) {
            if (i === currentSlide) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });

        if (sliderInterval) {
            clearTimeout(sliderInterval);
            startSliderTimer();
        }
    };

    window.nextHeroSlide = function() {
        window.goToHeroSlide(currentSlide + 1);
    };

    window.prevHeroSlide = function() {
        window.goToHeroSlide(currentSlide - 1);
    };

    function startSliderTimer() {
        if (sliderInterval) clearTimeout(sliderInterval);
        var slides = document.querySelectorAll('#homeHeroSlider .hero-slide');
        if (slides.length <= 1) return;
        var activeSlide = slides[currentSlide];
        var isVideo = activeSlide && activeSlide.getAttribute('data-type') === 'video';
        var delay = isVideo ? 9000 : 4200;
        sliderInterval = setTimeout(function() {
            window.nextHeroSlide();
        }, delay);
    }

    document.addEventListener('DOMContentLoaded', function() {
        var sliderWrapper = document.getElementById('homeHeroSlider');
        if (sliderWrapper) {
            sliderWrapper.addEventListener('mouseenter', function() {
                if (sliderInterval) clearTimeout(sliderInterval);
            });
            sliderWrapper.addEventListener('mouseleave', function() {
                startSliderTimer();
            });

            var touchStartX = 0;
            var touchEndX = 0;
            sliderWrapper.addEventListener('touchstart', function(e) {
                if (e.changedTouches && e.changedTouches[0]) {
                    touchStartX = e.changedTouches[0].screenX;
                }
            }, { passive: true });

            sliderWrapper.addEventListener('touchend', function(e) {
                if (e.changedTouches && e.changedTouches[0]) {
                    touchEndX = e.changedTouches[0].screenX;
                    if (touchStartX - touchEndX > 50) {
                        window.nextHeroSlide();
                    } else if (touchEndX - touchStartX > 50) {
                        window.prevHeroSlide();
                    }
                }
            }, { passive: true });

            startSliderTimer();
        }
    });

    window.toggleFaq = function(idx) {
        var body = document.getElementById('faqBody_' + idx);
        var chevron = document.getElementById('faqChevron_' + idx);
        if (!body) return;

        var isVisible = body.style.display === 'block';
        if (isVisible) {
            body.style.display = 'none';
            if (chevron) chevron.style.transform = 'rotate(0deg)';
        } else {
            body.style.display = 'block';
            if (chevron) chevron.style.transform = 'rotate(180deg)';
        }
    };
</script>
@endpush

@endsection
