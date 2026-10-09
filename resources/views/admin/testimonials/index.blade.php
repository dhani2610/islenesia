@extends('layouts.admin')

@section('title', 'Manajemen Testimoni Buyer')
@section('header_title', 'Testimoni Pembeli Internasional')

@section('content')

<div class="admin-card">
    <div class="card-header-flex">
        <div>
            <h3>Daftar Ulasan & Testimoni Mitra</h3>
            <p style="font-size: 0.8125rem; color: var(--admin-muted); margin-top: 0.25rem;">
                Kelola ulasan pembeli dari Jerman, China, Prancis, dan domestik untuk meningkatkan kredibilitas ekspor.
            </p>
        </div>

        <a href="{{ route('admin.testimonials.create') }}" class="btn-admin btn-admin-gold">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Testimoni</span>
        </a>
    </div>

    <div class="table-responsive">
        <table id="testiTable" class="table table-striped table-hover" style="width: 100%; font-size: 0.875rem;">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th style="width: 60px;">Foto</th>
                    <th>Nama Klien</th>
                    <th>Perusahaan / Negara</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th style="width: 120px; text-align: center;">Aksi</th>
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
    let tTable = null;

    $(document).ready(function() {
        tTable = $('#testiTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.testimonials.data') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'avatar_img', name: 'avatar', orderable: false, searchable: false },
                { data: 'client_name', name: 'client_name' },
                { data: 'client_company', name: 'client_company' },
                { data: 'stars', name: 'rating' },
                { data: 'status_badge', name: 'is_active' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            language: {
                search: "Cari Testimoni:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ ulasan",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "&rarr;",
                    previous: "&larr;"
                }
            }
        });
    });

    function deleteTestimonial(id) {
        Swal.fire({
            title: 'Hapus Testimoni Ini?',
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
                    url: "{{ url('admin/testimonials') }}/" + id,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function() {
                        Swal.fire('Terhapus!', 'Testimoni berhasil dihapus.', 'success');
                        tTable.ajax.reload(null, false);
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
