@extends('layouts.admin')

@section('title', 'Dashboard Ringkasan')
@section('header_title', 'Ringkasan & Metrik Agregator')

@section('content')

<!-- Stat Metrics Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;">
    <!-- Inquiries / Leads Card -->
    <div class="admin-card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
            <div>
                <span style="font-size: 0.8125rem; color: var(--admin-muted); font-weight: 600;">Total Leads Masuk</span>
                <h3 style="font-size: 2rem; color: var(--admin-navy-surface); font-weight: 800; margin-top: 0.25rem;">{{ $stats['total_inquiries'] }}</h3>
            </div>
            <div style="width: 44px; height: 44px; background: rgba(16, 185, 129, 0.15); color: #059669; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                <i class="fa-solid fa-comments"></i>
            </div>
        </div>
        <div style="display: flex; gap: 0.5rem; font-size: 0.75rem;">
            <span class="badge-custom badge-buyer"><i class="fa-solid fa-box"></i> {{ $stats['buyer_inquiries'] }} Buyer</span>
            <span class="badge-custom badge-petani"><i class="fa-solid fa-seedling"></i> {{ $stats['petani_inquiries'] }} Petani</span>
        </div>
    </div>

    <!-- Products Card -->
    <div class="admin-card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
            <div>
                <span style="font-size: 0.8125rem; color: var(--admin-muted); font-weight: 600;">Katalog Produk</span>
                <h3 style="font-size: 2rem; color: var(--admin-navy-surface); font-weight: 800; margin-top: 0.25rem;">{{ $stats['total_products'] }}</h3>
            </div>
            <div style="width: 44px; height: 44px; background: rgba(59, 130, 246, 0.15); color: #2563EB; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
        </div>
        <a href="{{ route('admin.products.index') }}" style="font-size: 0.775rem; color: #2563EB; font-weight: 600; text-decoration: none;">Kelola Komoditas &rarr;</a>
    </div>

    <!-- Posts Card -->
    <div class="admin-card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
            <div>
                <span style="font-size: 0.8125rem; color: var(--admin-muted); font-weight: 600;">Artikel & Berita</span>
                <h3 style="font-size: 2rem; color: var(--admin-navy-surface); font-weight: 800; margin-top: 0.25rem;">{{ $stats['total_posts'] }}</h3>
            </div>
            <div style="width: 44px; height: 44px; background: rgba(212, 175, 55, 0.15); color: var(--admin-gold); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                <i class="fa-solid fa-newspaper"></i>
            </div>
        </div>
        <a href="{{ route('admin.posts.index') }}" style="font-size: 0.775rem; color: var(--admin-navy-surface); font-weight: 600; text-decoration: none;">Kelola Artikel &rarr;</a>
    </div>

    <!-- Pending Comments Card -->
    <div class="admin-card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
            <div>
                <span style="font-size: 0.8125rem; color: var(--admin-muted); font-weight: 600;">Komentar Tertunda</span>
                <h3 style="font-size: 2rem; color: var(--admin-navy-surface); font-weight: 800; margin-top: 0.25rem;">{{ $stats['pending_comments'] }}</h3>
            </div>
            <div style="width: 44px; height: 44px; background: rgba(245, 158, 11, 0.15); color: #D97706; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                <i class="fa-solid fa-comment-dots"></i>
            </div>
        </div>
        <a href="{{ route('admin.comments.index') }}" style="font-size: 0.775rem; color: #D97706; font-weight: 600; text-decoration: none;">Tinjau Komentar &rarr;</a>
    </div>
</div>

<!-- Recent Leads Table -->
<div class="admin-card">
    <div class="card-header-flex">
        <div>
            <h3>Leads Masuk Terbaru (Widget WhatsApp & Formulir)</h3>
            <p style="font-size: 0.8125rem; color: var(--admin-muted); margin-top: 0.25rem;">Setiap inquiry langsung tercatat otomatis di sistem agregator.</p>
        </div>
        <a href="{{ route('admin.inquiries.index') }}" class="btn-admin btn-admin-gold" style="font-size: 0.8125rem; padding: 0.4rem 0.85rem;">
            <span>Lihat Semua Leads</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
            <thead>
                <tr style="background: #F8FAFC; border-bottom: 2px solid var(--admin-border); text-align: left;">
                    <th style="padding: 0.85rem 1rem;">Peran</th>
                    <th style="padding: 0.85rem 1rem;">Nama / Perusahaan</th>
                    <th style="padding: 0.85rem 1rem;">Nomor WhatsApp</th>
                    <th style="padding: 0.85rem 1rem;">Pesan / Kebutuhan</th>
                    <th style="padding: 0.85rem 1rem;">Status</th>
                    <th style="padding: 0.85rem 1rem; text-align: right;">Aksi Cepat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentInquiries as $inq)
                    <tr style="border-bottom: 1px solid var(--admin-border);">
                        <td style="padding: 0.85rem 1rem;">
                            @if($inq->type === 'buyer')
                                <span class="badge-custom badge-buyer"><i class="fa-solid fa-box"></i> Buyer</span>
                            @elseif($inq->type === 'petani')
                                <span class="badge-custom badge-petani"><i class="fa-solid fa-seedling"></i> Petani</span>
                            @else
                                <span class="badge-custom badge-general">Umum</span>
                            @endif
                        </td>
                        <td style="padding: 0.85rem 1rem; font-weight: 600; color: var(--admin-navy-surface);">
                            {{ $inq->name }}
                        </td>
                        <td style="padding: 0.85rem 1rem;">
                            {{ $inq->whatsapp }}
                        </td>
                        <td style="padding: 0.85rem 1rem; color: var(--admin-muted); max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $inq->message }}
                        </td>
                        <td style="padding: 0.85rem 1rem;">
                            <span class="status-pill status-{{ $inq->status }}">{{ ucfirst($inq->status) }}</span>
                        </td>
                        <td style="padding: 0.85rem 1rem; text-align: right;">
                            @php
                                $phone = preg_replace('/[^0-9]/', '', $inq->whatsapp);
                            @endphp
                            <a href="https://wa.me/{{ $phone }}" target="_blank" class="table-btn-wa" title="Buka WhatsApp">
                                <i class="fa-brands fa-whatsapp"></i> Chat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 2rem; text-align: center; color: var(--admin-muted);">
                            Belum ada leads masuk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
