@extends('layouts.admin')

@section('title', 'Tambah Testimoni Buyer')
@section('header_title', 'Tambah Testimoni Baru')

@section('content')

<div class="admin-card" style="max-width: 800px;">
    <div class="card-header-flex">
        <h3>Formulir Testimoni Buyer</h3>
        <a href="{{ route('admin.testimonials.index') }}" class="btn-admin btn-admin-navy" style="font-size: 0.8125rem;">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Nama Klien / Buyer *</label>
                <input type="text" name="client_name" required value="{{ old('client_name') }}" placeholder="Contoh: Marcus Vance / Zhang Wei" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            </div>
            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Nama Perusahaan</label>
                <input type="text" name="client_company" value="{{ old('client_company') }}" placeholder="Contoh: EuroFlavor GmbH / Eastern Botanicals" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Negara Asal</label>
                <input type="text" name="client_country" value="{{ old('client_country') }}" placeholder="Contoh: Germany / China / France" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            </div>
            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Rating Bintang *</label>
                <select name="rating" required class="select2" style="width: 100%;">
                    <option value="5" selected>⭐⭐⭐⭐⭐ (5 Bintang - Sempurna)</option>
                    <option value="4">⭐⭐⭐⭐ (4 Bintang - Sangat Bagus)</option>
                    <option value="3">⭐⭐⭐ (3 Bintang - Cukup)</option>
                </select>
            </div>
        </div>

        <div style="margin-bottom: 1.25rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Isi Testimoni / Ulasan *</label>
            <textarea name="content" rows="4" required class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;" placeholder="Tuliskan pengalaman buyer terhadap kualitas komoditas dan kepabeanan...">{{ old('content') }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Foto Avatar / Logo Klien</label>
                <input type="file" name="avatar" accept="image/*" class="form-input" style="width: 100%; padding: 0.5rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            </div>
            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Nomor Urutan</label>
                <input type="number" name="sort_order" value="1" class="form-input" style="width: 100%; padding: 0.6rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" checked>
                <span>Tampilkan di Halaman Depan</span>
            </label>
        </div>

        <button type="submit" class="btn-admin btn-admin-gold" style="padding: 0.85rem 2rem; font-size: 0.95rem;">
            <i class="fa-solid fa-floppy-disk"></i>
            <span>Simpan Testimoni</span>
        </button>
    </form>
</div>

@endsection
