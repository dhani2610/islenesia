@extends('layouts.admin')

@section('title', 'Kelola Klien Kami (Our Clients)')
@section('header_title', 'Kelola Klien Kami (Our Clients)')

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
            <h3>Daftar Logo Klien Ekspor</h3>
            <p style="font-size: 0.8125rem; color: var(--admin-muted); margin-top: 0.25rem;">
                Kelola logo klien atau importir global yang telah bermitra dengan Islenesia. Ditampilkan dalam bentuk marquee slider otomatis di beranda.
            </p>
        </div>

        <a href="{{ route('admin.clients.create') }}" class="btn-admin btn-admin-gold">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Klien Baru</span>
        </a>
    </div>

    <div class="table-responsive">
        <table id="clientTable" class="table table-striped table-hover" style="width: 100%; font-size: 0.875rem;">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th style="width: 140px;">Logo</th>
                    <th>Nama Klien & Negara / Tipe</th>
                    <th style="width: 90px; text-align: center;">Urutan</th>
                    <th style="width: 100px; text-align: center;">Status</th>
                    <th style="width: 110px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loaded via AJAX -->
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#clientTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.clients.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'logo_preview', name: 'logo', orderable: false, searchable: false },
                { data: 'client_info', name: 'name' },
                { data: 'sort_order', name: 'sort_order', className: 'text-center' },
                { data: 'status_badge', name: 'is_active', className: 'text-center' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ],
            language: {
                search: "",
                searchPlaceholder: "Cari logo klien...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ klien",
                infoEmpty: "Tidak ada klien",
                zeroRecords: "Tidak ada data klien yang cocok",
                paginate: { previous: "&larr;", next: "&rarr;" }
            }
        });
    });
</script>
@endpush

@endsection
