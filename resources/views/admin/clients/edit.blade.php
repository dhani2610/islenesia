@extends('layouts.admin')

@section('title', 'Edit Klien')
@section('header_title', 'Edit Data Klien')

@section('content')

<div class="admin-card" style="max-width: 760px; margin: 0 auto;">
    <div class="card-header-flex">
        <div>
            <h3>Edit Logo Klien</h3>
            <p style="font-size: 0.8125rem; color: var(--admin-muted); margin-top: 0.25rem;">
                Perbarui nama, logo, atau status tayang klien.
            </p>
        </div>

        <a href="{{ route('admin.clients.index') }}" class="btn-admin btn-admin-navy">
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

    <form action="{{ route('admin.clients.update', $client->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                Logo Klien Saat Ini
            </label>
            <div style="margin-bottom: 1rem; background: #F8FAFC; border: 1px solid var(--admin-border); border-radius: 10px; padding: 1.25rem; display: inline-flex; align-items: center; justify-content: center; min-width: 180px;">
                <img id="currentImg" src="{{ $client->logo_url }}" alt="Logo" style="max-height: 60px; max-width: 220px; object-fit: contain;">
            </div>

            <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                Ganti Logo (Opsional)
            </label>
            <input type="file" name="logo" accept="image/*" class="form-control" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem; background: #FFF;" onchange="previewLogo(this)">
            <p style="font-size: 0.775rem; color: var(--admin-muted); margin-top: 0.35rem;">
                Biarkan kosong jika tidak ingin mengganti logo.
            </p>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                Nama Perusahaan / Klien *
            </label>
            <input type="text" name="name" value="{{ old('name', $client->name) }}" required class="form-control" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                    Negara / Kategori Buyer (Opsional)
                </label>
                <input type="text" name="country_or_type" value="{{ old('country_or_type', $client->country_or_type) }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem;">
            </div>

            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                    Website Klien (Opsional)
                </label>
                <input type="url" name="url" value="{{ old('url', $client->url) }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 2rem;">
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                    Urutan Tampil *
                </label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $client->sort_order) }}" min="0" required class="form-control" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem;">
            </div>

            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                    Status Tayang
                </label>
                <label style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.75rem; cursor: pointer; font-size: 0.875rem; font-weight: 600;">
                    <input type="checkbox" name="is_active" value="1" {{ $client->is_active ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--admin-gold);">
                    <span>Aktif (Tampilkan di Beranda)</span>
                </label>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
            <a href="{{ route('admin.clients.index') }}" class="btn-admin btn-admin-navy">Batal</a>
            <button type="submit" class="btn-admin btn-admin-gold">
                <i class="fa-solid fa-check"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewLogo(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var currentImg = document.getElementById('currentImg');
                currentImg.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush

@endsection
