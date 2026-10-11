@extends('layouts.app')

@section('title', $product->name . ' | Spesifikasi Ekspor ' . ($siteSettings['site_name'] ?? 'Islenesia'))
@section('meta_description', Str::limit(strip_tags($product->short_description), 160))
@section('og_image', $product->image_url)

@section('content')

<!-- Breadcrumb -->
<div style="background-color: #F1F5F9; padding: 1rem 0; border-bottom: 1px solid var(--slate-border); font-size: 0.85rem;">
    <div class="container">
        <a href="{{ route('home') }}" style="color: var(--slate-muted);">Beranda</a>
        <span style="margin: 0 0.5rem; color: #CBD5E1;">/</span>
        <a href="{{ route('catalog.index') }}" style="color: var(--slate-muted);">Katalog</a>
        <span style="margin: 0 0.5rem; color: #CBD5E1;">/</span>
        <span style="color: var(--navy-primary); font-weight: 600;">{{ $product->name }}</span>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="product-detail-grid">
            <!-- Left: Product Image & Export Guarantee -->
            <div>
                <div style="border-radius: 20px; overflow: hidden; border: 1px solid var(--slate-border); box-shadow: var(--shadow-lg); background-color: var(--navy-deep); aspect-ratio: 4/3; margin-bottom: 1.5rem;">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>

                <!-- Export Quality Assurance Badge Box -->
                <div style="background: rgba(11, 27, 61, 0.03); border: 1.5px dashed rgba(212, 175, 55, 0.5); border-radius: 16px; padding: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                        <i class="fa-solid fa-shield-halved text-gold" style="font-size: 1.5rem;"></i>
                        <h4 style="font-size: 1rem; color: var(--navy-primary);">Jaminan Mutu & Rantai Pasok Terverifikasi</h4>
                    </div>
                    <p style="font-size: 0.85rem; color: var(--slate-muted); line-height: 1.5;">
                        Seluruh produk diproses di bawah pengawasan ketat tim Quality Control {{ $siteSettings['site_name'] ?? 'Islenesia' }} dengan protokol sanitasi standar ekspor, sertifikasi Phytosanitary resmi dari Badan Karantina Pertanian Indonesia, dan jaminan keaslian asal komoditas (Single Origin Traceability).
                    </p>
                </div>
            </div>

            <!-- Right: Product Overview & Specifications Table -->
            <div>
                <span class="section-subtitle">{{ $product->category }}</span>
                <h1 style="font-size: 2.25rem; color: var(--navy-primary); margin-bottom: 1rem; line-height: 1.25;">
                    {{ $product->name }}
                </h1>
                
                <p style="font-size: 1rem; color: var(--slate-body); margin-bottom: 2rem; line-height: 1.6;">
                    {{ $product->short_description }}
                </p>

                <!-- Action CTA -->
                <div style="background: #FFFFFF; border: 1px solid var(--slate-border); border-radius: 16px; padding: 1.5rem; box-shadow: var(--shadow-sm); margin-bottom: 2rem;">
                    <span style="font-size: 0.8rem; font-weight: 700; color: var(--gold-dark); text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.35rem; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-circle-check text-gold"></i> Siap Melayani Kontrak Ekspor & Sampel Lab
                    </span>
                    <p style="font-size: 0.875rem; color: var(--slate-muted); margin-bottom: 1.25rem;">
                        Hubungi Meja Ekspor Resmi {{ $siteSettings['site_name'] ?? 'Islenesia' }} untuk penawaran harga FOB / CIF, pengiriman sampel uji laboratorium, atau negosiasi volume kontainer.
                    </p>
                    <button type="button" class="btn btn-gold btn-lg" style="width: 100%; font-size: 1.05rem; font-weight: 700;" onclick="requestQuoteModal('{{ addslashes($product->name) }}', {{ $product->id }})">
                        <i class="fa-solid fa-file-invoice-dollar" style="font-size: 1.25rem;"></i>
                        <span>Request a Quote (Harga, COA, Sampel & Ongkir)</span>
                    </button>
                </div>

                <!-- Specifications Table -->
                @if(!empty($product->specifications) && is_array($product->specifications))
                    <div style="background: #FFFFFF; border: 1px solid var(--slate-border); border-radius: 16px; overflow: hidden; box-shadow: var(--shadow-sm); margin-bottom: 2rem;">
                        <div style="background: var(--navy-primary); color: #FFFFFF; padding: 1rem 1.25rem; display: flex; align-items: center; justify-content: space-between;">
                            <h3 style="color: #FFFFFF; font-size: 1rem; font-weight: 700;">Tabel Spesifikasi Teknis</h3>
                            <span style="color: var(--gold-light); font-size: 0.775rem;">Export Standards</span>
                        </div>
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                            <tbody>
                                @foreach($product->specifications as $key => $val)
                                    <tr style="border-bottom: 1px solid var(--slate-border);">
                                        <td style="padding: 0.85rem 1.25rem; font-weight: 600; color: var(--navy-primary); width: 38%; background-color: #F8FAFC;">
                                            {{ $key }}
                                        </td>
                                        <td style="padding: 0.85rem 1.25rem; color: var(--slate-body);">
                                            {{ $val }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Full Summernote Rich Text Description -->
        @if(!empty($product->description))
            <div style="margin-top: 4rem; background: #FFFFFF; padding: 2.5rem; border-radius: 20px; border: 1px solid var(--slate-border); box-shadow: var(--shadow-sm);">
                <h2 style="font-size: 1.5rem; color: var(--navy-primary); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--gold-primary);">
                    Deskripsi Detail & Informasi Pemrosesan
                </h2>
                <div class="rich-content" style="line-height: 1.8; color: var(--slate-body); font-size: 1rem;">
                    {!! $product->description !!}
                </div>
            </div>
        @endif

        <!-- Related Commodities -->
        @if($relatedProducts->count() > 0)
            <div style="margin-top: 5rem;">
                <div class="section-header" style="text-align: left; margin-bottom: 2rem;">
                    <span class="section-subtitle">KOMODITAS LAINNYA</span>
                    <h2 class="section-title">Eksplorasi Produk Terkait</h2>
                </div>
                <div class="product-grid">
                    @foreach($relatedProducts as $rel)
                        <div class="product-card">
                            <div class="product-image-wrap">
                                <img src="{{ $rel->image_url }}" alt="{{ $rel->name }}" loading="lazy">
                                <span class="product-badge">{{ $rel->category }}</span>
                            </div>
                            <div class="product-body">
                                <h3 class="product-title">{{ $rel->name }}</h3>
                                <p class="product-desc">{{ Str::limit($rel->short_description, 90) }}</p>
                                <div style="display: flex; gap: 0.5rem; margin-top: auto;">
                                    <a href="{{ route('catalog.show', $rel->slug) }}" class="btn btn-outline-navy btn-sm" style="flex: 1; text-align: center; justify-content: center; padding: 0.45rem 0.5rem;">
                                        <span>Detail</span>
                                    </a>
                                    <button type="button" class="btn btn-gold btn-sm" onclick="requestQuoteModal('{{ addslashes($rel->name) }}', {{ $rel->id }})" style="flex: 1.5; justify-content: center; padding: 0.45rem 0.65rem;" title="Request a Quote (Harga, COA, Sampel & Ongkir)">
                                        <i class="fa-solid fa-file-invoice-dollar"></i>
                                        <span>Request Quote</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

@endsection
