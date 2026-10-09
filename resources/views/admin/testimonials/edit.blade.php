@extends('layouts.admin')

@section('title', 'Edit Testimoni Buyer')
@section('header_title', 'Edit Testimoni: ' . $testimonial->client_name)

@section('content')

<div class="admin-card" style="max-width: 800px;">
    <div class="card-header-flex">
        <h3>Edit Ulasan Buyer</h3>
        <a href="{{ route('admin.testimonials.index') }}" class="btn-admin btn-admin-navy" style="font-size: 0.8125rem;">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Nama Klien / Buyer *</label>
                <input type="text" name="client_name" required value="{{ old('client_name', $testimonial->client_name) }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            </div>
            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Nama Perusahaan</label>
                <input type="text" name="client_company" value="{{ old('client_company', $testimonial->client_company) }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Negara Asal</label>
                <input type="text" name="client_country" value="{{ old('client_country', $testimonial->client_country) }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            </div>
            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Rating Bintang *</label>
                <select name="rating" required class="select2" style="width: 100%;">
                    <option value="5" {{ $testimonial->rating == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Bintang - Sempurna)</option>
                    <option value="4" {{ $testimonial->rating == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4 Bintang - Sangat Bagus)</option>
                    <option value="3" {{ $testimonial->rating == 3 ? 'selected' : '' }}>⭐⭐⭐ (3 Bintang - Cukup)</option>
                </select>
            </div>
        </div>

        <div style="margin-bottom: 1.25rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Isi Testimoni / Ulasan *</label>
            <textarea name="content" rows="4" required class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">{{ old('content', $testimonial->content) }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Foto Avatar / Logo Klien</label>
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                    <img src="{{ $testimonial->avatar_url }}" alt="{{ $testimonial->client_name }}" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover;">
                    <span style="font-size: 0.775rem; color: var(--admin-muted);">Avatar saat ini</span>
                </div>
                <input type="file" name="avatar" accept="image/*" class="form-input" style="width: 100%; padding: 0.5rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            </div>
            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Nomor Urutan</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order) }}" class="form-input" style="width: 100%; padding: 0.6rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" {{ $testimonial->is_active ? 'checked' : '' }}>
                <span>Tampilkan di Halaman Depan</span>
            </label>
        </div>

        <button type="submit" class="btn-admin btn-admin-gold" style="padding: 0.85rem 2rem; font-size: 0.95rem;">
            <i class="fa-solid fa-floppy-disk"></i>
            <span>Perbarui Testimoni</span>
        </button>
    </form>
</div>

@endsection
