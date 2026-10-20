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
                        <span>Request a Quote (WhatsApp / Email)</span>
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

        <!-- Dynamic Product Gallery & QC Documentation (Loaded via JS) -->
        <div id="productGallerySection" style="margin-top: 4.5rem; display: none;">
            <div class="section-header" style="text-align: left; margin-bottom: 2rem;">
                <span class="section-subtitle">DOKUMENTASI MUTU & QC EKSPOR</span>
                <h2 class="section-title">Galeri Foto Komoditas & Proses Standar Mutu</h2>
                <p style="font-size: 0.95rem; color: var(--slate-muted); max-width: 700px; margin-top: 0.5rem; line-height: 1.6;">
                    Dokumentasi visual proses pemilahan bahan baku, uji laboratorium, dan pengemasan standar ekspor. Klik pada foto untuk melihat detail resolusi tinggi dan keterangan teknis.
                </p>
            </div>

            <!-- Skeleton Loading State -->
            <div id="productGallerySkeleton" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.5rem;">
                @for($s = 1; $s <= 4; $s++)
                    <div style="background: #FFFFFF; border: 1px solid var(--slate-border); border-radius: 16px; overflow: hidden; box-shadow: var(--shadow-sm); animation: pulse 1.5s infinite;">
                        <div style="aspect-ratio: 4/3; background: #E2E8F0;"></div>
                        <div style="padding: 1.25rem;">
                            <div style="height: 18px; background: #E2E8F0; border-radius: 4px; width: 70%; margin-bottom: 0.5rem;"></div>
                            <div style="height: 14px; background: #F1F5F9; border-radius: 4px; width: 95%;"></div>
                        </div>
                    </div>
                @endfor
            </div>

            <!-- Rendered Gallery Grid -->
            <div id="productGalleryGrid" style="display: none; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.5rem;">
                <!-- Dynamically populated by JavaScript -->
            </div>
        </div>

        <!-- Lightbox Modal for Large Image View -->
        <div id="productLightboxModal" style="position: fixed; inset: 0; z-index: 999999; background: rgba(11, 27, 61, 0.92); backdrop-filter: blur(10px); display: none; align-items: center; justify-content: center; padding: 1.5rem; opacity: 0; transition: opacity 0.3s ease;">
            <div id="productLightboxDialog" style="position: relative; max-width: 900px; width: 100%; max-height: 92vh; background: #0B1B3D; border: 1.5px solid rgba(212, 175, 55, 0.4); border-radius: 18px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7); overflow: hidden; display: flex; flex-direction: column; transform: scale(0.95); transition: transform 0.3s ease;">
                
                <!-- Close Button -->
                <button type="button" onclick="closeProductLightbox()" style="position: absolute; top: 1rem; right: 1rem; z-index: 10; width: 38px; height: 38px; border-radius: 50%; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.2); color: #FFFFFF; font-size: 1.1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='var(--gold-primary)'; this.style.color='var(--navy-deep)';" onmouseout="this.style.background='rgba(0,0,0,0.5)'; this.style.color='#FFFFFF';">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <!-- Navigation Previous -->
                <button type="button" id="lightboxPrevBtn" onclick="navigateLightbox(-1)" style="position: absolute; left: 1rem; top: 40%; transform: translateY(-50%); z-index: 10; width: 44px; height: 44px; border-radius: 50%; background: rgba(0,0,0,0.55); border: 1px solid rgba(255,255,255,0.25); color: #FFFFFF; font-size: 1.25rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='var(--gold-primary)'; this.style.color='var(--navy-deep)';" onmouseout="this.style.background='rgba(0,0,0,0.55)'; this.style.color='#FFFFFF';">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>

                <!-- Navigation Next -->
                <button type="button" id="lightboxNextBtn" onclick="navigateLightbox(1)" style="position: absolute; right: 1rem; top: 40%; transform: translateY(-50%); z-index: 10; width: 44px; height: 44px; border-radius: 50%; background: rgba(0,0,0,0.55); border: 1px solid rgba(255,255,255,0.25); color: #FFFFFF; font-size: 1.25rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='var(--gold-primary)'; this.style.color='var(--navy-deep)';" onmouseout="this.style.background='rgba(0,0,0,0.55)'; this.style.color='#FFFFFF';">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>

                <!-- Image Viewport -->
                <div style="flex: 1; min-height: 280px; max-height: 60vh; background: #071228; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                    <img id="lightboxMainImg" src="" alt="Detail Foto" style="max-width: 100%; max-height: 60vh; object-fit: contain; display: block; transition: opacity 0.2s ease;">
                    <div id="lightboxImgSpinner" style="position: absolute; display: none; color: var(--gold-primary); font-size: 2rem;">
                        <i class="fa-solid fa-spinner fa-spin"></i>
                    </div>
                </div>

                <!-- Bottom Information Panel -->
                <div style="background: #0B1B3D; border-top: 1.5px solid rgba(212, 175, 55, 0.25); padding: 1.5rem 1.75rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; flex-wrap: wrap; gap: 0.5rem;">
                        <span style="font-size: 0.775rem; font-weight: 700; color: var(--gold-primary); text-transform: uppercase; letter-spacing: 0.08em; display: flex; align-items: center; gap: 0.4rem;">
                            <i class="fa-solid fa-certificate"></i>
                            <span>Dokumentasi Ekspor Resmi &bull; {{ $product->name }}</span>
                        </span>
                        <span id="lightboxCounter" style="background: rgba(255,255,255,0.1); color: #E2E8F0; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                            1 / 1
                        </span>
                    </div>
                    <h3 id="lightboxTitle" style="font-size: 1.25rem; font-weight: 700; color: #FFFFFF; margin: 0 0 0.5rem 0; line-height: 1.35;">
                        Judul Foto
                    </h3>
                    <p id="lightboxCaption" style="font-size: 0.9rem; color: #CBD5E1; margin: 0; line-height: 1.6;">
                        Deskripsi informasi foto dokumentasi.
                    </p>
                </div>
            </div>
        </div>

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
                                    <button type="button" class="btn btn-gold btn-sm" onclick="requestQuoteModal('{{ addslashes($rel->name) }}', {{ $rel->id }})" style="flex: 1.5; justify-content: center; padding: 0.45rem 0.65rem;" title="Request a Quote Resmi (WhatsApp / Email)">
                                        <i class="fa-solid fa-file-invoice-dollar"></i>
                                        <span>WhatsApp / Email</span>
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

@push('scripts')
<script>
    /* Global gallery state for current product */
    window.productGalleryData = [];
    window.currentLightboxIndex = 0;

    /* Dynamic Fetch of Product Gallery via AJAX (Optimized for performance) */
    document.addEventListener('DOMContentLoaded', function() {
        var galleryUrl = "{{ route('catalog.gallery', $product->slug) }}";
        var section = document.getElementById('productGallerySection');
        var skeleton = document.getElementById('productGallerySkeleton');
        var grid = document.getElementById('productGalleryGrid');

        if (!section || !galleryUrl) return;

        /* Show section container */
        section.style.display = 'block';

        fetch(galleryUrl, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(function(res) {
            if (!res.ok) throw new Error('Gagal memuat galeri foto');
            return res.json();
        })
        .then(function(data) {
            if (!data.success || !data.items || data.items.length === 0) {
                /* If product has no gallery photos, smoothly hide the section */
                section.style.display = 'none';
                return;
            }

            window.productGalleryData = data.items;
            renderGalleryCards(data.items);

            /* Hide skeleton and show rendered grid */
            if (skeleton) skeleton.style.display = 'none';
            if (grid) grid.style.display = 'grid';
        })
        .catch(function(err) {
            console.error('Gallery Fetch Error:', err);
            if (section) section.style.display = 'none';
        });
    });

    /* Render HTML cards for each gallery photo */
    function renderGalleryCards(items) {
        var grid = document.getElementById('productGalleryGrid');
        if (!grid) return;

        var html = '';
        items.forEach(function(item, idx) {
            var title = item.title || ('Foto #' + (idx + 1));
            var caption = item.caption || '';
            var imgUrl = item.image_url;

            html += `
                <div class="product-gallery-card" onclick="openProductLightbox(${idx})" style="background: #FFFFFF; border: 1px solid var(--slate-border); border-radius: 16px; overflow: hidden; box-shadow: var(--shadow-sm); cursor: pointer; transition: all 0.3s ease; display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='var(--shadow-md)'; this.style.borderColor='var(--gold-primary)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'; this.style.borderColor='var(--slate-border)';">
                    <div style="aspect-ratio: 4/3; overflow: hidden; position: relative; background: #0B1B3D;">
                        <img src="${imgUrl}" alt="${title.replace(/"/g, '&quot;')}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.06)';" onmouseout="this.style.transform='scale(1)';" onerror="this.src='{{ asset('images/products/default-product.jpg') }}'">
                        <span style="position: absolute; top: 0.75rem; left: 0.75rem; background: rgba(11, 27, 61, 0.75); backdrop-filter: blur(4px); color: #FFFFFF; font-size: 0.725rem; font-weight: 700; padding: 4px 10px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.2);">
                            <i class="fa-regular fa-image text-gold"></i> Foto #${idx + 1}
                        </span>
                        <div style="position: absolute; inset: 0; background: rgba(11, 27, 61, 0.35); opacity: 0; transition: opacity 0.3s ease; display: flex; align-items: center; justify-content: center;" onmouseover="this.style.opacity='1';" onmouseout="this.style.opacity='0';">
                            <span style="background: var(--gold-primary); color: var(--navy-deep); font-size: 0.8rem; font-weight: 700; padding: 0.5rem 1rem; border-radius: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.3); display: flex; align-items: center; gap: 0.4rem;">
                                <i class="fa-solid fa-magnifying-glass-plus"></i> Lihat Foto Penuh
                            </span>
                        </div>
                    </div>
                    <div style="padding: 1.25rem; display: flex; flex-direction: column; flex: 1;">
                        <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--navy-primary); margin: 0 0 0.45rem 0; line-height: 1.4;">
                            ${title}
                        </h4>
                        ${caption ? `<p style="font-size: 0.825rem; color: var(--slate-muted); margin: 0; line-height: 1.55; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">${caption}</p>` : ''}
                    </div>
                </div>
            `;
        });

        grid.innerHTML = html;
    }

    /* Open Lightbox Modal with specific index */
    window.openProductLightbox = function(index) {
        if (!window.productGalleryData || window.productGalleryData.length === 0) return;
        if (index < 0 || index >= window.productGalleryData.length) index = 0;

        window.currentLightboxIndex = index;
        updateLightboxContent();

        var modal = document.getElementById('productLightboxModal');
        var dialog = document.getElementById('productLightboxDialog');
        if (modal && dialog) {
            modal.style.display = 'flex';
            setTimeout(function() {
                modal.style.opacity = '1';
                dialog.style.transform = 'scale(1)';
            }, 10);
            document.body.style.overflow = 'hidden';
        }
    };

    /* Update Lightbox Content for current item */
    function updateLightboxContent() {
        var items = window.productGalleryData;
        var idx = window.currentLightboxIndex;
        if (!items || !items[idx]) return;

        var item = items[idx];
        var imgEl = document.getElementById('lightboxMainImg');
        var titleEl = document.getElementById('lightboxTitle');
        var captionEl = document.getElementById('lightboxCaption');
        var counterEl = document.getElementById('lightboxCounter');
        var prevBtn = document.getElementById('lightboxPrevBtn');
        var nextBtn = document.getElementById('lightboxNextBtn');

        if (imgEl) {
            imgEl.style.opacity = '0.3';
            imgEl.src = item.image_url;
            imgEl.onload = function() {
                imgEl.style.opacity = '1';
            };
        }

        if (titleEl) titleEl.textContent = item.title || ('Foto #' + (idx + 1));
        if (captionEl) captionEl.textContent = item.caption || 'Dokumentasi mutu dan spesifikasi ekspor Islenesia.';
        if (counterEl) counterEl.textContent = 'Foto ' + (idx + 1) + ' dari ' + items.length;

        /* Handle single-photo navigation visibility */
        if (prevBtn) prevBtn.style.display = (items.length > 1) ? 'flex' : 'none';
        if (nextBtn) nextBtn.style.display = (items.length > 1) ? 'flex' : 'none';
    }

    /* Navigate to next or previous photo */
    window.navigateLightbox = function(direction) {
        var items = window.productGalleryData;
        if (!items || items.length <= 1) return;

        window.currentLightboxIndex = (window.currentLightboxIndex + direction + items.length) % items.length;
        updateLightboxContent();
    };

    /* Close Lightbox Modal */
    window.closeProductLightbox = function(e) {
        var modal = document.getElementById('productLightboxModal');
        var dialog = document.getElementById('productLightboxDialog');
        if (!modal) return;

        /* If click happened on backdrop or close button */
        if (!e || e.target === modal || (e.target && e.target.closest('button[onclick="closeProductLightbox()"]'))) {
            modal.style.opacity = '0';
            if (dialog) dialog.style.transform = 'scale(0.95)';
            setTimeout(function() {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }, 300);
        }
    };

    /* Close on Backdrop Click */
    document.addEventListener('click', function(e) {
        var modal = document.getElementById('productLightboxModal');
        if (modal && e.target === modal) {
            window.closeProductLightbox(e);
        }
    });

    /* Keyboard navigation: ESC, Left, Right */
    document.addEventListener('keydown', function(e) {
        var modal = document.getElementById('productLightboxModal');
        if (!modal || modal.style.display === 'none') return;

        if (e.key === 'Escape') {
            window.closeProductLightbox();
        } else if (e.key === 'ArrowLeft') {
            window.navigateLightbox(-1);
        } else if (e.key === 'ArrowRight') {
            window.navigateLightbox(1);
        }
    });
</script>
@endpush

@endsection
