@extends('layouts.admin')

@section('title', 'Manajemen Leads & Inquiries')
@section('header_title', 'Leads Agregator (Buyer & Petani)')

@section('content')

<div class="admin-card">
    <div class="card-header-flex">
        <div>
            <h3>Daftar Seluruh Permintaan & Tawaran Komoditas</h3>
        </div>

        <div style="display: flex; gap: 0.5rem;">
            <button type="button" class="btn-admin btn-admin-navy" onclick="filterType('')" style="font-size: 0.8rem; padding: 0.4rem 0.85rem;">
                Semua
            </button>
            <button type="button" class="btn-admin" onclick="filterType('buyer')" style="font-size: 0.8rem; padding: 0.4rem 0.85rem; background: #DBEAFE; color: #1E40AF;">
                <i class="fa-solid fa-box"></i> Buyer Saja
            </button>
            <button type="button" class="btn-admin" onclick="filterType('petani')" style="font-size: 0.8rem; padding: 0.4rem 0.85rem; background: #D1FAE5; color: #065F46;">
                <i class="fa-solid fa-seedling"></i> Petani Saja
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table id="inquiriesTable" class="table table-striped table-hover" style="width: 100%; font-size: 0.875rem;">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Peran</th>
                    <th>Nama / Perusahaan</th>
                    <th>WhatsApp</th>
                    <th>Pesan / Kebutuhan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
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
    let currentTypeFilter = '';
    let table = null;

    $(document).ready(function() {
        table = $('#inquiriesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.inquiries.data') }}",
                data: function(d) {
                    d.type = currentTypeFilter;
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'type_badge', name: 'type' },
                { data: 'name', name: 'name' },
                { data: 'whatsapp', name: 'whatsapp' },
                { data: 'message', name: 'message' },
                { data: 'status_badge', name: 'status' },
                { data: 'created_date', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            language: {
                search: "Cari Data:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ leads",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "&rarr;",
                    previous: "&larr;"
                }
            }
        });
    });

    function filterType(type) {
        currentTypeFilter = type;
        table.ajax.reload();
    }

    function deleteInquiry(id) {
        Swal.fire({
            title: 'Hapus Lead Ini?',
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
                    url: "{{ url('admin/inquiries') }}/" + id,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function() {
                        Swal.fire('Terhapus!', 'Lead berhasil dihapus.', 'success');
                        table.ajax.reload(null, false);
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
