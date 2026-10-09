@extends('layouts.admin')

@section('title', 'Profil & Keamanan Akun')
@section('header_title', 'Pengaturan Akun & Keamanan')

@section('content')

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
    <!-- Profile Info Form -->
    <div class="admin-card">
        <div class="card-header-flex">
            <div>
                <h3>Informasi Profil Admin</h3>
                <p style="font-size: 0.8125rem; color: var(--admin-muted);">Perbarui nama dan alamat email login akun Anda.</p>
            </div>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Nama Lengkap *</label>
                <input type="text" name="name" required value="{{ old('name', $user->name) }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            </div>

            <div class="form-group" style="margin-bottom: 1.75rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Email Login *</label>
                <input type="email" name="email" required value="{{ old('email', $user->email) }}" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            </div>

            <button type="submit" class="btn-admin btn-admin-gold" style="padding: 0.75rem 1.75rem;">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Simpan Perubahan Profil</span>
            </button>
        </form>
    </div>

    <!-- Password Update Form -->
    <div class="admin-card">
        <div class="card-header-flex">
            <div>
                <h3>Ubah Kata Sandi (Password)</h3>
                <p style="font-size: 0.8125rem; color: var(--admin-muted);">Pastikan kata sandi Anda kuat untuk mencegah akses tidak sah.</p>
            </div>
        </div>

        <form action="{{ route('admin.profile.password') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Kata Sandi Saat Ini *</label>
                <input type="password" name="current_password" required placeholder="••••••••••••" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            </div>

            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Kata Sandi Baru *</label>
                <input type="password" name="password" required placeholder="Minimal 8 karakter" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            </div>

            <div class="form-group" style="margin-bottom: 1.75rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface); margin-bottom: 0.4rem;">Konfirmasi Kata Sandi Baru *</label>
                <input type="password" name="password_confirmation" required placeholder="Ulangi kata sandi baru" class="form-input" style="width: 100%; padding: 0.75rem; border: 1.5px solid var(--admin-border); border-radius: 8px;">
            </div>

            <button type="submit" class="btn-admin btn-admin-navy" style="padding: 0.75rem 1.75rem;">
                <i class="fa-solid fa-key"></i>
                <span>Perbarui Kata Sandi</span>
            </button>
        </form>
    </div>
</div>

@endsection
