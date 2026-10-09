@extends('layouts.admin')

@section('title', 'Edit FAQ')
@section('header_title', 'Perbarui FAQ & Tanya Jawab')

@section('content')

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header-flex">
        <div>
            <h3>Edit Tanya Jawab (FAQ)</h3>
            <p style="font-size: 0.8125rem; color: var(--admin-muted); margin-top: 0.25rem;">
                Perbarui pertanyaan, jawaban, dan kategori FAQ ini.
            </p>
        </div>

        <a href="{{ route('admin.faqs.index') }}" class="btn-admin btn-admin-navy">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    @if ($errors->any())
        <div class="alert-box alert-danger">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>
                <strong>Terdapat kesalahan input:</strong>
                <ul style="margin: 0.25rem 0 0 1.25rem; font-size: 0.825rem;">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">
                Pertanyaan (Question) *
            </label>
            <input type="text" name="question" required value="{{ old('question', $faq->question) }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">
                    Kategori FAQ *
                </label>
                <select name="category" class="select2-search" style="width: 100%;">
                    @php
                        $presetCategories = ['Ekspor & Pemesanan', 'Logistik & Pelabuhan', 'Kemitraan Petani', 'Legalitas & Mutu', 'Pembayaran & Kontrak', 'Umum'];
                        if (!in_array($faq->category, $presetCategories)) {
                            $presetCategories[] = $faq->category;
                        }
                    @endphp
                    @foreach($presetCategories as $cat)
                        <option value="{{ $cat }}" {{ old('category', $faq->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">
                    Nomor Urutan Tampil (Sort Order)
                </label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $faq->sort_order) }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">
                Jawaban Lengkap (Answer) *
            </label>
            <textarea name="answer" required rows="5" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">{{ old('answer', $faq->answer) }}</textarea>
        </div>

        <div style="margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
            <input type="checkbox" name="is_active" id="isActiveCheck" value="1" {{ old('is_active', $faq->is_active) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--admin-gold); cursor: pointer;">
            <label for="isActiveCheck" style="font-size: 0.9rem; font-weight: 600; color: var(--admin-navy-surface); cursor: pointer;">
                Publikasikan FAQ ini di Website (Aktif)
            </label>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn-admin btn-admin-gold">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Perbarui FAQ</span>
            </button>
            <a href="{{ route('admin.faqs.index') }}" class="btn-admin btn-admin-navy">
                Batal
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2-search').select2({
            tags: true,
            placeholder: 'Pilih atau ketik kategori...',
            width: '100%'
        });
    });
</script>
@endpush

@endsection
