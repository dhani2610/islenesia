@extends('layouts.admin')

@section('title', 'Edit Artikel Blog')
@section('header_title', 'Edit Artikel: ' . Str::limit($post->title, 35))

@section('content')

<div class="admin-card">
    <div class="card-header-flex">
        <h3>Edit Data Artikel</h3>
        <a href="{{ route('admin.posts.index') }}" class="btn-admin btn-admin-navy" style="font-size: 0.8125rem;">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            <!-- Left Column -->
            <div>
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Judul Artikel *</label>
                    <input type="text" name="title" required value="{{ old('title', $post->title) }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>

                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Kutipan Singkat (Excerpt)</label>
                    <textarea name="excerpt" rows="2" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">{{ old('excerpt', $post->excerpt) }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 1.75rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Konten Artikel Lengkap (Summernote Editor) *</label>
                    <textarea id="summernote" name="content">{{ old('content', $post->content) }}</textarea>
                </div>

                <!-- SEO Meta Configuration Box -->
                <div style="background: #F8FAFC; border: 1px solid var(--admin-border); border-radius: 12px; padding: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                        <i class="fa-solid fa-magnifying-glass-chart text-gold" style="font-size: 1.2rem;"></i>
                        <h4 style="font-size: 0.95rem; color: var(--admin-navy-surface); font-weight: 700;">Optimasi SEO Google (Search Engine)</h4>
                    </div>

                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--admin-navy-surface); margin-bottom: 0.35rem;">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}" style="width: 100%; padding: 0.55rem; border: 1.5px solid var(--admin-border); border-radius: 6px; font-size: 0.85rem;">
                    </div>

                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--admin-navy-surface); margin-bottom: 0.35rem;">Meta Description</label>
                        <textarea name="meta_description" rows="2" style="width: 100%; padding: 0.55rem; border: 1.5px solid var(--admin-border); border-radius: 6px; font-size: 0.85rem;">{{ old('meta_description', $post->meta_description) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--admin-navy-surface); margin-bottom: 0.35rem;">Meta Keywords (Kata Kunci)</label>
                        <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $post->meta_keywords) }}" style="width: 100%; padding: 0.55rem; border: 1.5px solid var(--admin-border); border-radius: 6px; font-size: 0.85rem;">
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <!-- Category Select (With Select2) -->
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Kategori Artikel *</label>
                    <select name="category" required class="select2" style="width: 100%;">
                        <option value="Export Insights" {{ $post->category === 'Export Insights' ? 'selected' : '' }}>Export Insights (Wawasan Ekspor)</option>
                        <option value="Global Trade" {{ $post->category === 'Global Trade' ? 'selected' : '' }}>Global Trade (Perdagangan Global)</option>
                        <option value="Quality Control" {{ $post->category === 'Quality Control' ? 'selected' : '' }}>Quality Control (Pengujian Laboratorium)</option>
                        <option value="Farmer Story" {{ $post->category === 'Farmer Story' ? 'selected' : '' }}>Farmer Story (Kisah Petani Mitra)</option>
                        <option value="Industry News" {{ $post->category === 'Industry News' ? 'selected' : '' }}>Industry News (Berita Industri)</option>
                    </select>
                </div>

                <!-- Cover Image -->
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Foto Sampul Artikel</label>
                    <div style="margin-bottom: 0.75rem; border-radius: 8px; overflow: hidden; border: 1px solid var(--admin-border); max-width: 200px;">
                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}" style="width: 100%; height: auto; display: block;">
                    </div>
                    <input type="file" name="image" accept="image/*" class="form-input" style="width: 100%; padding: 0.5rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                    <span style="font-size: 0.725rem; color: var(--admin-muted);">Kosongkan jika tidak ingin mengganti cover</span>
                </div>

                <!-- Options -->
                <div style="background: #F8FAFC; border: 1px solid var(--admin-border); border-radius: 10px; padding: 1.25rem; margin-bottom: 1.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                        <input type="checkbox" name="is_published" value="1" {{ $post->is_published ? 'checked' : '' }}>
                        <span>Status Publikasi (Aktif di Website)</span>
                    </label>
                </div>

                <button type="submit" class="btn-admin btn-admin-gold" style="width: 100%; padding: 0.85rem; font-size: 0.95rem; justify-content: center;">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Perbarui Artikel</span>
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    });
</script>
@endpush

@endsection
