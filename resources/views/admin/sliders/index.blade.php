@extends('layouts.admin')

@section('title', 'Kelola Hero Banner Slider')
@section('header_title', 'Kelola Hero Slider Beranda')

@section('content')

@if(session('success'))
    <div class="alert-box alert-success">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="admin-card">
    <div class="card-header-flex">
        <div>
            <h3>Daftar Banner Slider Beranda</h3>
            <p style="font-size: 0.8125rem; color: var(--admin-muted); margin-top: 0.25rem;">
                Kelola foto slider beranda secara dinamis. Anda bebas menambah berapa pun foto, menghapus, atau mengatur urutannya (bisa 1 slide, 2 slide, atau lebih).
            </p>
        </div>

        <a href="{{ route('admin.sliders.create') }}" class="btn-admin btn-admin-gold">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Slider Baru</span>
        </a>
    </div>

    <div class="table-responsive">
        <table id="sliderTable" class="table table-striped table-hover" style="width: 100%; font-size: 0.875rem;">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th style="width: 140px;">Foto Banner</th>
                    <th>Judul / Keterangan</th>
                    <th style="width: 90px; text-align: center;">Urutan</th>
                    <th style="width: 100px; text-align: center;">Status</th>
                    <th style="width: 110px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loaded via Yajra DataTables AJAX -->
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#sliderTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.sliders.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'image_preview', name: 'image', orderable: false, searchable: false },
                { data: 'title', name: 'title', defaultContent: '<span style="color:#94a3b8; font-style:italic;">(Tanpa teks - Murni Visual)</span>' },
                { data: 'sort_order', name: 'sort_order', className: 'text-center' },
                { data: 'status_badge', name: 'is_active', className: 'text-center' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ],
            language: {
                search: "",
                searchPlaceholder: "Cari banner slider...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ slider",
                infoEmpty: "Tidak ada slider",
                zeroRecords: "Tidak ada slider yang cocok",
                paginate: {
                    previous: "&larr;",
                    next: "&rarr;"
                }
            }
        });
    });
</script>
@endpush

@endsection
