@extends('layouts.admin')

@section('title', 'Manajemen FAQ & Tanya Jawab')
@section('header_title', 'Kelola FAQ & Tanya Jawab Ekspor')

@section('content')

<div class="admin-card">
    <div class="card-header-flex">
        <div>
            <h3>Daftar FAQ & Pertanyaan Umum</h3>
            <p style="font-size: 0.8125rem; color: var(--admin-muted); margin-top: 0.25rem;">
                Kelola pertanyaan seputar MOQ, prosedur ekspor, pengujian lab karantina, pembayaran L/C, dan kemitraan petani.
            </p>
        </div>

        <a href="{{ route('admin.faqs.create') }}" class="btn-admin btn-admin-gold">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah FAQ Baru</span>
        </a>
    </div>

    <div class="table-responsive">
        <table id="faqTable" class="table table-striped table-hover" style="width: 100%; font-size: 0.875rem;">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Pertanyaan</th>
                    <th style="width: 160px;">Kategori</th>
                    <th style="width: 80px;">Urutan</th>
                    <th style="width: 90px;">Status</th>
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
    let faqTable = null;

    $(document).ready(function() {
        faqTable = $('#faqTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.faqs.data') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'question', name: 'question' },
                { data: 'category_badge', name: 'category' },
                { data: 'sort_order', name: 'sort_order', className: 'text-center' },
                { data: 'status_badge', name: 'is_active', className: 'text-center' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ],
            language: {
                search: "",
                searchPlaceholder: "Cari pertanyaan FAQ...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ FAQ",
                infoEmpty: "Data tidak ditemukan",
                zeroRecords: "Tidak ada data FAQ yang cocok",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "&rarr;",
                    previous: "&larr;"
                }
            }
        });
    });

    function deleteFaq(id) {
        Swal.fire({
            title: 'Hapus FAQ ini?',
            text: "Pertanyaan ini tidak akan lagi tampil di halaman beranda.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#64748B',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ url('admin/faqs') }}/" + id;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = "{{ csrf_token() }}";
                form.appendChild(csrfToken);

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endpush

@endsection
