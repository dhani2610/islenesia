@extends('layouts.admin')

@section('title', 'Tambah Banner Slider')
@section('header_title', 'Tambah Banner Slider Baru')

@section('content')

<div class="admin-card" style="max-width: 760px; margin: 0 auto;">
    <div class="card-header-flex">
        <div>
            <h3>Form Upload Slider</h3>
            <p style="font-size: 0.8125rem; color: var(--admin-muted); margin-top: 0.25rem;">
                Tambahkan foto resolusi tinggi untuk banner slider paling awal di beranda.
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

    <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                File Foto Banner Slider *
            </label>
            <input type="file" name="image" required accept="image/*" class="form-control" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem; background: #FFF;" onchange="previewSlide(this)">
            <p style="font-size: 0.775rem; color: var(--admin-muted); margin-top: 0.35rem;">
                Format didukung: JPG, PNG, WEBP. Rekomendasi rasio: 16:9 atau 1920x1080 px (Maks. 5MB).
            </p>
            <div id="imagePreviewBox" style="display: none; margin-top: 1rem;">
                <img id="previewImg" src="" alt="Preview" style="max-width: 100%; height: 220px; object-fit: cover; border-radius: 10px; border: 1px solid var(--admin-border);">
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                Judul / Keterangan Slide (Opsional)
            </label>
            <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Panen Raya Biji Kopi / Vanili Organik" class="form-control" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem;">
            <p style="font-size: 0.775rem; color: var(--admin-muted); margin-top: 0.35rem;">
                Teks ini untuk penamaan internal admin.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 2rem;">
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                    Urutan Tampil *
                </label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $nextOrder) }}" min="0" required class="form-control" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem;">
            </div>

            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                    Status Tayang
                </label>
                <label style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.75rem; cursor: pointer; font-size: 0.875rem; font-weight: 600;">
                    <input type="checkbox" name="is_active" value="1" checked style="width: 18px; height: 18px; accent-color: var(--admin-gold);">
                    <span>Aktif (Tampilkan di Beranda)</span>
                </label>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
            <a href="{{ route('admin.sliders.index') }}" class="btn-admin btn-admin-navy">Batal</a>
            <button type="submit" class="btn-admin btn-admin-gold">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <span>Simpan Slider</span>
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
                var previewBox = document.getElementById('imagePreviewBox');
                var previewImg = document.getElementById('previewImg');
                previewImg.src = e.target.result;
                previewBox.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush

@endsection
