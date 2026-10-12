@extends('layouts.admin')

@section('title', 'Tambah Banner Slider')
@section('header_title', 'Tambah Banner Slider Baru')

@section('content')

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header-flex">
        <div>
            <h3>Form Upload Slider</h3>
            <p style="font-size: 0.8125rem; color: var(--admin-muted); margin-top: 0.25rem;">
                Tambahkan foto resolusi tinggi atau video YouTube autoplay untuk banner slider utama di beranda.
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

        <!-- Tipe Media Selector -->
        <div style="margin-bottom: 1.75rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.65rem;">
                Tipe Media Banner Slider *
            </label>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <label id="typeLabelImage" style="display: flex; align-items: center; gap: 0.75rem; padding: 1rem 1.25rem; border: 2px solid var(--admin-gold); border-radius: 12px; background: rgba(212, 175, 55, 0.08); cursor: pointer; transition: all 0.2s;">
                    <input type="radio" name="type" value="image" {{ old('type', 'image') === 'image' ? 'checked' : '' }} onchange="toggleMediaType('image')" style="accent-color: var(--admin-gold); width: 18px; height: 18px;">
                    <div>
                        <div style="font-weight: 700; font-size: 0.925rem; color: var(--admin-navy-surface);"><i class="fa-regular fa-image" style="color: var(--admin-gold);"></i> Gambar / Foto</div>
                        <div style="font-size: 0.775rem; color: var(--admin-muted);">Upload foto lanskap resolusi tinggi (16:9)</div>
                    </div>
                </label>

                <label id="typeLabelVideo" style="display: flex; align-items: center; gap: 0.75rem; padding: 1rem 1.25rem; border: 2px solid var(--admin-border); border-radius: 12px; background: #FFF; cursor: pointer; transition: all 0.2s;">
                    <input type="radio" name="type" value="video" {{ old('type') === 'video' ? 'checked' : '' }} onchange="toggleMediaType('video')" style="accent-color: var(--admin-gold); width: 18px; height: 18px;">
                    <div>
                        <div style="font-weight: 700; font-size: 0.925rem; color: var(--admin-navy-surface);"><i class="fa-brands fa-youtube" style="color: #DC2626;"></i> Video YouTube</div>
                        <div style="font-size: 0.775rem; color: var(--admin-muted);">Autoplay berulang sebagai background hero</div>
                    </div>
                </label>
            </div>
        </div>

        <!-- Video YouTube Input Section -->
        <div id="videoFieldWrapper" style="display: {{ old('type') === 'video' ? 'block' : 'none' }}; margin-bottom: 1.75rem; background: #F8FAFC; border: 1.5px solid var(--admin-border); border-radius: 12px; padding: 1.25rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                Link Video YouTube *
            </label>
            <div style="position: relative;">
                <i class="fa-brands fa-youtube" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #DC2626; font-size: 1.15rem;"></i>
                <input type="url" name="youtube_url" id="youtubeUrlInput" value="{{ old('youtube_url') }}" placeholder="https://www.youtube.com/watch?v=..." class="form-control" style="width: 100%; padding: 0.75rem 0.75rem 0.75rem 2.8rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem;" oninput="updateYoutubePreview(this.value)">
            </div>
            <p style="font-size: 0.775rem; color: var(--admin-muted); margin-top: 0.45rem;">
                Bisa link video standar (<code>youtube.com/watch?v=...</code>), short link (<code>youtu.be/...</code>), atau shorts. Video akan otomatis di-play secara hening (muted & looped) di slider beranda.
            </p>

            <div id="ytPreviewWrapper" style="display: none; margin-top: 1rem;">
                <label style="display: block; font-size: 0.775rem; font-weight: 700; color: var(--admin-muted); margin-bottom: 0.35rem;">Preview Player Video:</label>
                <div style="position: relative; width: 100%; aspect-ratio: 16/9; max-height: 280px; background: #000; border-radius: 10px; overflow: hidden;">
                    <iframe id="ytPreviewIframe" src="" style="width: 100%; height: 100%; border: none;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                </div>
            </div>
        </div>

        <!-- Image Upload Section -->
        <div id="imageFieldWrapper" style="margin-bottom: 1.75rem;">
            <label id="imageFieldLabel" style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                File Foto Banner Slider *
            </label>
            <input type="file" name="image" id="imageFileInput" accept="image/*" class="form-control" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem; background: #FFF;" onchange="previewSlide(this)">
            <p id="imageFieldHelp" style="font-size: 0.775rem; color: var(--admin-muted); margin-top: 0.35rem;">
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
            <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Panen Raya Biji Kopi / Profil Video Pabrik Ekspor" class="form-control" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem;">
            <p style="font-size: 0.775rem; color: var(--admin-muted); margin-top: 0.35rem;">
                Teks ini untuk label internal di admin panel.
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
    function toggleMediaType(type) {
        var videoWrapper = document.getElementById('videoFieldWrapper');
        var imageLabel = document.getElementById('imageFieldLabel');
        var imageHelp = document.getElementById('imageFieldHelp');
        var imageInput = document.getElementById('imageFileInput');
        var labelImg = document.getElementById('typeLabelImage');
        var labelVid = document.getElementById('typeLabelVideo');

        if (type === 'video') {
            videoWrapper.style.display = 'block';
            imageLabel.textContent = 'Cover Thumbnail Poster (Opsional)';
            imageHelp.textContent = 'Opsional. Jika dikosongkan, cover akan otomatis mengambil thumbnail YouTube.';
            imageInput.removeAttribute('required');
            labelVid.style.borderColor = 'var(--admin-gold)';
            labelVid.style.background = 'rgba(212, 175, 55, 0.08)';
            labelImg.style.borderColor = 'var(--admin-border)';
            labelImg.style.background = '#FFF';
        } else {
            videoWrapper.style.display = 'none';
            imageLabel.textContent = 'File Foto Banner Slider *';
            imageHelp.textContent = 'Format didukung: JPG, PNG, WEBP. Rekomendasi rasio: 16:9 atau 1920x1080 px (Maks. 5MB).';
            imageInput.setAttribute('required', 'required');
            labelImg.style.borderColor = 'var(--admin-gold)';
            labelImg.style.background = 'rgba(212, 175, 55, 0.08)';
            labelVid.style.borderColor = 'var(--admin-border)';
            labelVid.style.background = '#FFF';
        }
    }

    function parseYoutubeId(url) {
        if (!url) return null;
        var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|shorts\/)([^#\&\?]*).*/;
        var match = url.match(regExp);
        return (match && match[2].length === 11) ? match[2] : null;
    }

    function updateYoutubePreview(url) {
        var id = parseYoutubeId(url);
        var previewWrapper = document.getElementById('ytPreviewWrapper');
        var iframe = document.getElementById('ytPreviewIframe');
        if (id) {
            iframe.src = 'https://www.youtube.com/embed/' + id + '?autoplay=0';
            previewWrapper.style.display = 'block';
        } else {
            previewWrapper.style.display = 'none';
            iframe.src = '';
        }
    }

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

    // Run on initial load if old values exist
    document.addEventListener('DOMContentLoaded', function() {
        var isVideo = "{{ old('type') }}" === 'video';
        if (isVideo) {
            toggleMediaType('video');
            var val = document.getElementById('youtubeUrlInput').value;
            if (val) updateYoutubePreview(val);
        } else {
            toggleMediaType('image');
        }
    });
</script>
@endpush

@endsection
