@extends('layouts.admin')

@section('title', 'Buku Panduan Penggunaan Admin (Manual Book)')
@section('header_title', 'Buku Panduan & Manual Book Sistem Admin')

@section('content')

<style>
    .manual-hero {
        background: radial-gradient(circle at 50% 0%, #152E5E 0%, #0B1B3D 70%, #061124 100%);
        color: #FFFFFF;
        border-radius: 16px;
        padding: 2.25rem 2rem;
        margin-bottom: 2rem;
        border: 1.5px solid rgba(212, 175, 55, 0.35);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .manual-hero h2 {
        font-size: 1.65rem;
        font-weight: 800;
        color: #FFFFFF;
        margin-bottom: 0.5rem;
    }

    .manual-hero p {
        color: #CBD5E1;
        font-size: 0.925rem;
        max-width: 680px;
        line-height: 1.6;
        margin: 0;
    }

    .manual-nav-pill-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 0.85rem;
        margin-bottom: 2.5rem;
    }

    .manual-nav-pill {
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        border-radius: 12px;
        padding: 0.85rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: var(--admin-navy-surface);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 700;
        transition: all 0.25s ease;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
    }

    .manual-nav-pill:hover {
        background: #F8FAFC;
        border-color: var(--admin-gold);
        color: #927218;
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(212, 175, 55, 0.2);
    }

    .manual-nav-pill i {
        font-size: 1.15rem;
        color: var(--admin-gold);
        width: 24px;
        text-align: center;
    }

    .manual-card {
        background: #FFFFFF;
        border-radius: 16px;
        border: 1.5px solid #E2E8F0;
        padding: 2rem;
        margin-bottom: 2.5rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        scroll-margin-top: 90px;
    }

    .manual-chapter-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        background: rgba(212, 175, 55, 0.15);
        color: #927218;
        border: 1px solid rgba(212, 175, 55, 0.35);
        padding: 0.3rem 0.85rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        margin-bottom: 0.75rem;
    }

    .manual-card-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--admin-navy-deep);
        margin-bottom: 0.5rem;
    }

    .manual-lead-desc {
        color: #64748B;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .relation-banner {
        background: #F1F5F9;
        border-left: 4px solid var(--admin-navy-surface);
        padding: 1rem 1.25rem;
        border-radius: 0 10px 10px 0;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        color: #334155;
    }

    .relation-banner strong {
        color: var(--admin-navy-deep);
    }

    .ss-showcase {
        margin: 1.5rem 0 2rem;
        background: #F8FAFC;
        border: 1.5px solid #E2E8F0;
        border-radius: 12px;
        overflow: hidden;
    }

    .ss-showcase-header {
        background: #F1F5F9;
        padding: 0.65rem 1rem;
        border-bottom: 1px solid #E2E8F0;
        font-size: 0.8rem;
        font-weight: 700;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .ss-showcase-header span.badge-tag {
        background: var(--admin-navy-surface);
        color: #FFFFFF;
        padding: 0.2rem 0.6rem;
        border-radius: 6px;
        font-size: 0.72rem;
    }

    .ss-showcase-header span.badge-tag-frontend {
        background: #10B981;
        color: #FFFFFF;
        padding: 0.2rem 0.6rem;
        border-radius: 6px;
        font-size: 0.72rem;
    }

    .ss-showcase-img {
        width: 100%;
        display: block;
        max-height: 480px;
        object-fit: cover;
        object-position: top;
        border-bottom: 1px solid #E2E8F0;
        transition: transform 0.3s ease;
    }

    .ss-caption {
        padding: 0.75rem 1rem;
        font-size: 0.8rem;
        color: #64748B;
        font-style: italic;
    }

    .action-step-card {
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.25rem;
    }

    .action-step-card h5 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--admin-navy-surface);
        display: flex;
        align-items: center;
        gap: 0.65rem;
        margin-bottom: 0.75rem;
    }

    .action-step-card h5 .step-num {
        width: 28px;
        height: 28px;
        background: var(--admin-gold);
        color: var(--admin-navy-deep);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 800;
    }

    .field-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
        margin-top: 0.75rem;
    }

    .field-table th {
        background: #F1F5F9;
        color: #334155;
        text-align: left;
        padding: 0.6rem 0.85rem;
        border: 1px solid #E2E8F0;
        font-weight: 700;
    }

    .field-table td {
        padding: 0.6rem 0.85rem;
        border: 1px solid #E2E8F0;
        color: #475569;
        vertical-align: top;
    }

    .tip-box {
        background: #FEF9C3;
        border: 1px solid #FDE047;
        border-radius: 10px;
        padding: 0.85rem 1rem;
        margin: 1rem 0;
        font-size: 0.825rem;
        color: #713F12;
        display: flex;
        gap: 0.75rem;
        align-items: flex-start;
    }

    .tip-box i {
        font-size: 1.15rem;
        color: #EAB308;
        margin-top: 0.1rem;
    }

    .top-jump-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.78rem;
        color: #64748B;
        text-decoration: none;
        float: right;
        font-weight: 600;
    }

    .top-jump-btn:hover {
        color: var(--admin-gold);
    }
</style>

<!-- Top Banner Manual Book -->
<div class="manual-hero">
    <div>
        <div style="display:inline-flex; align-items:center; gap:0.4rem; background:rgba(212,175,55,0.25); color:var(--admin-gold); padding:0.25rem 0.75rem; border-radius:999px; font-size:0.75rem; font-weight:800; margin-bottom:0.6rem;">
            <i class="fa-solid fa-circle-check"></i> RESMI & TERINTEGRASI
        </div>
        <h2>Buku Panduan Pengelolaan Website (Manual Book)</h2>
        <p>
            Dokumentasi lengkap langkah demi langkah untuk menginput, mengubah, dan menghapus konten pada website <strong>Islenesia (PT Islenesia Agro Nusantara)</strong>. Setiap bagian dilengkapi petunjuk lokasi menu, tangkapan layar (screenshot), serta hubungan antara halaman depan website dengan panel admin.
        </p>
    </div>
    <div style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); border-radius:12px; padding:1.25rem; min-width:240px;">
        <div style="font-size:0.75rem; color:#94A3B8; text-transform:uppercase; letter-spacing:0.05em; font-weight:700;">Akun Administrator Resmi</div>
        <div style="font-size:0.95rem; font-weight:700; color:#FFFFFF; margin-top:0.25rem;">admin@islenesia.com</div>
        <div style="font-size:0.78rem; color:var(--admin-gold); margin-top:0.2rem;">Portal: /portal-access</div>
        <a href="{{ route('home') }}" target="_blank" class="btn-admin btn-admin-gold" style="display:block; text-align:center; margin-top:0.75rem; font-size:0.8rem; padding:0.45rem;">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Website Depan
        </a>
    </div>
</div>

<!-- Quick Navigation Bar -->
<h4 style="font-size: 1rem; font-weight: 800; color: var(--admin-navy-surface); margin-bottom: 0.85rem;">
    <i class="fa-solid fa-compass" style="color: var(--admin-gold); margin-right: 0.4rem;"></i> DAFTAR ISI CEPAT (KLIK MENU UNTUK LONCAT KE PANDUAN)
</h4>

<div class="manual-nav-pill-grid">
    <a href="#bab-akses" class="manual-nav-pill">
        <i class="fa-solid fa-key"></i>
        <span>1. Akses Login & Keamanan</span>
    </a>
    <a href="#bab-logo" class="manual-nav-pill">
        <i class="fa-solid fa-sliders"></i>
        <span>2. Logo & WhatsApp Khusus</span>
    </a>
    <a href="#bab-slider" class="manual-nav-pill">
        <i class="fa-solid fa-images"></i>
        <span>3. Slider (Foto & Video YT)</span>
    </a>
    <a href="#bab-klien" class="manual-nav-pill">
        <i class="fa-solid fa-handshake"></i>
        <span>4. Klien Kami (Our Clients)</span>
    </a>
    <a href="#bab-partner" class="manual-nav-pill">
        <i class="fa-solid fa-building-shield"></i>
        <span>5. Partner Kami (Our Partners)</span>
    </a>
    <a href="#bab-produk" class="manual-nav-pill">
        <i class="fa-solid fa-boxes-stacked"></i>
        <span>6. Produk & Request Quote</span>
    </a>
    <a href="#bab-leads" class="manual-nav-pill">
        <i class="fa-solid fa-comments"></i>
        <span>7. Leads (Buyer & Pemasok)</span>
    </a>
    <a href="#bab-beranda" class="manual-nav-pill">
        <i class="fa-solid fa-newspaper"></i>
        <span>8. Teks Beranda & Angka</span>
    </a>
</div>

<!-- ========================================================================= -->
<!-- BAB 1: AKSES LOGIN & KEAMANAN -->
<!-- ========================================================================= -->
<div class="manual-card" id="bab-akses">
    <a href="#" class="top-jump-btn"><i class="fa-solid fa-arrow-up"></i> Ke Atas</a>
    <span class="manual-chapter-badge"><i class="fa-solid fa-shield-halved"></i> BAB 1</span>
    <h3 class="manual-card-title">Akses Login & Keamanan Portal Admin</h3>
    <p class="manual-lead-desc">
        Untuk menjaga keamanan website dari serangan bot dan pihak luar, website Islenesia <strong>tidak memiliki tombol login publik</strong> di halaman depan. Login dilakukan melalui link rahasia khusus.
    </p>

    <div class="relation-banner">
        <strong>URL Akses Rahasia:</strong> <code>https://islenesia.com/portal-access</code> (atau <code>http://127.0.0.1:8000/portal-access</code>)<br>
        <strong>Kredensial Default:</strong> Email: <code>admin@islenesia.com</code> | Password: <code>Islenesia2026!</code>
    </div>

    <!-- Screenshot Login -->
    <div class="ss-showcase">
        <div class="ss-showcase-header">
            <span><i class="fa-solid fa-image"></i> Tampilan Halaman Login Rahasia</span>
            <span class="badge-tag">Halaman: /portal-access</span>
        </div>
        <img src="{{ asset('images/manual-book/01_login_portal.png') }}" class="ss-showcase-img" alt="Halaman Login Portal">
        <div class="ss-caption">Tangkapan layar halaman login resmi Islenesia. Masukkan email dan password Anda di sini.</div>
    </div>

    <div class="action-step-card">
        <h5><span class="step-num">1</span> Cara Melakukan Login ke Admin Panel</h5>
        <ol style="margin-left: 1.5rem; color: #475569; font-size: 0.875rem; line-height: 1.7;">
            <li>Buka browser (Google Chrome, Edge, Safari, dll).</li>
            <li>Ketikkan alamat: <strong>https://islenesia.com/portal-access</strong> pada bar alamat browser Anda.</li>
            <li>Ketikkan Email: <strong>admin@islenesia.com</strong></li>
            <li>Ketikkan Password: <strong>Islenesia2026!</strong></li>
            <li>Klik tombol <strong>"Masuk ke Portal Admin"</strong>. Anda akan langsung diarahkan ke Dashboard.</li>
        </ol>
    </div>

    <div class="action-step-card">
        <h5><span class="step-num">2</span> Cara Mengubah Password / Profil Admin</h5>
        <ol style="margin-left: 1.5rem; color: #475569; font-size: 0.875rem; line-height: 1.7;">
            <li>Pada menu samping kiri paling bawah, klik menu <strong>"Profil & Keamanan"</strong>.</li>
            <li>Pada bagian <em>Ubah Password</em>, masukkan Password Baru dan Konfirmasi Password Baru Anda.</li>
            <li>Klik tombol <strong>"Perbarui Password"</strong>.</li>
        </ol>
    </div>
</div>

<!-- ========================================================================= -->
<!-- BAB 2: LOGO WEBSITE & WHATSAPP KHUSUS -->
<!-- ========================================================================= -->
<div class="manual-card" id="bab-logo">
    <a href="#" class="top-jump-btn"><i class="fa-solid fa-arrow-up"></i> Ke Atas</a>
    <span class="manual-chapter-badge"><i class="fa-solid fa-sliders"></i> BAB 2</span>
    <h3 class="manual-card-title">Mengubah Logo Website & Pengaturan WhatsApp Terpisah</h3>
    <p class="manual-lead-desc">
        Bagian ini mengatur logo resmi yang tampil di <strong>Navbar atas</strong> dan <strong>Footer bawah</strong>, serta pembagian nomor WhatsApp yang berbeda untuk penanganan <strong>Buyer (Beli)</strong> vs <strong>Pemasok (Jual)</strong>.
    </p>

    <div class="relation-banner">
        <strong>Di Mana Pengaturannya di Admin?</strong> Menu samping kiri: <strong>Pengaturan & SEO</strong> ➔ Tab 1 (Identitas & Logo) & Tab 2 (Kontak).<br>
        <strong>Di Mana Tampilnya di Halaman Depan?</strong> Logo muncul otomatis di navbar dan footer. Tombol WhatsApp melayang di kanan bawah serta di tombol penawaran.
    </div>

    <!-- Screenshot Settings Logo & Kontak -->
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
        <div class="ss-showcase">
            <div class="ss-showcase-header">
                <span><i class="fa-solid fa-image"></i> Upload Logo Website</span>
                <span class="badge-tag">Tab: Identitas & Logo</span>
            </div>
            <img src="{{ asset('images/manual-book/02_settings_identity.png') }}" class="ss-showcase-img" alt="Pengaturan Logo">
            <div class="ss-caption">Upload file logo perusahaan di form ini. Logo otomatis tersinkronisasi di navbar dan footer.</div>
        </div>

        <div class="ss-showcase">
            <div class="ss-showcase-header">
                <span><i class="fa-solid fa-image"></i> Pengaturan WhatsApp Buyer vs Pemasok</span>
                <span class="badge-tag">Tab: Kontak</span>
            </div>
            <img src="{{ asset('images/manual-book/02_settings_whatsapp.png') }}" class="ss-showcase-img" alt="Pengaturan WhatsApp Terpisah">
            <div class="ss-caption">Bedakan nomor WhatsApp sales buyer dan tim procurement pemasok di form khusus ini.</div>
        </div>
    </div>

    <div class="action-step-card">
        <h5><span class="step-num">1</span> Langkah Mengganti Logo Website</h5>
        <ol style="margin-left: 1.5rem; color: #475569; font-size: 0.875rem; line-height: 1.7;">
            <li>Klik menu <strong>Pengaturan & SEO</strong> pada sidebar.</li>
            <li>Pastikan Anda berada di <strong>Tab 1: Identitas & Branding</strong>.</li>
            <li>Pada kolom <strong>"Logo Utama Website"</strong>, klik tombol <em>Choose File / Telusuri</em>.</li>
            <li>Pilih file logo dari komputer Anda (disarankan format <strong>PNG transparan</strong> atau SVG).</li>
            <li>Scroll ke paling bawah dan klik tombol emas <strong>"Simpan Pengaturan Website"</strong>.</li>
            <li>Logo di navbar dan footer website depan akan langsung berubah saat itu juga.</li>
        </ol>
    </div>

    <div class="action-step-card">
        <h5><span class="step-num">2</span> Langkah Membedakan Nomor WhatsApp Buyer & Pemasok</h5>
        <ol style="margin-left: 1.5rem; color: #475569; font-size: 0.875rem; line-height: 1.7;">
            <li>Pada menu <strong>Pengaturan & SEO</strong>, klik <strong>Tab 2: Kontak & Lokasi</strong>.</li>
            <li>Isi <strong>Nomor WhatsApp Utama (Default)</strong>: Nomor umum perusahaan (contoh: <code>6285161313914</code>).</li>
            <li>Pada kotak khusus <em>Pengaturan WhatsApp Khusus (Buyer vs Pemasok)</em>:
                <ul style="margin-left: 1.25rem; margin-top: 0.35rem;">
                    <li><strong>Nomor WhatsApp Khusus Buyer (Beli)</strong>: Isi nomor WhatsApp admin yang menangani pemesanan ekspor dari pembeli (contoh: <code>62812xxxxxxxx</code>).</li>
                    <li><strong>Nomor WhatsApp Khusus Pemasok (Jual)</strong>: Isi nomor WhatsApp admin yang menangani pasokan petani/supplier komoditas (contoh: <code>62898xxxxxxxx</code>).</li>
                </ul>
            </li>
            <li>Klik tombol <strong>"Simpan Pengaturan Website"</strong>.</li>
            <li>Kini, saat pengunjung memilih tab <em>"Saya Buyer"</em> di popup WA, mereka akan terhubung ke WA Buyer. Jika memilih <em>"Saya Pemasok"</em>, mereka otomatis terhubung ke WA Pemasok.</li>
        </ol>
    </div>

    <div class="tip-box">
        <i class="fa-solid fa-lightbulb"></i>
        <div>
            <strong>Tips Format Nomor WhatsApp:</strong> Selalu gunakan format kode negara tanpa tanda plus atau spasi, misalnya: <strong>6281234567890</strong> (jangan 0812... dan jangan +62 812...).
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- BAB 3: HERO SLIDER (FOTO & VIDEO YOUTUBE) -->
<!-- ========================================================================= -->
<div class="manual-card" id="bab-slider">
    <a href="#" class="top-jump-btn"><i class="fa-solid fa-arrow-up"></i> Ke Atas</a>
    <span class="manual-chapter-badge"><i class="fa-solid fa-images"></i> BAB 3</span>
    <h3 class="manual-card-title">Kelola Banner Hero Slider (Foto & Video YouTube Autoplay)</h3>
    <p class="manual-lead-desc">
        Banner paling atas pada beranda website dirancang fleksibel: dapat diisi dengan <strong>Foto Banner</strong> beresolusi tinggi maupun <strong>Video YouTube</strong> yang berputar otomatis (*autoplay background loop*).
    </p>

    <div class="relation-banner">
        <strong>Di Mana Pengaturannya di Admin?</strong> Menu samping kiri: <strong>Hero Slider Beranda</strong> (URL: <code>/admin/sliders</code>).<br>
        <strong>Di Mana Tampilnya di Halaman Depan?</strong> Slider utama paling atas di halaman beranda (di bawah navbar).
    </div>

    <!-- Frontend vs Backend Slider Screenshot -->
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
        <div class="ss-showcase">
            <div class="ss-showcase-header">
                <span><i class="fa-solid fa-desktop"></i> Tampilan di Beranda Depan</span>
                <span class="badge-tag-frontend">Frontend Website</span>
            </div>
            <img src="{{ asset('images/manual-book/00_frontend_hero.png') }}" class="ss-showcase-img" alt="Tampilan Hero Slider Beranda">
            <div class="ss-caption">Banner slider beranda dengan navigasi panah, dot indicator, dan transisi halus.</div>
        </div>

        <div class="ss-showcase">
            <div class="ss-showcase-header">
                <span><i class="fa-solid fa-list-check"></i> Daftar Slider di Admin Panel</span>
                <span class="badge-tag">Menu: Hero Slider Beranda</span>
            </div>
            <img src="{{ asset('images/manual-book/03_sliders_index.png') }}" class="ss-showcase-img" alt="Daftar Slider di Admin">
            <div class="ss-caption">Tabel daftar banner dengan badge tipe (Foto / YouTube), status, tombol edit & hapus.</div>
        </div>
    </div>

    <!-- Screenshot Form Tambah Slider -->
    <div class="ss-showcase">
        <div class="ss-showcase-header">
            <span><i class="fa-solid fa-plus-circle"></i> Form Tambah Slider (Pilihan Foto vs Video YouTube)</span>
            <span class="badge-tag">Halaman: /admin/sliders/create</span>
        </div>
        <img src="{{ asset('images/manual-book/03_slider_create.png') }}" class="ss-showcase-img" alt="Form Tambah Slider">
        <div class="ss-caption">Fitur radio switch: Admin bisa memilih tipe Foto atau Video YouTube, lengkap dengan Live Preview video.</div>
    </div>

    <div class="action-step-card">
        <h5><span class="step-num">1</span> Cara Menambah Slider Foto Baru</h5>
        <ol style="margin-left: 1.5rem; color: #475569; font-size: 0.875rem; line-height: 1.7;">
            <li>Buka menu <strong>Hero Slider Beranda</strong>.</li>
            <li>Klik tombol emas <strong>"+ Tambah Slider Baru"</strong> di kanan atas.</li>
            <li>Pada pilihan <em>Tipe Banner</em>, pilih opsi <strong>"Foto / Gambar Banner"</strong>.</li>
            <li>Ketikkan <strong>Judul / Label Slider</strong> (misal: <em>Perkebunan Kopi Organik Nusantara</em>).</li>
            <li>Pilih file gambar Anda (disarankan ukuran <strong>1920 x 800 pixel</strong>).</li>
            <li>Isi <strong>Urutan Tampil</strong> (angka kecil tampil lebih awal, misal 1, 2, 3).</li>
            <li>Pastikan status <strong>"Publikasikan (Aktif di Beranda)"</strong> tercentang.</li>
            <li>Klik tombol <strong>"Simpan Banner Slider"</strong>.</li>
        </ol>
    </div>

    <div class="action-step-card">
        <h5><span class="step-num">2</span> Cara Menambah Slider Video YouTube (Autoplay Background)</h5>
        <ol style="margin-left: 1.5rem; color: #475569; font-size: 0.875rem; line-height: 1.7;">
            <li>Pada halaman <strong>Tambah Slider Baru</strong>, pada pilihan <em>Tipe Banner</em> klik opsi <strong>"Video YouTube"</strong>.</li>
            <li>Ketikkan <strong>Judul / Label Slider</strong> (misal: <em>Video Profil Ekspor Komoditas</em>).</li>
            <li>Masukkan link video YouTube pada kolom <strong>URL / Link Video YouTube</strong>.<br>
                Contoh link yang didukung: <code>https://www.youtube.com/watch?v=dQw4w9WgXcQ</code> atau <code>https://youtu.be/dQw4w9WgXcQ</code>.</li>
            <li>Kotak <strong>Live Preview</strong> di bawahnya akan otomatis memutar video sebagai verifikasi.</li>
            <li>(Opsional) Anda bisa upload gambar poster cadangan.</li>
            <li>Klik tombol <strong>"Simpan Banner Slider"</strong>. Di beranda depan video akan otomatis berputar tanpa suara sebagai background cover.</li>
        </ol>
    </div>

    <div class="action-step-card">
        <h5><span class="step-num">3</span> Cara Mengedit & Menghapus Slider</h5>
        <ul style="margin-left: 1.5rem; color: #475569; font-size: 0.875rem; line-height: 1.7;">
            <li><strong>Untuk Mengedit:</strong> Pada tabel slider, klik tombol kuning berikon pensil (<strong>Edit</strong>). Anda dapat mengubah foto, mengganti link YouTube, atau mengubah urutan tampil, lalu klik <em>"Perbarui Banner Slider"</em>.</li>
            <li><strong>Untuk Menghapus:</strong> Klik tombol merah berikon tempat sampah (<strong>Hapus</strong>), lalu tekan <em>OK</em> pada konfirmasi. Banner akan langsung terhapus dari beranda.</li>
        </ul>
    </div>
</div>

<!-- ========================================================================= -->
<!-- BAB 4: KLIEN KAMI (OUR CLIENTS) -->
<!-- ========================================================================= -->
<div class="manual-card" id="bab-klien">
    <a href="#" class="top-jump-btn"><i class="fa-solid fa-arrow-up"></i> Ke Atas</a>
    <span class="manual-chapter-badge"><i class="fa-solid fa-handshake"></i> BAB 4</span>
    <h3 class="manual-card-title">Kelola Logo Klien Kami (Our Clients)</h3>
    <p class="manual-lead-desc">
        Bagian ini menampilkan deretan logo perusahaan pembeli, distributor internasional, atau importir global yang bermitra dengan Islenesia. Logo berjalan otomatis 1 baris (*marquee auto-slide*) tepat di bawah hero section beranda untuk membangun kepercayaan calon buyer luar negeri.
    </p>

    <div class="relation-banner">
        <strong>Di Mana Pengaturannya di Admin?</strong> Menu samping kiri: <strong>Klien Kami (Our Clients)</strong> (URL: <code>/admin/clients</code>).<br>
        <strong>Di Mana Tampilnya di Halaman Depan?</strong> Section <em>"Jaringan Klien & Importir Global"</em> di beranda.
    </div>

    <!-- Screenshot Clients Index & Create -->
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
        <div class="ss-showcase">
            <div class="ss-showcase-header">
                <span><i class="fa-solid fa-list"></i> Tabel Logo Klien di Admin</span>
                <span class="badge-tag">Halaman: /admin/clients</span>
            </div>
            <img src="{{ asset('images/manual-book/04_clients_index.png') }}" class="ss-showcase-img" alt="Daftar Klien di Admin">
            <div class="ss-caption">Daftar logo klien dengan preview logo, negara/kategori, dan tombol aksi.</div>
        </div>

        <div class="ss-showcase">
            <div class="ss-showcase-header">
                <span><i class="fa-solid fa-plus"></i> Form Tambah Logo Klien</span>
                <span class="badge-tag">Halaman: /admin/clients/create</span>
            </div>
            <img src="{{ asset('images/manual-book/04_clients_create.png') }}" class="ss-showcase-img" alt="Form Tambah Klien">
            <div class="ss-caption">Form input nama perusahaan importir, negara asal, dan file gambar logo.</div>
        </div>
    </div>

    <div class="action-step-card">
        <h5><span class="step-num">1</span> Cara Menambahkan Logo Klien Baru</h5>
        <ol style="margin-left: 1.5rem; color: #475569; font-size: 0.875rem; line-height: 1.7;">
            <li>Klik menu <strong>Klien Kami (Our Clients)</strong> pada sidebar.</li>
            <li>Klik tombol emas <strong>"+ Tambah Logo Klien"</strong> di pojok kanan atas.</li>
            <li>Ketikkan <strong>Nama Klien / Perusahaan</strong> (misal: <em>Nordic Bio Imports GmbH</em>).</li>
            <li>Ketikkan <strong>Negara Asal / Tipe Klien</strong> (misal: <em>Hamburg, Germany</em> atau <em>Buyer B2B</em>).</li>
            <li>Pada kolom <strong>File Logo Klien</strong>, upload gambar logo (format PNG transparan disarankan, lebar sekitar 200–400px).</li>
            <li>Tentukan <strong>Urutan Tampil</strong> dan pastikan status <strong>Aktif</strong> tercentang.</li>
            <li>Klik tombol emas <strong>"Simpan Logo Klien"</strong>. Logo akan langsung ikut berjalan di deretan auto-slide beranda.</li>
        </ol>
    </div>

    <div class="action-step-card">
        <h5><span class="step-num">2</span> Cara Mengedit & Menghapus Logo Klien</h5>
        <ul style="margin-left: 1.5rem; color: #475569; font-size: 0.875rem; line-height: 1.7;">
            <li><strong>Edit:</strong> Klik tombol kuning (pensil) di samping data klien ➔ ubah nama atau ganti file logonya ➔ klik <em>"Perbarui Logo Klien"</em>.</li>
            <li><strong>Hapus:</strong> Klik tombol merah (tempat sampah) ➔ konfirmasi OK. Data logo klien akan terhapus.</li>
        </ul>
    </div>
</div>

<!-- ========================================================================= -->
<!-- BAB 5: PARTNER KAMI (OUR PARTNERS) -->
<!-- ========================================================================= -->
<div class="manual-card" id="bab-partner">
    <a href="#" class="top-jump-btn"><i class="fa-solid fa-arrow-up"></i> Ke Atas</a>
    <span class="manual-chapter-badge"><i class="fa-solid fa-building-shield"></i> BAB 5</span>
    <h3 class="manual-card-title">Kelola Partner & Mitra Strategis (Our Partners)</h3>
    <p class="manual-lead-desc">
        Bagian ini untuk menampilkan logo mitra ekosistem bisnis ekspor, seperti <strong>lembaga sertifikasi mutu laboratorium (Sucofindo, SGS)</strong>, <strong>badan karantina pemerintah</strong>, <strong>perusahaan pelayaran samudra (Maersk, CMA CGM)</strong>, serta <strong>koperasi petani</strong>.
    </p>

    <div class="relation-banner">
        <strong>Di Mana Pengaturannya di Admin?</strong> Menu samping kiri: <strong>Partner & Mitra (Our Partners)</strong> (URL: <code>/admin/partners</code>).<br>
        <strong>Di Mana Tampilnya di Halaman Depan?</strong> Section <em>"Partner & Mitra Strategis Kami"</em> berlatar navy gelap di atas testimoni.
    </div>

    <!-- Screenshot Partners Index & Create -->
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
        <div class="ss-showcase">
            <div class="ss-showcase-header">
                <span><i class="fa-solid fa-list"></i> Tabel Partner di Admin</span>
                <span class="badge-tag">Halaman: /admin/partners</span>
            </div>
            <img src="{{ asset('images/manual-book/05_partners_index.png') }}" class="ss-showcase-img" alt="Daftar Partner di Admin">
            <div class="ss-caption">Tabel data mitra strategis dengan logo badge, kategori sertifikasi, dan aksi.</div>
        </div>

        <div class="ss-showcase">
            <div class="ss-showcase-header">
                <span><i class="fa-solid fa-plus"></i> Form Tambah Partner</span>
                <span class="badge-tag">Halaman: /admin/partners/create</span>
            </div>
            <img src="{{ asset('images/manual-book/05_partners_create.png') }}" class="ss-showcase-img" alt="Form Tambah Partner">
            <div class="ss-caption">Input nama institusi/mitra dan kategori sertifikasi atau jasa logistiknya.</div>
        </div>
    </div>

    <div class="action-step-card">
        <h5><span class="step-num">1</span> Cara Menambahkan Partner Baru</h5>
        <ol style="margin-left: 1.5rem; color: #475569; font-size: 0.875rem; line-height: 1.7;">
            <li>Klik menu <strong>Partner & Mitra (Our Partners)</strong> pada sidebar.</li>
            <li>Klik tombol emas <strong>"+ Tambah Partner / Mitra"</strong> di pojok kanan atas.</li>
            <li>Ketikkan <strong>Nama Partner / Mitra</strong> (misal: <em>Sucofindo Indonesia</em> atau <em>Maersk Line</em>).</li>
            <li>Ketikkan <strong>Kategori / Bidang Kemitraan</strong> (misal: <em>Laboratorium & Sertifikasi Mutu</em> atau <em>Mitra Logistik Kontainer</em>).</li>
            <li>Upload file gambar logo partner (format PNG disarankan).</li>
            <li>Atur urutan dan centang status Aktif, lalu klik <strong>"Simpan Partner / Mitra"</strong>.</li>
        </ol>
    </div>
</div>

<!-- ========================================================================= -->
<!-- BAB 6: KATALOG KOMODITAS PRODUK & REQUEST A QUOTE -->
<!-- ========================================================================= -->
<div class="manual-card" id="bab-produk">
    <a href="#" class="top-jump-btn"><i class="fa-solid fa-arrow-up"></i> Ke Atas</a>
    <span class="manual-chapter-badge"><i class="fa-solid fa-boxes-stacked"></i> BAB 6</span>
    <h3 class="manual-card-title">Kelola Katalog Produk Komoditas & Fitur Request a Quote</h3>
    <p class="manual-lead-desc">
        Halaman katalog menyajikan komoditas ekspor unggulan (seperti Vanili, Kratom, Kopi Robusta, Cengkeh, Arang Briket, dll). Setiap produk dilengkapi spesifikasi teknis, sertifikat analisa laboratorium (COA), estimasi harga FOB/CIF, serta tombol interaktif <strong>"Request a Quote"</strong>.
    </p>

    <div class="relation-banner">
        <strong>Di Mana Pengaturannya di Admin?</strong> Menu samping kiri: <strong>Komoditas Produk</strong> (URL: <code>/admin/products</code>).<br>
        <strong>Di Mana Tampilnya di Halaman Depan?</strong> Halaman Katalog (<code>/catalog</code>), Detail Produk (<code>/catalog/{slug}</code>), dan Section Unggulan di Beranda.
    </div>

    <!-- Screenshot Products Index & Create -->
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
        <div class="ss-showcase">
            <div class="ss-showcase-header">
                <span><i class="fa-solid fa-boxes-stacked"></i> Tabel Seluruh Komoditas</span>
                <span class="badge-tag">Halaman: /admin/products</span>
            </div>
            <img src="{{ asset('images/manual-book/06_products_index.png') }}" class="ss-showcase-img" alt="Daftar Produk di Admin">
            <div class="ss-caption">Tabel inventori produk ekspor lengkap dengan harga acuan, stok, dan kategori.</div>
        </div>

        <div class="ss-showcase">
            <div class="ss-showcase-header">
                <span><i class="fa-solid fa-plus"></i> Form Input Komoditas Lengkap</span>
                <span class="badge-tag">Halaman: /admin/products/create</span>
            </div>
            <img src="{{ asset('images/manual-book/06_products_create.png') }}" class="ss-showcase-img" alt="Form Tambah Produk">
            <div class="ss-caption">Input nama, spesifikasi mutu COA, grade ekspor, harga FOB, dan upload foto produk.</div>
        </div>
    </div>

    <div class="action-step-card">
        <h5><span class="step-num">1</span> Cara Menambahkan Komoditas Baru</h5>
        <ol style="margin-left: 1.5rem; color: #475569; font-size: 0.875rem; line-height: 1.7;">
            <li>Klik menu <strong>Komoditas Produk</strong> pada sidebar ➔ klik <strong>"+ Tambah Komoditas Baru"</strong>.</li>
            <li>Isi informasi utama:
                <ul style="margin-left: 1.25rem; margin-top: 0.35rem;">
                    <li><strong>Nama Produk:</strong> Contoh: <em>Planifolia Gourmet Vanilla Beans (Grade A)</em>.</li>
                    <li><strong>Kategori:</strong> Pilih kategori (Rempah & Herbal, Biji Kopi, dsb).</li>
                    <li><strong>Harga Acuan / Estimasi:</strong> Contoh: <em>$180 - $220 / Kg FOB</em> atau <em>Negotiable based on Volume</em>.</li>
                    <li><strong>Minimal Order (MOQ):</strong> Contoh: <em>50 Kg (Sampel) / 1 Metric Ton (FCL)</em>.</li>
                    <li><strong>Spesifikasi Mutu / COA:</strong> Jelaskan kadar air, aroma, vanillin content, standar pengujian lab.</li>
                </ul>
            </li>
            <li>Upload <strong>Foto Utama Produk</strong> (disarankan foto asli yang jernih, rasio 4:3 atau 1:1).</li>
            <li>Klik tombol <strong>"Simpan Komoditas"</strong>.</li>
        </ol>
    </div>

    <div class="action-step-card">
        <h5><span class="step-num">2</span> Fitur Dual Channel "WhatsApp / Email" & Auto-Responder Bahasa Inggris untuk Buyer Eropa</h5>
        <p style="font-size: 0.875rem; color: #475569; line-height: 1.6; margin-bottom: 0.75rem;">
            Khusus pasar <strong>Eropa dan internasional</strong>, mayoritas buyer tidak menggunakan WhatsApp melainkan korespondensi resmi via <strong>Email Bisnis</strong>. Oleh karena itu, pada setiap kartu produk dan detail katalog, tombol ditampilkan dengan label <strong>"WhatsApp / Email"</strong>.
        </p>
        <ul style="margin-left: 1.25rem; color: #475569; font-size: 0.875rem; line-height: 1.6;">
            <li><strong>Jika Buyer memilih WhatsApp:</strong> Pesan penawaran harga FOB/CIF, COA lab, sampel, dan estimasi ongkir otomatis terbuka di WhatsApp Web / App terhubung ke nomor admin meja ekspor.</li>
            <li><strong>Jika Buyer memilih Email:</strong> Buyer cukup menginput email perusahaannya. Sistem secara otomatis mengirimkan <strong>Email Auto-Responder resmi dalam Bahasa Inggris</strong> (<em>Trade Inquiry Acknowledgment</em>) ke inbox buyer dan meneruskan notifikasi lengkap lead ke email Admin.</li>
            <li><strong>Pengaturan Server Email Hosting (cPanel):</strong> Dapat diatur dan diuji coba melalui menu <strong>Pengaturan Website ➔ Tab "Email SMTP & Hosting"</strong> dengan kredensial cPanel Anda (Port 465 SSL).</li>
        </ul>
    </div>

    <div class="action-step-card">
        <h5><span class="step-num">3</span> Fitur Galeri Foto Dokumentasi & QC (CMS Multi-Foto & Lightbox Interaktif)</h5>
        <p style="font-size: 0.875rem; color: #475569; line-height: 1.6; margin-bottom: 0.75rem;">
            Untuk meyakinkan calon buyer luar negeri tentang keaslian dan standar mutu ekspor, Anda dapat menambahkan <strong>beberapa foto dokumentasi</strong> pada setiap produk (misal: proses sortasi, pengeringan, pengujian laboratorium, hingga pengemasan vakum):
        </p>
        <ol style="margin-left: 1.5rem; color: #475569; font-size: 0.875rem; line-height: 1.7;">
            <li>Pada form <strong>Tambah / Edit Komoditas</strong>, lihat bagian <strong>"Galeri Foto Dokumentasi Produk & QC"</strong> di bawah tabel spesifikasi teknis.</li>
            <li>Klik tombol <strong>"+ Tambah Foto Galeri"</strong> untuk memunculkan kartu foto baru.</li>
            <li>Upload file foto dokumentasi Anda (JPG, PNG, atau WebP). Sistem akan langsung menampilkan pratinjau gambar secara real-time.</li>
            <li>Ketikkan <strong>Judul / Label Foto</strong> (misal: <em>Sortasi & Pengukuran Panjang Biji 18-20+ cm</em>).</li>
            <li>Ketikkan <strong>Deskripsi Singkat / Keterangan</strong> (misal: <em>Pemilahan manual batang biji vanili grade A dengan kelembapan terkontrol</em>).</li>
            <li>Anda dapat menambahkan beberapa foto sekaligus atau menghapus foto yang tidak diperlukan dengan tombol merah <strong>"Hapus"</strong>.</li>
            <li>Klik tombol <strong>"Simpan / Perbarui Komoditas"</strong>.</li>
        </ol>
        <div class="tip-box">
            <i class="fa-solid fa-lightbulb"></i>
            <div>
                <strong>Keunggulan Performa:</strong> Foto-foto galeri dimuat di halaman detail katalog secara <em>asynchronous</em> melalui JavaScript (AJAX lazy-load) sehingga tidak memberatkan loading awal halaman website. Pengunjung dapat mengklik foto mana saja untuk membukanya dalam mode <strong>Lightbox Layar Penuh</strong>, berpindah antar foto dengan tombol panah/keyboard, serta membaca informasi detail di bawah masing-masing foto.
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- BAB 7: LEADS AGREGATOR (BUYER & PEMASOK) -->
<!-- ========================================================================= -->
<div class="manual-card" id="bab-leads">
    <a href="#" class="top-jump-btn"><i class="fa-solid fa-arrow-up"></i> Ke Atas</a>
    <span class="manual-chapter-badge"><i class="fa-solid fa-comments"></i> BAB 7</span>
    <h3 class="manual-card-title">Memantau Leads Masuk (Buyer & Pemasok)</h3>
    <p class="manual-lead-desc">
        Setiap kali ada pengunjung yang mengirim pesan melalui tombol WhatsApp di website, sistem secara otomatis mencatat salinan datanya (Nama, Perusahaan, Nomor WA, Kebutuhan, dan Peran) ke dalam database admin panel ini.
    </p>

    <div class="relation-banner">
        <strong>Di Mana Pengaturannya di Admin?</strong> Menu samping kiri: <strong>Leads (Buyer & Pemasok)</strong> (URL: <code>/admin/inquiries</code>).<br>
        <strong>Fitur Utama:</strong> Penyaringan pesan per peran (Buyer Saja / Pemasok Saja), riwayat pesan, dan pembaruan status tindak lanjut.
    </div>

    <!-- Screenshot Inquiries -->
    <div class="ss-showcase">
        <div class="ss-showcase-header">
            <span><i class="fa-solid fa-table-list"></i> Tabel Riwayat Leads Masuk di Admin Panel</span>
            <span class="badge-tag">Halaman: /admin/inquiries</span>
        </div>
        <img src="{{ asset('images/manual-book/07_inquiries_index.png') }}" class="ss-showcase-img" alt="Tabel Leads Masuk">
        <div class="ss-caption">Tabel riwayat pesan masuk dengan tombol filter: "Semua", "Buyer Saja", dan "Pemasok Saja".</div>
    </div>

    <div class="action-step-card">
        <h5><span class="step-num">1</span> Cara Menindaklanjuti & Mengupdate Status Leads</h5>
        <ol style="margin-left: 1.5rem; color: #475569; font-size: 0.875rem; line-height: 1.7;">
            <li>Buka menu <strong>Leads (Buyer & Pemasok)</strong>.</li>
            <li>Gunakan tombol filter di kanan atas untuk memisahkan lead: klik <strong>"Buyer Saja"</strong> untuk melihat calon pembeli komoditas, atau <strong>"Pemasok Saja"</strong> untuk melihat penawaran pasokan dari petani/supplier.</li>
            <li>Klik tombol status (misal: <em>Baru</em>) untuk mengganti status tindak lanjut menjadi <strong>"Dihubungi"</strong>, <strong>"Deal"</strong>, atau <strong>"Selesai"</strong>.</li>
            <li>Anda juga dapat langsung mengklik nomor WhatsApp pengirim untuk membuka percakapan WhatsApp Web.</li>
        </ol>
    </div>
</div>

<!-- ========================================================================= -->
<!-- BAB 8: MENGUBAH TEKS BERANDA & ANGKA STATISTIK -->
<!-- ========================================================================= -->
<div class="manual-card" id="bab-beranda">
    <a href="#" class="top-jump-btn"><i class="fa-solid fa-arrow-up"></i> Ke Atas</a>
    <span class="manual-chapter-badge"><i class="fa-solid fa-newspaper"></i> BAB 8</span>
    <h3 class="manual-card-title">Mengubah Teks Beranda, Headline, & Angka Statistik</h3>
    <p class="manual-lead-desc">
        Teks utama beranda seperti lencana keaslian ekspor, judul besar (*headline*), sub-judul penjelasan, hingga counter angka pencapaian perusahaan (jumlah negara tujuan ekspor, tonase komoditas, dan jumlah petani binaan) dapat diubah dengan sangat mudah tanpa menyentuh kode program.
    </p>

    <div class="relation-banner">
        <strong>Di Mana Pengaturannya di Admin?</strong> Menu samping kiri: <strong>Pengaturan & SEO</strong> ➔ <strong>Tab 4 (Konten Beranda)</strong>.<br>
        <strong>Di Mana Tampilnya di Halaman Depan?</strong> Bagian atas halaman beranda tepat di bawah hero slider.
    </div>

    <!-- Screenshot Settings Home Tab -->
    <div class="ss-showcase">
        <div class="ss-showcase-header">
            <span><i class="fa-solid fa-pen-to-square"></i> Tab Konten Beranda di Panel Pengaturan</span>
            <span class="badge-tag">Tab: Konten Beranda</span>
        </div>
        <img src="{{ asset('images/manual-book/02_settings_home.png') }}" class="ss-showcase-img" alt="Pengaturan Konten Beranda">
        <div class="ss-caption">Form pengeditan teks headline, sub-headline hero, badge sertifikasi, dan teks ajakan ekspor.</div>
    </div>

    <div class="action-step-card">
        <h5><span class="step-num">1</span> Panduan Kolom Input Konten Beranda</h5>
        <table class="field-table">
            <thead>
                <tr>
                    <th style="width: 25%;">Nama Kolom di Admin</th>
                    <th style="width: 35%;">Nilai Saat Ini</th>
                    <th style="width: 40%;">Letak Tampil di Beranda</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Hero Badge</strong></td>
                    <td><code>VERIFIED AGRO EXPORTER & COMMODITY AGGREGATOR</code></td>
                    <td>Badge emas kecil di atas judul utama beranda.</td>
                </tr>
                <tr>
                    <td><strong>Hero Title (Judul Headline)</strong></td>
                    <td><code>Jembatan Pasok Komoditas Nusantara ke Pasar Global</code></td>
                    <td>Judul besar ukuran raksasa paling mencolok di beranda.</td>
                </tr>
                <tr>
                    <td><strong>Hero Subtitle</strong></td>
                    <td>Penjelasan kemitraan petani dan standar ekspor ke Eropa/China.</td>
                    <td>Paragraf deskripsi pengantar di bawah judul besar.</td>
                </tr>
                <tr>
                    <td><strong>Negara Tujuan Ekspor</strong></td>
                    <td><code>28+</code></td>
                    <td>Kotak statistik pertama di hero banner.</td>
                </tr>
                <tr>
                    <td><strong>Komoditas Terkirim</strong></td>
                    <td><code>5,400+</code></td>
                    <td>Kotak statistik kedua (Metric Tons).</td>
                </tr>
                <tr>
                    <td><strong>Petani Mitra Nusantara</strong></td>
                    <td><code>1,450+</code></td>
                    <td>Kotak statistik ketiga (Jumlah petani/kelompok tani).</td>
                </tr>
                <tr>
                    <td><strong>Kepuasan Buyer Global</strong></td>
                    <td><code>99.4%</code></td>
                    <td>Kotak statistik keempat.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="action-step-card">
        <h5><span class="step-num">2</span> Cara Mengubah Teks & Angka Statistik Tersebut</h5>
        <ol style="margin-left: 1.5rem; color: #475569; font-size: 0.875rem; line-height: 1.7;">
            <li>Buka menu <strong>Pengaturan & SEO</strong> pada sidebar kiri.</li>
            <li>Klik <strong>Tab 4: Konten Beranda</strong> (atau <strong>Tab 1</strong> untuk angka statistik).</li>
            <li>Ganti teks atau angka yang diinginkan pada kolom input terkait.</li>
            <li>Scroll ke paling bawah halaman dan klik tombol emas <strong>"Simpan Pengaturan Website"</strong>.</li>
            <li>Buka halaman beranda website Anda dan lakukan refresh, teks baru akan langsung diterapkan.</li>
        </ol>
    </div>
</div>

<!-- ========================================================================= -->
<!-- BAB 9: STANDAR TEKNIS GAMBAR & PERAWATAN WEBSITE -->
<!-- ========================================================================= -->
<div class="manual-card" id="bab-standar">
    <a href="#" class="top-jump-btn"><i class="fa-solid fa-arrow-up"></i> Ke Atas</a>
    <span class="manual-chapter-badge"><i class="fa-solid fa-circle-info"></i> BAB 9</span>
    <h3 class="manual-card-title">Standar Gambar & Panduan Perawatan Website</h3>
    <p class="manual-lead-desc">
        Gunakan panduan resolusi dan ukuran berkas berikut agar website selalu memuat dengan sangat cepat (*high performance*) saat diakses oleh buyer luar negeri:
    </p>

    <table class="field-table">
        <thead>
            <tr>
                <th>Jenis Konten</th>
                <th>Format Disarankan</th>
                <th>Dimensi / Ukuran Ideal</th>
                <th>Keterangan Tambahan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Logo Perusahaan</strong></td>
                <td>PNG (Transparan) / SVG</td>
                <td>Lebar 300 – 600 px</td>
                <td>Latar belakang transparan agar kontras di navbar putih dan badge footer.</td>
            </tr>
            <tr>
                <td><strong>Banner Hero Slider</strong></td>
                <td>JPG / WebP</td>
                <td>1920 x 800 px (Maks. 500 KB)</td>
                <td>Gunakan foto lanskap tajam pencahayaan natural.</td>
            </tr>
            <tr>
                <td><strong>Logo Klien & Partner</strong></td>
                <td>PNG (Transparan) / SVG</td>
                <td>Lebar 200 – 400 px (Maks. 150 KB)</td>
                <td>Crop tepi logo rapat agar ukuran proporsional di baris slider.</td>
            </tr>
            <tr>
                <td><strong>Foto Produk Komoditas</strong></td>
                <td>JPG / WebP / PNG</td>
                <td>800 x 800 px (1:1) atau 800 x 600 px (4:3)</td>
                <td>Tampilkan fisik komoditas bersih & kemasan ekspor.</td>
            </tr>
        </tbody>
    </table>

    <div class="tip-box" style="margin-top: 1.5rem; background: #ECFDF5; border-color: #A7F3D0; color: #065F46;">
        <i class="fa-solid fa-circle-check" style="color: #10B981;"></i>
        <div>
            <strong>Penyimpanan Otomatis:</strong> Seluruh data formulir, upload foto komoditas, logo klien/partner, dan perubahan teks tersimpan secara aman di database server dengan backup rutin. Jika Anda membutuhkan penambahan fitur di kemudian hari, hubungi tim developer pengembang web.
        </div>
    </div>
</div>

@endsection
