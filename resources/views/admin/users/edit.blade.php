@extends('layouts.admin')

@section('title', 'Edit Pengguna Admin')
@section('header_title', 'Edit Admin: ' . $user->name)

@section('content')

<div class="admin-card" style="max-width: 600px;">
    <div class="card-header-flex">
        <h3>Edit Data Admin</h3>
        <a href="{{ route('admin.users.index') }}" class="btn-admin btn-admin-navy" style="font-size: 0.8125rem;">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Nama Lengkap Administrator *</label>
            <input type="text" name="name" required value="{{ old('name', $user->name) }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
        </div>

        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Email Login *</label>
            <input type="email" name="email" required value="{{ old('email', $user->email) }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
        </div>

        <div class="form-group" style="margin-bottom: 1.75rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Ubah Kata Sandi (Kosongkan jika tidak diubah)</label>
            <input type="password" name="password" placeholder="••••••••••••" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            <span style="font-size: 0.75rem; color: var(--admin-muted);">Minimal 8 karakter jika ingin mereset password admin ini.</span>
        </div>

        <button type="submit" class="btn-admin btn-admin-gold" style="padding: 0.85rem 2rem; font-size: 0.95rem;">
            <i class="fa-solid fa-floppy-disk"></i>
            <span>Perbarui Data Admin</span>
        </button>
    </form>
</div>

@endsection
