@extends('layouts.admin')

@section('title', 'Edit Kategori Katalog')
@section('header_title', 'Edit Kategori Katalog')

@section('content')

<div class="admin-card" style="max-width: 680px; margin: 0 auto;">
    <div class="card-header-flex">
        <div>
            <h3>Edit Kategori: {{ $category->name }}</h3>
            <p style="font-size: 0.8125rem; color: var(--admin-muted); margin-top: 0.25rem;">
                Perbarui nama, slug, urutan, atau status keaktifan kategori.
            </p>
        </div>

        <a href="{{ route('admin.categories.index') }}" class="btn-admin btn-admin-navy">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    @if ($errors->any())
        <div class="alert-box alert-danger">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <div>
                <strong>Terdapat kesalahan:</strong>
                <ul style="margin-left: 1.25rem; margin-top: 0.25rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 1.25rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">
                Nama Kategori *
            </label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="form-control" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem;">
        </div>

        <div style="margin-bottom: 1.25rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">
                Slug URL
            </label>
            <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem;">
        </div>

        <div style="margin-bottom: 1.25rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">
                Deskripsi Singkat Kategori (Opsional)
            </label>
            <textarea name="description" rows="3" class="form-control" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem;">{{ old('description', $category->description) }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 2rem;">
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">
                    Urutan Tampil *
                </label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0" required class="form-control" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem;">
            </div>

            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">
                    Status Kategori
                </label>
                <label style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.75rem; cursor: pointer; font-size: 0.875rem; font-weight: 600;">
                    <input type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--admin-gold);">
                    <span>Aktif (Tampil di Filter & Dropdown)</span>
                </label>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
            <a href="{{ route('admin.categories.index') }}" class="btn-admin btn-admin-navy">Batal</a>
            <button type="submit" class="btn-admin btn-admin-gold">
                <i class="fa-solid fa-check"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>

@endsection
