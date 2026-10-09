@extends('layouts.admin')

@section('title', 'Moderasi Komentar Blog')
@section('header_title', 'Moderasi & Persetujuan Komentar')

@section('content')

<div class="admin-card">
    <div class="card-header-flex">
        <div>
            <h3>Daftar Seluruh Komentar Pembaca</h3>
            <p style="font-size: 0.8125rem; color: var(--admin-muted); margin-top: 0.25rem;">
                Tinjau komentar pembaca artikel, setujui atau batalkan persetujuan untuk menjaga reputasi web.
            </p>
        </div>
    </div>

    <div class="table-responsive">
        <table id="commentsTable" class="table table-striped table-hover" style="width: 100%; font-size: 0.875rem;">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Artikel Terkait</th>
                    <th>Nama Penulis</th>
                    <th>Email</th>
                    <th>Komentar</th>
                    <th>Status</th>
                    <th>Waktu</th>
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
    let commTable = null;

    $(document).ready(function() {
        commTable = $('#commentsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.comments.data') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'post_title', name: 'post.title' },
                { data: 'author_name', name: 'author_name' },
                { data: 'author_email', name: 'author_email' },
                { data: 'comment', name: 'comment' },
                { data: 'status_badge', name: 'is_approved' },
                { data: 'date_formatted', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            language: {
                search: "Cari Komentar:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ komentar",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "&rarr;",
                    previous: "&larr;"
                }
            }
        });
    });

    function toggleComment(id) {
        $.ajax({
            url: "{{ url('admin/comments') }}/" + id + "/toggle",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function() {
                commTable.ajax.reload(null, false);
            },
            error: function() {
                Swal.fire('Gagal!', 'Terjadi kesalahan sistem.', 'error');
            }
        });
    }

    function deleteComment(id) {
        Swal.fire({
            title: 'Hapus Komentar Ini?',
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
                    url: "{{ url('admin/comments') }}/" + id,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function() {
                        Swal.fire('Terhapus!', 'Komentar berhasil dihapus.', 'success');
                        commTable.ajax.reload(null, false);
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
