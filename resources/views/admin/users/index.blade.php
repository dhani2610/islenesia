@extends('layouts.admin')

@section('title', 'Kelola Akun Administrator')
@section('header_title', 'Manajemen Pengguna Admin')

@section('content')

<div class="admin-card">
    <div class="card-header-flex">
        <div>
            <h3>Daftar Administrator Sistem</h3>
            <p style="font-size: 0.8125rem; color: var(--admin-muted); margin-top: 0.25rem;">
                Kelola hak akses pengelola website ekspor. Anda dapat menambah, mengedit, atau menghapus admin.
            </p>
        </div>

        <a href="{{ route('admin.users.create') }}" class="btn-admin btn-admin-gold">
            <i class="fa-solid fa-user-plus"></i>
            <span>Tambah Admin Baru</span>
        </a>
    </div>

    <div class="table-responsive">
        <table id="usersTable" class="table table-striped table-hover" style="width: 100%; font-size: 0.875rem;">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th style="width: 60px;">Avatar</th>
                    <th>Nama Lengkap</th>
                    <th>Email Login</th>
                    <th>Terdaftar Sejak</th>
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
    let uTable = null;

    $(document).ready(function() {
        uTable = $('#usersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.users.data') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'avatar_badge', name: 'avatar', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'date_formatted', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            language: {
                search: "Cari Admin:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ admin",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "&rarr;",
                    previous: "&larr;"
                }
            }
        });
    });

    function deleteAdmin(id) {
        Swal.fire({
            title: 'Hapus Admin Ini?',
            text: 'Akun admin yang dihapus tidak akan dapat login kembali.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#64748B',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/users') }}/" + id,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Terhapus!', res.message, 'success');
                            uTable.ajax.reload(null, false);
                        } else {
                            Swal.fire('Gagal!', res.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan sistem.', 'error');
                    }
                });
            }
        });
    }
</script>
@endpush

@endsection
