@extends('layouts.admin')

@section('title', 'Tambah Produk Komoditas Baru')
@section('header_title', 'Tambah Komoditas Ekspor')

@section('content')

<div class="admin-card">
    <div class="card-header-flex">
        <h3>Formulir Produk Komoditas Baru</h3>
        <a href="{{ route('admin.products.index') }}" class="btn-admin btn-admin-navy" style="font-size: 0.8125rem;">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            <!-- Left Column: Details & Description -->
            <div>
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Nama Komoditas *</label>
                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="Contoh: Indonesian Gourmet Vanilla Beans (Planifolia & Tahitensis)" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>

                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Deskripsi Singkat (Ringkasan Cuplikan)</label>
                    <textarea name="short_description" rows="3" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;" placeholder="Cuplikan singkat spesifikasi untuk kartu preview...">{{ old('short_description') }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 1.75rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Deskripsi Lengkap (Summernote Editor)</label>
                    <textarea id="summernote" name="description">{{ old('description') }}</textarea>
                </div>

                <!-- Dynamic Specifications Key-Value Builder -->
                <div style="background: #F8FAFC; border: 1px solid var(--admin-border); border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <div>
                            <h4 style="font-size: 0.95rem; color: var(--admin-navy-surface); font-weight: 700;">Tabel Spesifikasi Teknis Ekspor</h4>
                            <p style="font-size: 0.75rem; color: var(--admin-muted);">Masukkan parameter seperti Varietas, Kadar Air, Grade, Kemasan, MOQ, dan Pelabuhan.</p>
                        </div>
                        <button type="button" class="btn-admin btn-admin-gold" onclick="addSpecRow()" style="font-size: 0.75rem; padding: 0.35rem 0.75rem;">
                            <i class="fa-solid fa-plus"></i> Tambah Baris
                        </button>
                    </div>

                    <div id="specsContainer">
                        <div class="spec-row" style="display: flex; gap: 0.75rem; margin-bottom: 0.5rem;">
                            <input type="text" name="spec_keys[]" placeholder="Nama Parameter (misal: Grade)" value="Grade" style="flex: 1; padding: 0.5rem; border: 1.5px solid var(--admin-border); border-radius: 6px; font-size: 0.8125rem;">
                            <input type="text" name="spec_values[]" placeholder="Nilai (misal: Grade A Gourmet)" value="Grade A Gourmet / Prime Export" style="flex: 1.5; padding: 0.5rem; border: 1.5px solid var(--admin-border); border-radius: 6px; font-size: 0.8125rem;">
                            <button type="button" class="table-btn-del" onclick="$(this).parent().remove()" style="padding: 0.5rem 0.75rem;"><i class="fa-solid fa-trash"></i></button>
                        </div>
                        <div class="spec-row" style="display: flex; gap: 0.75rem; margin-bottom: 0.5rem;">
                            <input type="text" name="spec_keys[]" placeholder="Nama Parameter" value="Moisture Content" style="flex: 1; padding: 0.5rem; border: 1.5px solid var(--admin-border); border-radius: 6px; font-size: 0.8125rem;">
                            <input type="text" name="spec_values[]" placeholder="Nilai" value="25% - 30%" style="flex: 1.5; padding: 0.5rem; border: 1.5px solid var(--admin-border); border-radius: 6px; font-size: 0.8125rem;">
                            <button type="button" class="table-btn-del" onclick="$(this).parent().remove()" style="padding: 0.5rem 0.75rem;"><i class="fa-solid fa-trash"></i></button>
                        </div>
                        <div class="spec-row" style="display: flex; gap: 0.75rem; margin-bottom: 0.5rem;">
                            <input type="text" name="spec_keys[]" placeholder="Nama Parameter" value="Packaging" style="flex: 1; padding: 0.5rem; border: 1.5px solid var(--admin-border); border-radius: 6px; font-size: 0.8125rem;">
                            <input type="text" name="spec_values[]" placeholder="Nilai" value="Vacuum Sealed in Master Carton" style="flex: 1.5; padding: 0.5rem; border: 1.5px solid var(--admin-border); border-radius: 6px; font-size: 0.8125rem;">
                            <button type="button" class="table-btn-del" onclick="$(this).parent().remove()" style="padding: 0.5rem 0.75rem;"><i class="fa-solid fa-trash"></i></button>
                        </div>
                        <div class="spec-row" style="display: flex; gap: 0.75rem; margin-bottom: 0.5rem;">
                            <input type="text" name="spec_keys[]" placeholder="Nama Parameter" value="Kadar Air / Moisture" style="flex: 1; padding: 0.5rem; border: 1.5px solid var(--admin-border); border-radius: 6px; font-size: 0.8125rem;">
                            <input type="text" name="spec_values[]" placeholder="Nilai" value="Max 12% - 14%" style="flex: 1.5; padding: 0.5rem; border: 1.5px solid var(--admin-border); border-radius: 6px; font-size: 0.8125rem;">
                            <button type="button" class="table-btn-del" onclick="$(this).parent().remove()" style="padding: 0.5rem 0.75rem;"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Meta, Category, Image -->
            <div>
                <!-- Category Select (With Select2 search) -->
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                        <label style="font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin: 0;">Kategori Komoditas *</label>
                        <a href="{{ route('admin.categories.index') }}" target="_blank" style="font-size: 0.75rem; color: var(--admin-gold); text-decoration: none; font-weight: 600;">+ Kelola Kategori</a>
                    </div>
                    <select name="category" required class="select2" style="width: 100%;">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}" {{ old('category') === $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Cover Image -->
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Foto Cover Produk (JPG, PNG, WebP)</label>
                    <input type="file" name="image" accept="image/*" class="form-input" style="width: 100%; padding: 0.5rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                    <span style="font-size: 0.725rem; color: var(--admin-muted);">Ukuran rasio ideal 4:3 (Maksimal 3MB)</span>
                </div>

                <!-- Sort Order -->
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Nomor Urutan Tampilan</label>
                    <input type="number" name="sort_order" value="1" class="form-input" style="width: 100%; padding: 0.6rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
                </div>

                <!-- Options -->
                <div style="background: #F8FAFC; border: 1px solid var(--admin-border); border-radius: 10px; padding: 1.25rem; margin-bottom: 1.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; font-weight: 600; cursor: pointer; margin-bottom: 0.75rem;">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span>Status Aktif (Tampil di Katalog)</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                        <input type="checkbox" name="is_featured" value="1" checked>
                        <span>Jadikan Produk Unggulan Beranda</span>
                    </label>
                </div>

                <button type="submit" class="btn-admin btn-admin-gold" style="width: 100%; padding: 0.85rem; font-size: 0.95rem; justify-content: center;">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Komoditas</span>
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Tuliskan deskripsi lengkap, keunggulan, proses curing, dan informasi pengemasan...',
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
