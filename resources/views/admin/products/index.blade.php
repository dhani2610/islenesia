@extends('layouts.admin')

@section('title', 'Katalog Produk Komoditas')
@section('header_title', 'Manajemen Produk Komoditas Ekspor')

@section('content')

<div class="admin-card">
    <div class="card-header-flex">
        <div>
            <h3>Daftar Seluruh Komoditas Ekspor</h3>
            <p style="font-size: 0.8125rem; color: var(--admin-muted); margin-top: 0.25rem;">
                Kelola spesifikasi teknis, foto produk, dan status ketersediaan stok ekspor.
            </p>
        </div>

        <a href="{{ route('admin.products.create') }}" class="btn-admin btn-admin-gold">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Komoditas Baru</span>
        </a>
    </div>

    <div class="table-responsive">
        <table id="productsTable" class="table table-striped table-hover" style="width: 100%; font-size: 0.875rem;">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th style="width: 70px;">Foto</th>
                    <th>Nama Komoditas</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Unggulan</th>
                    <th>Urutan</th>
                    <th style="width: 140px; text-align: center;">Aksi</th>
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
    let prodTable = null;

    $(document).ready(function() {
        prodTable = $('#productsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.products.data') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'thumbnail', name: 'image', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'category', name: 'category' },
                { data: 'status_badge', name: 'is_active' },
                { data: 'featured_badge', name: 'is_featured' },
                { data: 'sort_order', name: 'sort_order' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            language: {
                search: "Cari Produk:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ produk",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "&rarr;",
                    previous: "&larr;"
                }
            }
        });
    });

    function deleteProduct(id) {
        Swal.fire({
            title: 'Hapus Produk Komoditas Ini?',
            text: 'Data yang dihapus tidak dapat dipulihkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#64748B',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/products') }}/" + id,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function() {
                        Swal.fire('Terhapus!', 'Produk berhasil dihapus.', 'success');
                        prodTable.ajax.reload(null, false);
                    },
                    error: function() {
                        Swal.fire('Gagal!', 'Terjadi kesalahan sistem.', 'error');
                    }
                });
            }
        });
    }
</script>
@endpush

@endsection
