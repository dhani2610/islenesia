@extends('layouts.admin')

@section('title', 'Kelola Partner & Mitra (Our Partners)')
@section('header_title', 'Kelola Partner & Mitra (Our Partners)')

@section('content')

<div class="admin-card">
    <div class="card-header-flex">
        <div>
            <h3>Daftar Partner & Ekosistem Bisnis</h3>
            <p style="font-size: 0.8125rem; color: var(--admin-muted); margin-top: 0.25rem;">
                Kelola logo lembaga sertifikasi, asosiasi eksportir, ekspedisi kargo pelayaran, dan kemitraan koperasi petani. Ditampilkan dalam auto-slide beranda.
            </p>
        </div>

        <a href="{{ route('admin.partners.create') }}" class="btn-admin btn-admin-gold">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Partner Baru</span>
        </a>
    </div>

    <div class="table-responsive">
        <table id="partnerTable" class="table table-striped table-hover" style="width: 100%; font-size: 0.875rem;">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th style="width: 140px;">Logo</th>
                    <th>Nama Partner & Kategori</th>
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
        $('#partnerTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.partners.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'logo_preview', name: 'logo', orderable: false, searchable: false },
                { data: 'partner_info', name: 'name' },
                { data: 'sort_order', name: 'sort_order', className: 'text-center' },
                { data: 'status_badge', name: 'is_active', className: 'text-center' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ],
            language: {
                search: "",
                searchPlaceholder: "Cari logo partner...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ partner",
                infoEmpty: "Tidak ada partner",
                zeroRecords: "Tidak ada data partner yang cocok",
                paginate: { previous: "&larr;", next: "&rarr;" }
            }
        });
    });
</script>
@endpush

@endsection
