@extends('layouts.app')

@section('title', 'Tentang Kami | ' . ($siteSettings['site_name'] ?? 'Islenesia'))
@section('meta_description', 'Profil ' . ($siteSettings['site_name'] ?? 'Islenesia') . ': Agregator komoditas pertanian Indonesia yang menghubungkan petani lokal dengan pasar ekspor China dan Eropa.')

@section('content')

<!-- Header Banner -->
<div style="background: radial-gradient(circle at 30% 30%, #152E5E 0%, #0B1B3D 70%, #061124 100%); color: #FFFFFF; padding: 4.5rem 0 3.5rem; border-bottom: 2px solid rgba(212, 175, 55, 0.3);">
    <div class="container text-center" style="max-width: 800px; margin: 0 auto;">
        <span class="section-subtitle" style="color: var(--gold-light);">TENTANG {{ strtoupper($siteSettings['site_name'] ?? 'ISLENESIA') }}</span>
        <h1 style="color: #FFFFFF; font-size: 2.75rem; margin-bottom: 1rem;">Membangun Reputasi Agro Nusantara di Dunia</h1>
        <p style="color: #CBD5E1; font-size: 1.05rem;">
            Agregator komoditas agrikultur terpercaya dengan komitmen mutu internasional, transparansi rantai pasok, dan pemberdayaan petani lokal.
        </p>
    </div>
</div>

<section class="section">
    <div class="container">
        <!-- Story & Company Intro -->
        <div style="max-width: 950px; margin-bottom: 3.5rem;">
            <div>
                <span class="section-subtitle">SEJARAH & MISI KAMI</span>
                <h2 class="section-title" style="margin-bottom: 1.25rem;">
                    {{ $about['company_name'] }}
                </h2>
                <div style="font-size: 1.05rem; color: var(--slate-body); line-height: 1.8; margin-bottom: 1.75rem;">
                    <p style="margin-bottom: 1rem;">
                        {{ $about['story'] ?? 'Islenesia didirikan dengan tekad kuat untuk mengangkat komoditas pertanian terbaik Indonesia ke panggung internasional. Beroperasi sebagai agregator terpercaya, kami bekerja sama langsung dengan lebih dari 1.400 petani mitra di berbagai sentra perkebunan nusantara.' }}
                    </p>
                    <p>
                        Dengan memangkas rantai perantara yang tidak efisien, kami memastikan petani memperoleh harga yang adil serta pembeli internasional (Eropa, China, Asia Timur, dan Amerika) mendapatkan kepastian pasokan, transparansi mutu laboratorium, dan harga yang sangat kompetitif.
                    </p>
                </div>

                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <button type="button" class="btn btn-gold btn-sm" onclick="openWhatsAppModal('buyer')">
                        <i class="fa-solid fa-handshake"></i>
                        <span>Kemitraan Pembeli</span>
                    </button>
                    <button type="button" class="btn btn-outline-navy btn-sm" onclick="openWhatsAppModal('petani')">
                        <i class="fa-solid fa-leaf"></i>
                        <span>Kemitraan Petani</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats & Visual Card (Jejak Langkah Global) with Generous Top & Bottom Margin -->
        <div class="about-stats-card" style="background: var(--navy-deep); border: 2px solid rgba(212, 175, 55, 0.3); border-radius: 20px; padding: 2.75rem 2.5rem; color: #FFFFFF; box-shadow: var(--shadow-xl); margin-top: 3.5rem; margin-bottom: 4rem;">
            <div style="border-bottom: 1px solid rgba(255, 255, 255, 0.1); padding-bottom: 1.5rem; margin-bottom: 2rem;">
                <span style="font-size: 0.775rem; color: var(--gold-light); font-weight: 700; letter-spacing: 0.05em;">TRACK RECORD EKSPOR</span>
                <h3 style="color: #FFFFFF; font-size: 1.5rem; margin-top: 0.25rem;">Jejak Langkah Global</h3>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem;">
                <div>
                    <h4 style="font-size: 2.25rem; color: var(--gold-primary); font-weight: 800; line-height: 1.1;">{{ $about['countries'] }}</h4>
                    <p style="color: #94A3B8; font-size: 0.85rem; margin-top: 0.35rem; font-weight: 500;">Negara Tujuan Ekspor</p>
                </div>
                <div>
                    <h4 style="font-size: 2.25rem; color: var(--gold-primary); font-weight: 800; line-height: 1.1;">{{ $about['tons'] }} MT</h4>
                    <p style="color: #94A3B8; font-size: 0.85rem; margin-top: 0.35rem; font-weight: 500;">Komoditas Terkirim</p>
                </div>
                <div>
                    <h4 style="font-size: 2.25rem; color: var(--gold-primary); font-weight: 800; line-height: 1.1;">{{ $about['farmers'] }}</h4>
                    <p style="color: #94A3B8; font-size: 0.85rem; margin-top: 0.35rem; font-weight: 500;">Petani Mitra Binaan</p>
                </div>
                <div>
                    <h4 style="font-size: 2.25rem; color: var(--gold-primary); font-weight: 800; line-height: 1.1;">{{ $about['established'] }}</h4>
                    <p style="color: #94A3B8; font-size: 0.85rem; margin-top: 0.35rem; font-weight: 500;">Tahun Berdiri</p>
                </div>
            </div>
        </div>

        <!-- Vision and Mission Grid (Dynamic from CMS) with Generous Top & Bottom Margin -->
        <div class="vision-mission-grid" style="display: grid; grid-template-columns: 1fr 1.25fr; gap: 2.5rem; margin-top: 4rem; margin-bottom: 5rem; align-items: stretch;">
            <!-- Vision -->
            <div style="background: #FFFFFF; padding: 2.5rem; border-radius: 20px; border: 1px solid var(--slate-border); box-shadow: var(--shadow-sm); position: relative; overflow: hidden; display: flex; flex-direction: column;">
                <div style="position: absolute; top: -10px; right: -10px; width: 80px; height: 80px; background: rgba(212, 175, 55, 0.1); border-radius: 50%;"></div>
                <div style="width: 50px; height: 50px; background: rgba(212, 175, 55, 0.15); color: var(--gold-dark); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; border-radius: 12px; margin-bottom: 1.25rem;">
                    <i class="fa-solid fa-eye"></i>
                </div>
                <h3 style="font-size: 1.5rem; color: var(--navy-primary); margin-bottom: 1rem;">Visi Perusahaan</h3>
                <p style="font-size: 1rem; color: var(--slate-body); line-height: 1.7; flex-grow: 1;">
                    {{ $about['vision'] ?? 'Menjadi agregator komoditas agrikultur nomor satu di Asia Tenggara yang menghubungkan ribuan petani nusantara ke jaringan pasar internasional dengan standar mutu dunia, transparansi, dan keberlanjutan.' }}
                </p>
            </div>

            <!-- Mission -->
            <div style="background: #FFFFFF; padding: 2.5rem; border-radius: 20px; border: 1px solid var(--slate-border); box-shadow: var(--shadow-sm); display: flex; flex-direction: column;">
                <div style="width: 50px; height: 50px; background: rgba(11, 27, 61, 0.08); color: var(--navy-primary); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; border-radius: 12px; margin-bottom: 1.25rem;">
                    <i class="fa-solid fa-bullseye"></i>
                </div>
                <h3 style="font-size: 1.5rem; color: var(--navy-primary); margin-bottom: 1rem;">Misi Strategis</h3>
                @php
                    $rawMission = $about['mission'] ?? "1. Menjamin standar kualitas ekspor tertinggi dengan pengawasan mutu laboratorium bersertifikasi (Phytosanitary, Lab Purity, Moisture Control).\n2. Membangun ekosistem kemitraan petani yang adil, berkelanjutan, dan didukung transfer teknologi pasca-panen.\n3. Memberikan kepastian logistik, kepatuhan regulasi kepabeanan, dan keamanan transaksi bagi pembeli di Eropa, China, dan seluruh dunia.\n4. Menjadi jembatan terpercaya antara kekayaan alam nusantara dengan kebutuhan manufaktur makanan, farmasi, dan rempah global.";
                    $missionItems = preg_split('/(?=\b\d+\.\s*)/', $rawMission, -1, PREG_SPLIT_NO_EMPTY);
                @endphp
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.95rem; flex-grow: 1;">
                    @foreach($missionItems as $mItem)
                        @php $cleanM = trim($mItem); @endphp
                        @if(!empty($cleanM))
                            <li style="display: flex; gap: 0.75rem; align-items: flex-start; font-size: 0.95rem; color: var(--slate-body); line-height: 1.65;">
                                <span style="color: var(--gold-dark); font-size: 1rem; margin-top: 1px; flex-shrink: 0;"><i class="fa-solid fa-circle-check"></i></span>
                                <span>{{ preg_replace('/^\d+\.\s*/', '', $cleanM) }}</span>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Global Destination Markets Map/Grid (China & Europe Emphasis!) -->
        <div style="background: #FFFFFF; border-radius: 20px; padding: 3rem 2.5rem; border: 1px solid var(--slate-border); box-shadow: var(--shadow-sm); margin-bottom: 5rem;">
            <div class="section-header" style="margin-bottom: 2.5rem;">
                <span class="section-subtitle">DESTINASI EKSPOR UTAMA</span>
                <h2 class="section-title">Pasar Global yang Kami Layani</h2>
                <p class="section-desc">Kontainer komoditas ekspor kami dikirim secara rutin dan terjadwal ke berbagai pasar dan industri utama dunia.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem;">
                <div style="background: #F8FAFC; border: 1px solid var(--slate-border); border-radius: 12px; padding: 1.5rem; text-align: center;">
                    <span style="font-size: 2.5rem; margin-bottom: 0.5rem; display: block;">🇨🇳</span>
                    <h4 style="color: var(--navy-primary); font-size: 1.1rem; margin-bottom: 0.35rem;">Pasar China & Asia Timur</h4>
                    <p style="font-size: 0.825rem; color: var(--slate-muted);">Shanghai, Guangzhou, Tianjin, Qingdao. Sesuai protokol pabean GACC.</p>
                </div>

                <div style="background: #F8FAFC; border: 1px solid var(--slate-border); border-radius: 12px; padding: 1.5rem; text-align: center;">
                    <span style="font-size: 2.5rem; margin-bottom: 0.5rem; display: block;">🇪🇺</span>
                    <h4 style="color: var(--navy-primary); font-size: 1.1rem; margin-bottom: 0.35rem;">Pasar Uni Eropa</h4>
                    <p style="font-size: 0.825rem; color: var(--slate-muted);">Rotterdam, Hamburg, Le Havre, Antwerpen. Sesuai standar EU MRL & Lab Purity.</p>
                </div>

                <div style="background: #F8FAFC; border: 1px solid var(--slate-border); border-radius: 12px; padding: 1.5rem; text-align: center;">
                    <span style="font-size: 2.5rem; margin-bottom: 0.5rem; display: block;">🇦🇪</span>
                    <h4 style="color: var(--navy-primary); font-size: 1.1rem; margin-bottom: 0.35rem;">Timur Tengah & Afrika Utara</h4>
                    <p style="font-size: 0.825rem; color: var(--slate-muted);">Jebel Ali (Dubai), Jeddah, Alexandria untuk rempah dan biji kopi.</p>
                </div>

                <div style="background: #F8FAFC; border: 1px solid var(--slate-border); border-radius: 12px; padding: 1.5rem; text-align: center;">
                    <span style="font-size: 2.5rem; margin-bottom: 0.5rem; display: block;">🇮🇩</span>
                    <h4 style="color: var(--navy-primary); font-size: 1.1rem; margin-bottom: 0.35rem;">Industri Domestik</h4>
                    <p style="font-size: 0.825rem; color: var(--slate-muted);">Pabrik makanan, farmasi herbal, dan industri ekstraksi skala besar Indonesia.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    @media (max-width: 992px) {
        .vision-mission-grid {
            grid-template-columns: 1fr !important;
            gap: 2rem !important;
            margin-top: 2.5rem !important;
            margin-bottom: 3.5rem !important;
        }
        .about-stats-card {
            margin-top: 2.5rem !important;
            margin-bottom: 3rem !important;
            padding: 2rem 1.5rem !important;
        }
    }
</style>
@endpush

@endsection
