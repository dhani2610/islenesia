@extends('layouts.admin')

@section('title', 'Edit Banner Slider')
@section('header_title', 'Edit Banner Slider')

@section('content')

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header-flex">
        <div>
            <h3>Edit Banner Slider</h3>
            <p style="font-size: 0.8125rem; color: var(--admin-muted); margin-top: 0.25rem;">
                Perbarui foto, video YouTube autoplay, urutan, atau status tayang banner slider.
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

        <!-- Tipe Media Selector -->
        <div style="margin-bottom: 1.75rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.65rem;">
                Tipe Media Banner Slider *
            </label>
            @php $currentType = old('type', $slider->type ?? 'image'); @endphp
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <label id="typeLabelImage" style="display: flex; align-items: center; gap: 0.75rem; padding: 1rem 1.25rem; border: 2px solid {{ $currentType === 'image' ? 'var(--admin-gold)' : 'var(--admin-border)' }}; border-radius: 12px; background: {{ $currentType === 'image' ? 'rgba(212, 175, 55, 0.08)' : '#FFF' }}; cursor: pointer; transition: all 0.2s;">
                    <input type="radio" name="type" value="image" {{ $currentType === 'image' ? 'checked' : '' }} onchange="toggleMediaType('image')" style="accent-color: var(--admin-gold); width: 18px; height: 18px;">
                    <div>
                        <div style="font-weight: 700; font-size: 0.925rem; color: var(--admin-navy-surface);"><i class="fa-regular fa-image" style="color: var(--admin-gold);"></i> Gambar / Foto</div>
                        <div style="font-size: 0.775rem; color: var(--admin-muted);">Upload foto lanskap resolusi tinggi (16:9)</div>
                    </div>
                </label>

                <label id="typeLabelVideo" style="display: flex; align-items: center; gap: 0.75rem; padding: 1rem 1.25rem; border: 2px solid {{ $currentType === 'video' ? 'var(--admin-gold)' : 'var(--admin-border)' }}; border-radius: 12px; background: {{ $currentType === 'video' ? 'rgba(212, 175, 55, 0.08)' : '#FFF' }}; cursor: pointer; transition: all 0.2s;">
                    <input type="radio" name="type" value="video" {{ $currentType === 'video' ? 'checked' : '' }} onchange="toggleMediaType('video')" style="accent-color: var(--admin-gold); width: 18px; height: 18px;">
                    <div>
                        <div style="font-weight: 700; font-size: 0.925rem; color: var(--admin-navy-surface);"><i class="fa-brands fa-youtube" style="color: #DC2626;"></i> Video YouTube</div>
                        <div style="font-size: 0.775rem; color: var(--admin-muted);">Autoplay berulang sebagai background hero</div>
                    </div>
                </label>
            </div>
        </div>

        <!-- Video YouTube Input Section -->
        <div id="videoFieldWrapper" style="display: {{ $currentType === 'video' ? 'block' : 'none' }}; margin-bottom: 1.75rem; background: #F8FAFC; border: 1.5px solid var(--admin-border); border-radius: 12px; padding: 1.25rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                Link Video YouTube *
            </label>
            <div style="position: relative;">
                <i class="fa-brands fa-youtube" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #DC2626; font-size: 1.15rem;"></i>
                <input type="url" name="youtube_url" id="youtubeUrlInput" value="{{ old('youtube_url', $slider->youtube_url) }}" placeholder="https://www.youtube.com/watch?v=..." class="form-control" style="width: 100%; padding: 0.75rem 0.75rem 0.75rem 2.8rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem;" oninput="updateYoutubePreview(this.value)">
            </div>
            <p style="font-size: 0.775rem; color: var(--admin-muted); margin-top: 0.45rem;">
                Bisa link video standar (<code>youtube.com/watch?v=...</code>), short link (<code>youtu.be/...</code>), atau shorts.
            </p>

            <div id="ytPreviewWrapper" style="display: {{ $slider->youtube_id ? 'block' : 'none' }}; margin-top: 1rem;">
                <label style="display: block; font-size: 0.775rem; font-weight: 700; color: var(--admin-muted); margin-bottom: 0.35rem;">Preview Player Video:</label>
                <div style="position: relative; width: 100%; aspect-ratio: 16/9; max-height: 280px; background: #000; border-radius: 10px; overflow: hidden;">
                    <iframe id="ytPreviewIframe" src="{{ $slider->youtube_id ? 'https://www.youtube.com/embed/' . $slider->youtube_id . '?autoplay=0' : '' }}" style="width: 100%; height: 100%; border: none;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                </div>
            </div>
        </div>

        <!-- Image Upload Section -->
        <div id="imageFieldWrapper" style="margin-bottom: 1.75rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                Media Banner Saat Ini
            </label>
            <div style="margin-bottom: 1rem;">
                <img id="currentImg" src="{{ $slider->image_url }}" alt="Current Slide" style="max-width: 100%; height: 220px; object-fit: cover; border-radius: 10px; border: 1.5px solid var(--admin-border);">
            </div>

            <label id="imageFieldLabel" style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                Ganti Foto / Cover Poster (Opsional)
            </label>
            <input type="file" name="image" id="imageFileInput" accept="image/*" class="form-control" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem; background: #FFF;" onchange="previewSlide(this)">
            <p id="imageFieldHelp" style="font-size: 0.775rem; color: var(--admin-muted); margin-top: 0.35rem;">
                Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG, WEBP (Maks. 5MB).
            </p>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.5rem;">
                Judul / Keterangan Slide (Opsional)
            </label>
            <input type="text" name="title" value="{{ old('title', $slider->title) }}" placeholder="Contoh: Panen Raya Biji Kopi / Profil Video Pabrik Ekspor" class="form-control" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px; font-size: 0.875rem;">
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
    function toggleMediaType(type) {
        var videoWrapper = document.getElementById('videoFieldWrapper');
        var imageLabel = document.getElementById('imageFieldLabel');
        var labelImg = document.getElementById('typeLabelImage');
        var labelVid = document.getElementById('typeLabelVideo');

        if (type === 'video') {
            videoWrapper.style.display = 'block';
            imageLabel.textContent = 'Ganti Cover Thumbnail Poster (Opsional)';
            labelVid.style.borderColor = 'var(--admin-gold)';
            labelVid.style.background = 'rgba(212, 175, 55, 0.08)';
            labelImg.style.borderColor = 'var(--admin-border)';
            labelImg.style.background = '#FFF';
        } else {
            videoWrapper.style.display = 'none';
            imageLabel.textContent = 'Ganti Foto Banner (Opsional)';
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
                var currentImg = document.getElementById('currentImg');
                currentImg.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush

@endsection
