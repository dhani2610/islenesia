@extends('layouts.admin')

@section('title', 'Edit Banner Slider')
@section('header_title', 'Edit Banner Slider')

@section('content')

<div class="admin-card" style="max-width: 760px; margin: 0 auto;">
    <div class="card-header-flex">
        <div>
            <h3>Edit Banner Slider</h3>
            <p style="font-size: 0.8125rem; color: var(--admin-muted); margin-top: 0.25rem;">
                Perbarui foto, urutan, atau status tayang banner slider.
            </p>
        </div>

        <a href="{{ route('admin.sliders.index') }}" class="btn-admin btn-admin-navy">
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

    <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                Foto Banner Saat Ini
            </label>
            <div style="margin-bottom: 1rem;">
                <img id="currentImg" src="{{ $slider->image_url }}" alt="Current Slide" style="max-width: 100%; height: 220px; object-fit: cover; border-radius: 10px; border: 1.5px solid var(--admin-border);">
            </div>

            <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                Ganti Foto Banner (Opsional)
            </label>
            <input type="file" name="image" accept="image/*" class="form-control" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem; background: #FFF;" onchange="previewSlide(this)">
            <p style="font-size: 0.775rem; color: var(--admin-muted); margin-top: 0.35rem;">
                Biarkan kosong jika tidak ingin mengubah foto. Format didukung: JPG, PNG, WEBP (Maks. 5MB).
            </p>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                Judul / Keterangan Slide (Opsional)
            </label>
            <input type="text" name="title" value="{{ old('title', $slider->title) }}" placeholder="Contoh: Panen Raya Biji Kopi / Vanili Organik" class="form-control" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 2rem;">
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                    Urutan Tampil *
                </label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $slider->sort_order) }}" min="0" required class="form-control" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem;">
            </div>

            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                    Status Tayang
                </label>
                <label style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.75rem; cursor: pointer; font-size: 0.875rem; font-weight: 600;">
                    <input type="checkbox" name="is_active" value="1" {{ $slider->is_active ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--admin-gold);">
                    <span>Aktif (Tampilkan di Beranda)</span>
                </label>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
            <a href="{{ route('admin.sliders.index') }}" class="btn-admin btn-admin-navy">Batal</a>
            <button type="submit" class="btn-admin btn-admin-gold">
                <i class="fa-solid fa-check"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewSlide(input) {
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
