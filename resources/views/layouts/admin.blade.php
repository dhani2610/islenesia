<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') | {{ $siteSettings['site_name'] ?? 'Islenesia' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables CSS & JS (Bootstrap 5) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- Select2 (Searchable Select Dropdowns) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Summernote Rich Text Editor -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

    <!-- SweetAlert2 for polished confirmations -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --admin-navy-deep: #061124;
            --admin-navy-surface: #0B1B3D;
            --admin-navy-light: #132752;
            --admin-gold: #D4AF37;
            --admin-gold-hover: #F3DE8A;
            --admin-bg: #F1F5F9;
            --admin-card: #FFFFFF;
            --admin-text: #1E293B;
            --admin-muted: #64748B;
            --admin-border: #E2E8F0;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--admin-bg);
            color: var(--admin-text);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 270px;
            background: linear-gradient(180deg, #061124 0%, #0B1B3D 100%);
            color: #CBD5E1;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            border-right: 1px solid rgba(212, 175, 55, 0.2);
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-brand h3 {
            color: #FFFFFF;
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: 0.05em;
        }

        .sidebar-brand h3 span {
            color: var(--admin-gold);
        }

        .sidebar-menu {
            list-style: none;
            padding: 1.25rem 0.75rem;
            flex-grow: 1;
            overflow-y: auto;
        }

        .menu-header {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #64748B;
            padding: 0.75rem 0.75rem 0.35rem;
        }

        .menu-item a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.65rem 0.85rem;
            color: #CBD5E1;
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.2s ease;
            margin-bottom: 0.25rem;
        }

        .menu-item a:hover, .menu-item.active a {
            background: rgba(212, 175, 55, 0.15);
            color: var(--admin-gold-hover);
        }

        .menu-item.active a {
            background: var(--admin-gold);
            color: var(--admin-navy-deep);
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
        }

        .menu-item a .icon-wrap {
            width: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Main Content Wrapper */
        .admin-main {
            margin-left: 270px;
            flex-grow: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Bar */
        .admin-topbar {
            background: #FFFFFF;
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .topbar-title h2 {
            font-size: 1.35rem;
            color: var(--admin-navy-surface);
            font-weight: 700;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .btn-preview-site {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--admin-navy-surface);
            padding: 0.45rem 0.95rem;
            border: 1.5px solid var(--admin-border);
            border-radius: 9999px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-preview-site:hover {
            border-color: var(--admin-gold);
            color: var(--admin-gold);
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--admin-navy-surface);
            color: var(--admin-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
        }

        /* Content Body */
        .admin-content {
            padding: 2rem;
            flex-grow: 1;
        }

        /* Cards */
        .admin-card {
            background: #FFFFFF;
            border-radius: 16px;
            border: 1px solid var(--admin-border);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .card-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
            padding-bottom: 0.85rem;
            border-bottom: 1px solid var(--admin-border);
        }

        .card-header-flex h3 {
            font-size: 1.15rem;
            color: var(--admin-navy-surface);
            font-weight: 700;
        }

        /* Buttons */
        .btn-admin {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-admin-gold {
            background: linear-gradient(135deg, #F8E7A2 0%, #D4AF37 50%, #A67C1E 100%);
            color: var(--admin-navy-deep);
            box-shadow: 0 2px 8px rgba(212, 175, 55, 0.25);
        }

        .btn-admin-gold:hover {
            box-shadow: 0 4px 14px rgba(212, 175, 55, 0.4);
            transform: translateY(-1px);
        }

        .btn-admin-navy {
            background: var(--admin-navy-surface);
            color: #FFFFFF;
        }

        .btn-admin-navy:hover {
            background: var(--admin-navy-deep);
        }

        /* Badges & Tables Styling */
        .table-thumb {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--admin-border);
        }

        .table-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
        }

        .badge-custom {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.25rem 0.65rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-buyer {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .badge-petani {
            background: #D1FAE5;
            color: #065F46;
        }

        .badge-general {
            background: #F1F5F9;
            color: #475569;
        }

        .status-pill {
            display: inline-block;
            padding: 0.2rem 0.55rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .status-new {
            background: #FEF3C7;
            color: #92400E;
        }

        .status-contacted {
            background: #E0E7FF;
            color: #3730A3;
        }

        .status-deal {
            background: #DCFCE7;
            color: #166534;
        }

        .status-closed {
            background: #F1F5F9;
            color: #64748B;
        }

        .action-btn-group {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .table-btn-wa {
            background: #10B981;
            color: #FFFFFF;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-size: 0.775rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            border: none;
            cursor: pointer;
        }

        .table-btn-wa:hover {
            background: #059669;
        }

        .table-btn-edit {
            background: #3B82F6;
            color: #FFFFFF;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-size: 0.775rem;
            text-decoration: none;
            border: none;
        }

        .table-btn-del {
            background: #EF4444;
            color: #FFFFFF;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-size: 0.775rem;
            border: none;
            cursor: pointer;
        }

        /* Select2 Styling */
        .select2-container--classic .select2-selection--single,
        .select2-container--default .select2-selection--single {
            height: 42px !important;
            padding: 6px 10px !important;
            border: 1.5px solid var(--admin-border) !important;
            border-radius: 8px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }

        /* Alerts */
        .alert-box {
            padding: 1rem 1.25rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            font-size: 0.9rem;
        }

        .alert-success {
            background: #ECFDF5;
            border: 1px solid #10B981;
            color: #065F46;
        }

        .alert-danger {
            background: #FEF2F2;
            border: 1px solid #EF4444;
            color: #991B1B;
        }

        /* ========================================================
           SIDEBAR HAMBURGER & MOBILE RESPONSIVENESS
           ======================================================== */
        .sidebar-toggle-btn {
            display: none;
            background: #FFFFFF;
            border: 1.5px solid var(--admin-border);
            font-size: 1.1rem;
            color: var(--admin-navy-surface);
            cursor: pointer;
            padding: 0.45rem 0.75rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .sidebar-toggle-btn:hover {
            background: #F8FAFC;
            border-color: var(--admin-gold);
            color: var(--admin-gold);
        }

        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(6, 17, 36, 0.65);
            backdrop-filter: blur(4px);
            z-index: 95;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-backdrop.active {
            display: block;
            opacity: 1;
        }

        @media (max-width: 992px) {
            .sidebar-toggle-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .admin-sidebar {
                transform: translateX(-100%);
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.35);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .admin-sidebar.active {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0 !important;
                width: 100% !important;
            }

            .admin-topbar {
                padding: 0.85rem 1.25rem !important;
            }

            .admin-content {
                padding: 1.25rem !important;
            }
        }

        @media (max-width: 640px) {
            .admin-topbar {
                padding: 0.75rem 1rem !important;
            }

            .topbar-title h2 {
                font-size: 1.1rem !important;
            }

            .topbar-actions {
                gap: 0.65rem !important;
            }

            .btn-preview-site span {
                display: none !important;
            }

            .btn-preview-site {
                padding: 0.4rem 0.6rem !important;
            }

            .user-dropdown > div:last-child {
                display: none !important;
            }

            .admin-content {
                padding: 1rem 0.75rem !important;
            }

            .admin-card {
                padding: 1rem !important;
                border-radius: 12px !important;
            }

            .card-header-flex {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 0.85rem !important;
            }

            .card-header-flex .btn-admin {
                width: 100% !important;
                justify-content: center !important;
            }
        }

        /* ========================================================
           MODERN DATATABLES LUXURY DESIGN SYSTEM
           ======================================================== */
        .dataTables_wrapper {
            position: relative;
            clear: both;
            width: 100%;
        }

        /* Controls Row (Length & Search) */
        .dataTables_wrapper .row:first-child,
        .dataTables_wrapper > div:first-child {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            flex-wrap: wrap !important;
            gap: 1rem !important;
            margin-bottom: 1.25rem !important;
        }

        .dataTables_length {
            font-size: 0.85rem;
            color: var(--admin-muted);
            font-weight: 600;
        }

        .dataTables_length label {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            margin: 0;
            cursor: pointer;
        }

        .dataTables_length select,
        .dataTables_wrapper select.form-select,
        .dataTables_wrapper .dataTables_length select {
            padding: 0.45rem 2.2rem 0.45rem 0.85rem !important;
            border: 1.5px solid var(--admin-border) !important;
            border-radius: 8px !important;
            font-size: 0.85rem !important;
            font-weight: 600 !important;
            color: var(--admin-navy-surface) !important;
            background-color: #FFFFFF !important;
            outline: none !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 0.75rem center !important;
            background-size: 12px 10px !important;
            appearance: none !important;
            -webkit-appearance: none !important;
        }

        .dataTables_length select:focus {
            border-color: var(--admin-gold) !important;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.18) !important;
        }

        .dataTables_filter {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-left: auto;
        }

        .dataTables_filter label {
            position: relative;
            display: inline-flex;
            align-items: center;
            margin: 0;
            font-size: 0;
        }

        .dataTables_filter input,
        .dataTables_wrapper input.form-control,
        .dataTables_wrapper .dataTables_filter input {
            padding: 0.55rem 1rem 0.55rem 2.4rem !important;
            border: 1.5px solid var(--admin-border) !important;
            border-radius: 9999px !important;
            font-size: 0.85rem !important;
            font-weight: 500 !important;
            color: var(--admin-text) !important;
            background-color: #FFFFFF !important;
            outline: none !important;
            min-width: 260px !important;
            transition: all 0.2s ease !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'%3e%3cpath fill='%2394a3b8' d='M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0s208 93.1 208 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: left 0.85rem center !important;
            background-size: 14px 14px !important;
        }

        .dataTables_filter input:focus {
            border-color: var(--admin-gold) !important;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2) !important;
        }

        /* Clean Table Surface */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 12px;
            border: 1.5px solid var(--admin-border);
            background: #FFFFFF;
        }

        table.dataTable,
        table.table {
            width: 100% !important;
            margin: 0 !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            border: none !important;
        }

        table.dataTable thead th,
        table.table thead th {
            background: #F8FAFC !important;
            color: var(--admin-navy-surface) !important;
            font-size: 0.775rem !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            padding: 0.95rem 1rem !important;
            border-top: none !important;
            border-bottom: 1.5px solid var(--admin-border) !important;
            white-space: nowrap !important;
        }

        table.dataTable tbody td,
        table.table tbody td {
            padding: 0.95rem 1rem !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #F1F5F9 !important;
            border-top: none !important;
            color: var(--admin-text) !important;
            font-size: 0.875rem !important;
            background: #FFFFFF !important;
            transition: background 0.15s ease;
        }

        table.dataTable tbody tr:hover td,
        table.table tbody tr:hover td {
            background-color: #F8FAFC !important;
        }

        table.dataTable tbody tr:last-child td,
        table.table tbody tr:last-child td {
            border-bottom: none !important;
        }

        /* Bottom Controls (Info & Paginate) */
        .dataTables_wrapper .row:last-child,
        .dataTables_wrapper > div:last-child {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            flex-wrap: wrap !important;
            gap: 1rem !important;
            margin-top: 1.25rem !important;
            padding-top: 1rem !important;
            border-top: 1px solid var(--admin-border) !important;
        }

        .dataTables_info {
            font-size: 0.825rem !important;
            color: var(--admin-muted) !important;
            font-weight: 600 !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Fix Pagination: RESET BULLET POINTS */
        .dataTables_paginate {
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .dataTables_paginate ul,
        .dataTables_paginate ul.pagination {
            list-style: none !important;
            list-style-type: none !important;
            display: flex !important;
            align-items: center !important;
            gap: 0.35rem !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .dataTables_paginate ul li,
        .dataTables_paginate ul.pagination li,
        .dataTables_paginate li.page-item {
            list-style: none !important;
            list-style-type: none !important;
            margin: 0 !important;
            padding: 0 !important;
            display: inline-block !important;
        }

        .dataTables_paginate ul li::before,
        .dataTables_paginate ul li::marker {
            display: none !important;
            content: "" !important;
        }

        .dataTables_paginate a.page-link,
        .dataTables_paginate .paginate_button,
        .dataTables_paginate span.paginate_button {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 36px !important;
            height: 36px !important;
            padding: 0 0.65rem !important;
            border-radius: 8px !important;
            border: 1.5px solid var(--admin-border) !important;
            background: #FFFFFF !important;
            color: var(--admin-navy-surface) !important;
            font-size: 0.825rem !important;
            font-weight: 600 !important;
            text-decoration: none !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            user-select: none !important;
        }

        .dataTables_paginate ul li.active a.page-link,
        .dataTables_paginate .paginate_button.current,
        .dataTables_paginate .paginate_button.active {
            background: var(--admin-navy-surface) !important;
            border-color: var(--admin-navy-surface) !important;
            color: #FFFFFF !important;
            font-weight: 700 !important;
            box-shadow: 0 2px 8px rgba(11, 27, 61, 0.25) !important;
        }

        .dataTables_paginate ul li:not(.active):not(.disabled) a.page-link:hover,
        .dataTables_paginate .paginate_button:not(.current):not(.disabled):hover {
            background: #F1F5F9 !important;
            border-color: var(--admin-gold) !important;
            color: var(--admin-gold) !important;
        }

        .dataTables_paginate ul li.disabled a.page-link,
        .dataTables_paginate .paginate_button.disabled {
            opacity: 0.35 !important;
            cursor: not-allowed !important;
            pointer-events: none !important;
            background: #F8FAFC !important;
            border-color: var(--admin-border) !important;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar Navigation -->
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <i class="fa-solid fa-earth-americas text-gold" style="font-size: 1.5rem; color: var(--admin-gold);"></i>
            <h3>ISLE<span>NESIA</span></h3>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <div style="display:flex; align-items:center; gap:0.6rem;">
                        <span class="icon-wrap"><i class="fa-solid fa-chart-pie"></i></span>
                        <span>Ringkasan</span>
                    </div>
                </a>
            </li>

            <li class="menu-header">Leads Agregator</li>
            <li class="menu-item {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">
                <a href="{{ route('admin.inquiries.index') }}">
                    <div style="display:flex; align-items:center; gap:0.6rem;">
                        <span class="icon-wrap"><i class="fa-solid fa-comments"></i></span>
                        <span>Leads (Buyer & Pemasok)</span>
                    </div>
                </a>
            </li>

            <li class="menu-header">Katalog & Konten CMS</li>
            <li class="menu-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <a href="{{ route('admin.products.index') }}">
                    <div style="display:flex; align-items:center; gap:0.6rem;">
                        <span class="icon-wrap"><i class="fa-solid fa-boxes-stacked"></i></span>
                        <span>Komoditas Produk</span>
                    </div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <a href="{{ route('admin.categories.index') }}">
                    <div style="display:flex; align-items:center; gap:0.6rem;">
                        <span class="icon-wrap"><i class="fa-solid fa-tags"></i></span>
                        <span>Kategori Katalog</span>
                    </div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                <a href="{{ route('admin.posts.index') }}">
                    <div style="display:flex; align-items:center; gap:0.6rem;">
                        <span class="icon-wrap"><i class="fa-solid fa-newspaper"></i></span>
                        <span>Artikel Blog</span>
                    </div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
                <a href="{{ route('admin.comments.index') }}">
                    <div style="display:flex; align-items:center; gap:0.6rem;">
                        <span class="icon-wrap"><i class="fa-solid fa-comment-dots"></i></span>
                        <span>Moderasi Komentar</span>
                    </div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                <a href="{{ route('admin.testimonials.index') }}">
                    <div style="display:flex; align-items:center; gap:0.6rem;">
                        <span class="icon-wrap"><i class="fa-solid fa-star"></i></span>
                        <span>Testimoni Buyer</span>
                    </div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                <a href="{{ route('admin.faqs.index') }}">
                    <div style="display:flex; align-items:center; gap:0.6rem;">
                        <span class="icon-wrap"><i class="fa-solid fa-circle-question"></i></span>
                        <span>Kelola FAQ & Tanya Jawab</span>
                    </div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                <a href="{{ route('admin.sliders.index') }}">
                    <div style="display:flex; align-items:center; gap:0.6rem;">
                        <span class="icon-wrap"><i class="fa-solid fa-images"></i></span>
                        <span>Hero Slider Beranda</span>
                    </div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                <a href="{{ route('admin.clients.index') }}">
                    <div style="display:flex; align-items:center; gap:0.6rem;">
                        <span class="icon-wrap"><i class="fa-solid fa-handshake"></i></span>
                        <span>Klien Kami (Our Clients)</span>
                    </div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
                <a href="{{ route('admin.partners.index') }}">
                    <div style="display:flex; align-items:center; gap:0.6rem;">
                        <span class="icon-wrap"><i class="fa-solid fa-building-shield"></i></span>
                        <span>Partner & Mitra (Our Partners)</span>
                    </div>
                </a>
            </li>

            <li class="menu-header">Sistem & SEO</li>
            <li class="menu-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <a href="{{ route('admin.settings.index') }}">
                    <div style="display:flex; align-items:center; gap:0.6rem;">
                        <span class="icon-wrap"><i class="fa-solid fa-sliders"></i></span>
                        <span>Pengaturan & SEO</span>
                    </div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}">
                    <div style="display:flex; align-items:center; gap:0.6rem;">
                        <span class="icon-wrap"><i class="fa-solid fa-users-gear"></i></span>
                        <span>Kelola Admin</span>
                    </div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                <a href="{{ route('admin.profile.edit') }}">
                    <div style="display:flex; align-items:center; gap:0.6rem;">
                        <span class="icon-wrap"><i class="fa-solid fa-user-shield"></i></span>
                        <span>Profil & Keamanan</span>
                    </div>
                </a>
            </li>

            <li class="menu-header">Bantuan & Dokumen</li>
            <li class="menu-item {{ request()->routeIs('admin.manual-book.*') ? 'active' : '' }}">
                <a href="{{ route('admin.manual-book.index') }}">
                    <div style="display:flex; align-items:center; gap:0.6rem;">
                        <span class="icon-wrap"><i class="fa-solid fa-book-bookmark"></i></span>
                        <span>Buku Panduan (Manual)</span>
                    </div>
                    <span style="font-size:0.68rem; background:rgba(212,175,55,0.2); color:var(--admin-gold); padding:2px 7px; border-radius:999px; font-weight:700;">DOCS</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <span style="font-size: 0.75rem; color: #64748B;">Admin Portal</span>
            <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="background: none; border: none; color: #EF4444; cursor: pointer; font-size: 0.85rem;" title="Logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Mobile Off-Canvas Backdrop -->
    <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="toggleSidebar()"></div>

    <!-- Main Content -->
    <div class="admin-main">
        <header class="admin-topbar">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <button type="button" class="sidebar-toggle-btn" onclick="toggleSidebar()" aria-label="Toggle Sidebar">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="topbar-title">
                    <h2>@yield('header_title', 'Dashboard')</h2>
                </div>
            </div>

            <div class="topbar-actions">
                <a href="{{ route('home') }}" target="_blank" class="btn-preview-site">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>Lihat Web Compro</span>
                </a>

                <div class="user-dropdown">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 700; color: var(--admin-navy-surface);">
                            {{ Auth::user()->name ?? 'Admin' }}
                        </div>
                        <div style="font-size: 0.725rem; color: var(--admin-muted);">Administrator</div>
                    </div>
                </div>
            </div>
        </header>

        <main class="admin-content">
            @if(session('success'))
                <div class="alert-box alert-success" id="adminFlashAlert" style="display:flex; align-items:center; justify-content:space-between;">
                    <div style="display:flex; align-items:center; gap:0.6rem;">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.closest('.alert-box').remove()" style="background:none; border:none; color:inherit; font-size:1.25rem; line-height:1; cursor:pointer; opacity:0.75; padding:0 0.35rem;" title="Tutup">&times;</button>
                </div>
                <script>
                    setTimeout(function() {
                        var el = document.getElementById('adminFlashAlert');
                        if (el) {
                            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                            el.style.opacity = '0';
                            el.style.transform = 'translateY(-6px)';
                            setTimeout(function() { if (el) el.remove(); }, 500);
                        }
                    }, 4000);
                </script>
            @endif

            @if(session('error'))
                <div class="alert-box alert-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert-box alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div>
                        <ul style="margin-left: 1rem;">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Global Mobile Sidebar & Select2 Scripts -->
    <script>
        function toggleSidebar() {
            var sidebar = document.querySelector('.admin-sidebar');
            var backdrop = document.getElementById('sidebarBackdrop');
            if (sidebar) sidebar.classList.toggle('active');
            if (backdrop) backdrop.classList.toggle('active');
        }

        $(document).ready(function() {
            $('select').not('.no-select2, .dataTables_length select, [name$="_length"]').select2({
                width: '100%'
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
