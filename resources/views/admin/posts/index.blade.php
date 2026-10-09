@extends('layouts.admin')

@section('title', 'Manajemen Artikel Blog')
@section('header_title', 'Artikel & Wawasan Ekspor')

@section('content')

<div class="admin-card">
    <div class="card-header-flex">
        <div>
            <h3>Daftar Seluruh Artikel Publikasi</h3>
            <p style="font-size: 0.8125rem; color: var(--admin-muted); margin-top: 0.25rem;">
                Kelola konten edukasi ekspor, optimasi SEO, dan wawasan pasar komoditas.
            </p>
        </div>

        <a href="{{ route('admin.posts.create') }}" class="btn-admin btn-admin-gold">
            <i class="fa-solid fa-plus"></i>
            <span>Tulis Artikel Baru</span>
        </a>
    </div>

    <div class="table-responsive">
        <table id="postsTable" class="table table-striped table-hover" style="width: 100%; font-size: 0.875rem;">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th style="width: 70px;">Cover</th>
                    <th>Judul Artikel</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tanggal Publikasi</th>
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
    let postTable = null;

    $(document).ready(function() {
        postTable = $('#postsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.posts.data') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'thumbnail', name: 'image', orderable: false, searchable: false },
                { data: 'title', name: 'title' },
                { data: 'category', name: 'category' },
                { data: 'status_badge', name: 'is_published' },
                { data: 'date_formatted', name: 'published_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            language: {
                search: "Cari Artikel:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ artikel",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "&rarr;",
                    previous: "&larr;"
                }
            }
        });
    });

    function deletePost(id) {
        Swal.fire({
            title: 'Hapus Artikel Ini?',
            text: 'Data artikel yang dihapus tidak dapat dipulihkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#64748B',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/posts') }}/" + id,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function() {
                        Swal.fire('Terhapus!', 'Artikel berhasil dihapus.', 'success');
                        postTable.ajax.reload(null, false);
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
