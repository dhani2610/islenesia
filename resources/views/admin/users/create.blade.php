@extends('layouts.admin')

@section('title', 'Tambah Admin Baru')
@section('header_title', 'Tambah Pengguna Administrator')

@section('content')

<div class="admin-card" style="max-width: 600px;">
    <div class="card-header-flex">
        <h3>Formulir Admin Baru</h3>
        <a href="{{ route('admin.users.index') }}" class="btn-admin btn-admin-navy" style="font-size: 0.8125rem;">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Nama Lengkap Administrator *</label>
            <input type="text" name="name" required value="{{ old('name') }}" placeholder="Contoh: Bpk Hendra / Staff Ekspor" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
        </div>

        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Email Login *</label>
            <input type="email" name="email" required value="{{ old('email') }}" placeholder="admin@domain.com" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
        </div>

        <div class="form-group" style="margin-bottom: 1.75rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Kata Sandi (Minimal 8 Karakter) *</label>
            <input type="password" name="password" required placeholder="••••••••••••" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
        </div>

        <button type="submit" class="btn-admin btn-admin-gold" style="padding: 0.85rem 2rem; font-size: 0.95rem;">
            <i class="fa-solid fa-user-plus"></i>
            <span>Simpan Admin Baru</span>
        </button>
    </form>
</div>

@endsection
