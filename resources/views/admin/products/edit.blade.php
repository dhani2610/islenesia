@extends('layouts.admin')

@section('title', 'Edit Produk Komoditas')
@section('header_title', 'Edit Komoditas: ' . $product->name)

@section('content')

<div class="admin-card">
    <div class="card-header-flex">
        <h3>Edit Data Komoditas Ekspor</h3>
        <a href="{{ route('admin.products.index') }}" class="btn-admin btn-admin-navy" style="font-size: 0.8125rem;">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            <!-- Left Column -->
            <div>
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Nama Komoditas *</label>
                    <input type="text" name="name" required value="{{ old('name', $product->name) }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>

                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Deskripsi Singkat (Ringkasan Cuplikan)</label>
                    <textarea name="short_description" rows="3" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">{{ old('short_description', $product->short_description) }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 1.75rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Deskripsi Lengkap (Summernote Editor)</label>
                    <textarea id="summernote" name="description">{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- Specifications Builder -->
                <div style="background: #F8FAFC; border: 1px solid var(--admin-border); border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <div>
                            <h4 style="font-size: 0.95rem; color: var(--admin-navy-surface); font-weight: 700;">Tabel Spesifikasi Teknis Ekspor</h4>
                            <p style="font-size: 0.75rem; color: var(--admin-muted);">Ubah atau tambah parameter spesifikasi komoditas.</p>
                        </div>
                        <button type="button" class="btn-admin btn-admin-gold" onclick="addSpecRow()" style="font-size: 0.75rem; padding: 0.35rem 0.75rem;">
                            <i class="fa-solid fa-plus"></i> Tambah Baris
                        </button>
                    </div>

                    <div id="specsContainer">
                        @if(!empty($product->specifications) && is_array($product->specifications))
                            @foreach($product->specifications as $key => $val)
                                <div class="spec-row" style="display: flex; gap: 0.75rem; margin-bottom: 0.5rem;">
                                    <input type="text" name="spec_keys[]" value="{{ $key }}" placeholder="Nama Parameter" style="flex: 1; padding: 0.5rem; border: 1.5px solid var(--admin-border); border-radius: 6px; font-size: 0.8125rem;">
                                    <input type="text" name="spec_values[]" value="{{ $val }}" placeholder="Nilai" style="flex: 1.5; padding: 0.5rem; border: 1.5px solid var(--admin-border); border-radius: 6px; font-size: 0.8125rem;">
                                    <button type="button" class="table-btn-del" onclick="$(this).parent().remove()" style="padding: 0.5rem 0.75rem;"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <!-- Category Select (With Select2) -->
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                        <label style="font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin: 0;">Kategori Komoditas *</label>
                        <a href="{{ route('admin.categories.index') }}" target="_blank" style="font-size: 0.75rem; color: var(--admin-gold); text-decoration: none; font-weight: 600;">+ Kelola Kategori</a>
                    </div>
                    <select name="category" required class="select2" style="width: 100%;">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}" {{ old('category', $product->category) === $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Current & New Image -->
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Foto Cover Produk</label>
                    <div style="margin-bottom: 0.75rem; border-radius: 8px; overflow: hidden; border: 1px solid var(--admin-border); max-width: 200px;">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 100%; height: auto; display: block;">
                    </div>
                    <input type="file" name="image" accept="image/*" class="form-input" style="width: 100%; padding: 0.5rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                    <span style="font-size: 0.725rem; color: var(--admin-muted);">Kosongkan jika tidak ingin mengganti foto</span>
                </div>

                <!-- Sort Order -->
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Nomor Urutan Tampilan</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $product->sort_order) }}" class="form-input" style="width: 100%; padding: 0.6rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>

                <!-- Options -->
                <div style="background: #F8FAFC; border: 1px solid var(--admin-border); border-radius: 10px; padding: 1.25rem; margin-bottom: 1.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; font-weight: 600; cursor: pointer; margin-bottom: 0.75rem;">
                        <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
                        <span>Status Aktif (Tampil di Katalog)</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                        <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }}>
                        <span>Jadikan Produk Unggulan Beranda</span>
                    </label>
                </div>

                <button type="submit" class="btn-admin btn-admin-gold" style="width: 100%; padding: 0.85rem; font-size: 0.95rem; justify-content: center;">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Perbarui Komoditas</span>
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
            height: 250,
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

    function addSpecRow() {
        const row = `
            <div class="spec-row" style="display: flex; gap: 0.75rem; margin-bottom: 0.5rem;">
                <input type="text" name="spec_keys[]" placeholder="Nama Parameter" style="flex: 1; padding: 0.5rem; border: 1.5px solid var(--admin-border); border-radius: 6px; font-size: 0.8125rem;">
                <input type="text" name="spec_values[]" placeholder="Nilai" style="flex: 1.5; padding: 0.5rem; border: 1.5px solid var(--admin-border); border-radius: 6px; font-size: 0.8125rem;">
                <button type="button" class="table-btn-del" onclick="$(this).parent().remove()" style="padding: 0.5rem 0.75rem;"><i class="fa-solid fa-trash"></i></button>
            </div>
        `;
        $('#specsContainer').append(row);
    }
</script>
@endpush

@endsection
