@extends('layouts.app')

@section('title', 'Wawasan & Berita Pasar Ekspor | ' . ($siteSettings['site_name'] ?? 'Manunggaland'))
@section('meta_description', 'Artikel, regulasi ekspor, dan panduan pasar komoditas pertanian Indonesia ke Uni Eropa, China, dan pasar global.')

@section('content')

<!-- Header Banner -->
<div style="background: radial-gradient(circle at 70% 30%, #152E5E 0%, #0B1B3D 70%, #061124 100%); color: #FFFFFF; padding: 4.5rem 0 3.5rem; border-bottom: 2px solid rgba(212, 175, 55, 0.3);">
    <div class="container text-center" style="max-width: 800px; margin: 0 auto;">
        <span class="section-subtitle" style="color: var(--gold-light);">EXPORT KNOWLEDGE & INSIGHTS</span>
        <h1 style="color: #FFFFFF; font-size: 2.75rem; margin-bottom: 1rem;">Blog & Wawasan Ekspor Global</h1>
        <p style="color: #CBD5E1; font-size: 1.05rem;">
            Eksplorasi regulasi standar mutu karantina, analisis pasar komoditas China & Eropa, serta cerita petani mitra nusantara.
        </p>
    </div>
</div>

<section class="section" style="background-color: #F8FAFC;">
    <div class="container">
        <!-- Filter and Search -->
        <div style="background: #FFFFFF; padding: 1.5rem; border-radius: 16px; border: 1px solid var(--slate-border); box-shadow: var(--shadow-sm); margin-bottom: 3rem;">
            <form action="{{ route('blog.index') }}" method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; justify-content: space-between;">
                <!-- Category Tabs -->
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="{{ route('blog.index') }}" class="btn btn-sm {{ !request('category') ? 'btn-navy' : 'btn-outline-navy' }}" style="border-radius: 8px;">
                        Semua Kategori
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('blog.index', ['category' => $cat]) }}" class="btn btn-sm {{ request('category') === $cat ? 'btn-navy' : 'btn-outline-navy' }}" style="border-radius: 8px;">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>

                <!-- Search Input -->
                <div style="display: flex; gap: 0.5rem; min-width: 280px; flex: 1; max-width: 380px;">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul artikel..." style="flex: 1; padding: 0.5rem 0.85rem; border: 1.5px solid var(--slate-border); border-radius: 8px; font-family: inherit; font-size: 0.875rem;">
                    <button type="submit" class="btn btn-gold btn-sm" style="border-radius: 8px;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Cari</span>
                    </button>
                </div>
            </form>
        </div>

        @if($posts->count() > 0)
            <div class="blog-grid">
                @foreach($posts as $post)
                    <div class="blog-card">
                        <div class="blog-image-wrap">
                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" loading="lazy">
                        </div>
                        <div class="blog-body">
                            <div class="blog-meta">
                                <span><i class="fa-regular fa-calendar"></i> {{ $post->published_at ? $post->published_at->format('d M Y') : date('d M Y') }}</span>
                                <span><i class="fa-regular fa-folder"></i> {{ $post->category }}</span>
                                <span><i class="fa-regular fa-eye"></i> {{ $post->views_count }}</span>
                            </div>
                            <h3 class="blog-title">
                                <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            <p class="blog-excerpt">{{ $post->excerpt }}</p>
                            <a href="{{ route('blog.show', $post->slug) }}" style="color: var(--navy-primary); font-weight: 700; font-size: 0.875rem; display: flex; align-items: center; gap: 0.35rem; margin-top: auto;">
                                Baca Selengkapnya &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 3.5rem;">
                {{ $posts->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 4rem 1rem; background: #FFFFFF; border-radius: 16px; border: 1px solid var(--slate-border);">
                <i class="fa-solid fa-newspaper" style="font-size: 3rem; color: #CBD5E1; margin-bottom: 1rem;"></i>
                <h3 style="color: var(--navy-primary); margin-bottom: 0.5rem;">Belum Ada Artikel yang Ditemukan</h3>
                <p style="color: var(--slate-muted); margin-bottom: 1.5rem;">Silakan coba dengan kata kunci pencarian yang lain.</p>
                <a href="{{ route('blog.index') }}" class="btn btn-navy btn-sm">Lihat Semua Artikel</a>
            </div>
        @endif
    </div>
</section>

@endsection
