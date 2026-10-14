@extends('layouts.app')

@section('title', 'Katalog Komoditas Ekspor Pertanian | ' . ($siteSettings['site_name'] ?? 'Islenesia'))
@section('meta_description', 'Jelajahi komoditas ekspor unggulan Indonesia: Biji Vanili Gourmet, Bubuk Kratom Organik, Kopi Spesialti Arabika/Robusta, dan Cengkeh Lalpari murni.')

@section('content')

<style>
    @keyframes shopeeShimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .shopee-shimmer {
        background: linear-gradient(90deg, #F1F5F9 20%, #E2E8F0 40%, #F8FAFC 60%, #F1F5F9 80%);
        background-size: 200% 100%;
        animation: shopeeShimmer 1.3s cubic-bezier(0.4, 0, 0.2, 1) infinite;
        border-radius: 6px;
    }

    .shopee-skeleton-card {
        background: #FFFFFF;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid var(--slate-border);
        box-shadow: var(--shadow-sm);
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }

    .shopee-skeleton-img-wrap {
        aspect-ratio: 4/3;
        width: 100%;
        position: relative;
        overflow: hidden;
    }

    .shopee-skeleton-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        width: 70px;
        height: 22px;
        border-radius: 9999px;
        z-index: 2;
    }

    .shopee-skeleton-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex: 1;
        gap: 0.75rem;
    }

    .shopee-skeleton-category {
        width: 30%;
        height: 12px;
        border-radius: 4px;
    }

    .shopee-skeleton-title-1 {
        width: 90%;
        height: 20px;
        border-radius: 6px;
    }

    .shopee-skeleton-title-2 {
        width: 60%;
        height: 16px;
        border-radius: 6px;
    }

    .shopee-skeleton-desc {
        width: 95%;
        height: 12px;
        border-radius: 4px;
        margin-top: 0.25rem;
    }

    .shopee-skeleton-specs {
        display: flex;
        gap: 0.5rem;
        margin: 0.5rem 0;
    }

    .shopee-skeleton-spec-chip {
        width: 45%;
        height: 24px;
        border-radius: 6px;
    }

    .shopee-skeleton-btn-row {
        display: flex;
        gap: 0.75rem;
        margin-top: auto;
        padding-top: 1rem;
    }

    .shopee-skeleton-btn-detail {
        flex: 1;
        height: 38px;
        border-radius: 8px;
    }

    .shopee-skeleton-btn-inquire {
        width: 90px;
        height: 38px;
        border-radius: 8px;
    }

    .shopee-card-fade {
        animation: shopeeCardFadeIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    @keyframes shopeeCardFadeIn {
        from {
            opacity: 0;
            transform: translateY(14px) scale(0.985);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
</style>

<!-- Header Banner -->
<div style="background: radial-gradient(circle at 70% 30%, #152E5E 0%, #0B1B3D 70%, #061124 100%); color: #FFFFFF; padding: 4.5rem 0 3.5rem; border-bottom: 2px solid rgba(212, 175, 55, 0.3);">
    <div class="container text-center" style="max-width: 800px; margin: 0 auto;">
        <span class="section-subtitle" style="color: var(--gold-light);">OFFICIAL EXPORT CATALOG</span>
        <h1 style="color: #FFFFFF; font-size: 2.75rem; margin-bottom: 1rem;">Katalog Komoditas Ekspor</h1>
        <p style="color: #CBD5E1; font-size: 1.05rem;">
            Pasokan komoditas pertanian nusantara berkualitas ekspor premium dengan pengujian mutu laboratorium dan jaminan volume kontainer ke Eropa & China.
        </p>
    </div>
</div>

<section class="section" style="background-color: #F8FAFC;">
    <div class="container">
        <!-- Search & Filter Controls -->
        <div style="background: #FFFFFF; padding: 1.5rem; border-radius: 16px; border: 1px solid var(--slate-border); box-shadow: var(--shadow-sm); margin-bottom: 2rem;">
            <div style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; justify-content: space-between;">
                <!-- Category Tabs -->
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;" id="categoryFilterContainer">
                    <button type="button" class="btn btn-sm btn-navy cat-filter-btn active" data-category="" onclick="setCatalogCategory('')" style="border-radius: 8px;">
                        Semua Kategori
                    </button>
                    @foreach($categories as $cat)
                        <button type="button" class="btn btn-sm btn-outline-navy cat-filter-btn" data-category="{{ $cat }}" onclick="setCatalogCategory('{{ addslashes($cat) }}')" style="border-radius: 8px;">
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>

                <!-- Live Search Input -->
                <div style="display: flex; gap: 0.5rem; min-width: 280px; flex: 1; max-width: 380px; position: relative;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94A3B8;"></i>
                    <input type="text" id="catalogSearchInput" placeholder="Ketik nama komoditas untuk pencarian..." oninput="handleCatalogSearch(this.value)" style="width: 100%; padding: 0.65rem 0.85rem 0.65rem 2.5rem; border: 1.5px solid var(--slate-border); border-radius: 8px; font-family: inherit; font-size: 0.875rem; outline: none; transition: border-color 0.2s;">
                </div>
            </div>
        </div>

        <!-- Catalog Status Bar -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; font-size: 0.875rem; color: var(--slate-muted);">
            <div>
                Menampilkan <strong id="catalogCountText" style="color: var(--navy-primary);">{{ count($products) }}</strong> komoditas ekspor siap kontrak
            </div>
            <div id="catalogLoadingIndicator" style="display: none; align-items: center; gap: 0.5rem; color: var(--gold-dark); font-weight: 600;">
                <i class="fa-solid fa-circle-notch fa-spin"></i>
                <span>Memuat data komoditas...</span>
            </div>
        </div>

        <!-- Products Grid Container -->
        <div class="product-grid" id="catalogGrid">
            @forelse($products as $index => $product)
                @php
                    $cleanName = $product->name;
                    $waDefaultText = "Halo Admin Agregator " . ($siteSettings['site_name'] ?? 'Islenesia') . ", saya ingin menanyakan penawaran harga dan stok ekspor untuk: " . $cleanName . ".";
                @endphp
                <div class="product-card shopee-card-fade" style="animation-delay: {{ $index * 0.05 }}s;">
                    <div class="product-image-wrap">
                        <img src="{{ $product->image_url }}" alt="{{ $cleanName }}" loading="lazy">
                        <span class="product-badge">{{ $product->category }}</span>
                    </div>
                    <div class="product-body">
                        <span class="product-category">{{ $product->category }}</span>
                        <h3 class="product-title">{{ $cleanName }}</h3>
                        <p class="product-desc">{{ $product->short_description }}</p>

                        @if(!empty($product->specifications) && is_array($product->specifications))
                            <div class="product-specs-list">
                                @php $specCount = 0; @endphp
                                @foreach($product->specifications as $k => $v)
                                    @if($specCount < 3)
                                        <span class="spec-chip"><strong>{{ $k }}:</strong> {{ $v }}</span>
                                        @php $specCount++; @endphp
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        <div style="display: flex; gap: 0.5rem; margin-top: auto;">
                            <a href="{{ route('catalog.show', $product->slug) }}" class="btn btn-outline-navy btn-sm" style="flex: 1; text-align: center; justify-content: center; padding: 0.45rem 0.5rem;">
                                <span>Detail</span>
                            </a>
                            <button type="button" class="btn btn-gold btn-sm" onclick="requestQuoteModal('{{ addslashes($cleanName) }}', {{ $product->id }})" style="flex: 1.5; justify-content: center; padding: 0.45rem 0.65rem;" title="Request a Quote Resmi (WhatsApp / Email)">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                <span>WhatsApp / Email</span>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem 1rem;">
                    <p style="color: var(--slate-muted);">Belum ada komoditas yang dipublikasikan saat ini.</p>
                </div>
            @endforelse
        </div>

        <!-- Empty State Container -->
        <div id="catalogEmptyState" style="display: none; text-align: center; padding: 4rem 1rem; background: #FFFFFF; border-radius: 16px; border: 1px solid var(--slate-border); margin-top: 1rem; box-shadow: var(--shadow-sm);">
            <i class="fa-solid fa-box-open" style="font-size: 3.5rem; color: #CBD5E1; margin-bottom: 1.25rem;"></i>
            <h3 style="color: var(--navy-primary); margin-bottom: 0.5rem; font-size: 1.35rem;">Tidak Ada Komoditas yang Ditemukan</h3>
            <p style="color: var(--slate-muted); margin-bottom: 1.5rem; max-width: 480px; margin-left: auto; margin-right: auto;">
                Kami tidak menemukan komoditas ekspor yang cocok dengan kata kunci atau filter yang Anda pilih. Coba gunakan kata kunci lain atau reset filter.
            </p>
            <button type="button" class="btn btn-navy btn-sm" onclick="resetCatalogFilter()">
                <i class="fa-solid fa-rotate-left"></i>
                <span>Reset Filter & Pencarian</span>
            </button>
        </div>
    </div>
</section>

@push('scripts')
<script>
    var activeCategory = '';
    var searchDebounceTimer = null;
    var currentAbortController = null;
    var catalogCache = {};

    var catalogGrid = document.getElementById('catalogGrid');
    var catalogEmptyState = document.getElementById('catalogEmptyState');
    var searchInput = document.getElementById('catalogSearchInput');
    var catalogCountText = document.getElementById('catalogCountText');
    var catalogLoadingIndicator = document.getElementById('catalogLoadingIndicator');

    function getShopeeSkeletonHtml(count) {
        if (!count) count = 4;
        var html = '';
        for (var i = 0; i < count; i++) {
            html += '<div class="shopee-skeleton-card">' +
                '<div class="shopee-skeleton-img-wrap shopee-shimmer">' +
                    '<div class="shopee-skeleton-badge shopee-shimmer" style="background: rgba(255,255,255,0.7);"></div>' +
                '</div>' +
                '<div class="shopee-skeleton-body">' +
                    '<div class="shopee-skeleton-category shopee-shimmer"></div>' +
                    '<div class="shopee-skeleton-title-1 shopee-shimmer"></div>' +
                    '<div class="shopee-skeleton-title-2 shopee-shimmer"></div>' +
                    '<div class="shopee-skeleton-desc shopee-shimmer"></div>' +
                    '<div class="shopee-skeleton-specs">' +
                        '<div class="shopee-skeleton-spec-chip shopee-shimmer"></div>' +
                        '<div class="shopee-skeleton-spec-chip shopee-shimmer"></div>' +
                    '</div>' +
                    '<div class="shopee-skeleton-btn-row">' +
                        '<div class="shopee-skeleton-btn-detail shopee-shimmer"></div>' +
                        '<div class="shopee-skeleton-btn-inquire shopee-shimmer"></div>' +
                    '</div>' +
                '</div>' +
            '</div>';
        }
        return html;
    }

    function showShopeeSkeletonLoader() {
        if (catalogEmptyState) catalogEmptyState.style.display = 'none';
        if (catalogLoadingIndicator) catalogLoadingIndicator.style.display = 'inline-flex';
        if (catalogGrid) catalogGrid.innerHTML = getShopeeSkeletonHtml(4);
    }

    window.setCatalogCategory = function(cat) {
        activeCategory = cat;

        var btns = document.querySelectorAll('.cat-filter-btn');
        btns.forEach(function(btn) {
            if (btn.getAttribute('data-category') === cat) {
                btn.className = 'btn btn-sm btn-navy cat-filter-btn active';
            } else {
                btn.className = 'btn btn-sm btn-outline-navy cat-filter-btn';
            }
        });

        window.fetchCatalogProducts();
    };

    window.handleCatalogSearch = function(query) {
        clearTimeout(searchDebounceTimer);
        searchDebounceTimer = setTimeout(function() {
            window.fetchCatalogProducts();
        }, 220);
    };

    window.resetCatalogFilter = function() {
        activeCategory = '';
        if (searchInput) searchInput.value = '';
        window.setCatalogCategory('');
    };

    window.fetchCatalogProducts = function() {
        var query = searchInput ? searchInput.value.trim() : '';
        var cacheKey = activeCategory + '__' + query;

        if (currentAbortController) {
            currentAbortController.abort();
        }

        if (catalogCache[cacheKey]) {
            renderCatalogResult(catalogCache[cacheKey]);
            return;
        }

        showShopeeSkeletonLoader();

        currentAbortController = new AbortController();
        var params = new URLSearchParams();
        if (activeCategory) params.append('category', activeCategory);
        if (query) params.append('q', query);

        var startTime = Date.now();

        fetch("{{ route('catalog.index') }}?" + params.toString(), {
            signal: currentAbortController.signal,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            var elapsed = Date.now() - startTime;
            var delay = elapsed < 220 ? (220 - elapsed) : 0;

            setTimeout(function() {
                catalogCache[cacheKey] = data;
                renderCatalogResult(data);
            }, delay);
        })
        .catch(function(err) {
            if (err.name !== 'AbortError') {
                console.error('Fetch catalog error:', err);
                if (catalogLoadingIndicator) catalogLoadingIndicator.style.display = 'none';
            }
        });
    };

    function renderCatalogResult(data) {
        if (catalogLoadingIndicator) catalogLoadingIndicator.style.display = 'none';

        if (data.products && data.products.length > 0) {
            if (catalogEmptyState) catalogEmptyState.style.display = 'none';
            if (catalogCountText) catalogCountText.textContent = data.products.length;
            renderCatalogCards(data.products);
        } else {
            if (catalogCountText) catalogCountText.textContent = '0';
            if (catalogGrid) catalogGrid.innerHTML = '';
            if (catalogEmptyState) catalogEmptyState.style.display = 'block';
        }
    }

    function renderCatalogCards(products) {
        var cardsHtml = '';
        var siteName = window.SITE_NAME || 'Islenesia';

        products.forEach(function(p, index) {
            var specsHtml = '';
            if (p.specifications && typeof p.specifications === 'object') {
                var specCount = 0;
                for (var key in p.specifications) {
                    if (Object.prototype.hasOwnProperty.call(p.specifications, key)) {
                        if (specCount < 3) {
                            specsHtml += '<span class="spec-chip"><strong>' + escapeHtml(key) + ':</strong> ' + escapeHtml(p.specifications[key]) + '</span>';
                            specCount++;
                        }
                    }
                }
            }

            var cleanName = escapeHtml(p.name);
            var waDefaultText = "Halo Admin Agregator " + siteName + ", saya ingin menanyakan penawaran harga dan stok ekspor untuk: " + cleanName + ".";

            cardsHtml += '<div class="product-card shopee-card-fade" style="animation-delay: ' + (index * 0.05) + 's;">' +
                '<div class="product-image-wrap">' +
                    '<img src="' + p.image_url + '" alt="' + cleanName + '" loading="lazy">' +
                    '<span class="product-badge">' + escapeHtml(p.category) + '</span>' +
                '</div>' +
                '<div class="product-body">' +
                    '<span class="product-category">' + escapeHtml(p.category) + '</span>' +
                    '<h3 class="product-title">' + cleanName + '</h3>' +
                    '<p class="product-desc">' + escapeHtml(p.short_description || '') + '</p>' +
                    (specsHtml ? '<div class="product-specs-list">' + specsHtml + '</div>' : '') +
                    '<div style="display: flex; gap: 0.5rem; margin-top: auto;">' +
                        '<a href="' + p.show_url + '" class="btn btn-outline-navy btn-sm" style="flex: 1; text-align: center; justify-content: center; padding: 0.45rem 0.5rem;">' +
                            '<span>Detail</span>' +
                        '</a>' +
                        '<button type="button" class="btn btn-gold btn-sm" onclick="requestQuoteModal(\'' + escapeJs(cleanName) + '\', ' + p.id + ')" style="flex: 1.5; justify-content: center; padding: 0.45rem 0.65rem;" title="Request a Quote Resmi (WhatsApp / Email)">' +
                            '<i class="fa-solid fa-file-invoice-dollar"></i>' +
                            '<span>WhatsApp / Email</span>' +
                        '</button>' +
                    '</div>' +
                '</div>' +
            '</div>';
        });

        if (catalogGrid) catalogGrid.innerHTML = cardsHtml;
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function escapeJs(str) {
        if (!str) return '';
        return String(str).replace(/'/g, "\\'").replace(/"/g, '\\"');
    }
</script>
@endpush

@endsection
