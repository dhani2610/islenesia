@extends('layouts.admin')

@section('title', 'Manajemen Kategori Katalog')
@section('header_title', 'Kelola Kategori Katalog Komoditas')

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
            <h3>Daftar Kategori Katalog Ekspor</h3>
            <p style="font-size: 0.8125rem; color: var(--admin-muted); margin-top: 0.25rem;">
                Kelola kategori komoditas (Vanili, Kratom, Kopi, Cengkeh, dsb). Kategori ini otomatis tampil sebagai filter di halaman Katalog Publik dan pilihan dropdown saat menambah produk baru.
            </p>
        </div>

        <a href="{{ route('admin.categories.create') }}" class="btn-admin btn-admin-gold">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Kategori Baru</span>
        </a>
    </div>

    <div class="table-responsive">
        <table id="categoryTable" class="table table-striped table-hover" style="width: 100%; font-size: 0.875rem;">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama & Slug Kategori</th>
                    <th style="width: 120px; text-align: center;">Jumlah Produk</th>
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
        $('#categoryTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.categories.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name_badge', name: 'name' },
                { data: 'products_count', name: 'products_count', className: 'text-center', orderable: false, searchable: false },
                { data: 'sort_order', name: 'sort_order', className: 'text-center' },
                { data: 'status_badge', name: 'is_active', className: 'text-center' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ],
            language: {
                search: "",
                searchPlaceholder: "Cari nama kategori...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ kategori",
                infoEmpty: "Tidak ada data kategori",
                zeroRecords: "Tidak ada kategori yang cocok",
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
