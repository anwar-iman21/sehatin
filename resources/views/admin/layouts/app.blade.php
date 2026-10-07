<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SEHATIN</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --green-50:#f0fdf4;--green-100:#dcfce7;--green-200:#bbf7d0;
            --green-500:#22c55e;--green-600:#16a34a;--green-700:#15803d;
            --slate-50:#f8fafc;--slate-100:#f1f5f9;--slate-200:#e2e8f0;
            --slate-300:#cbd5e1;--slate-400:#94a3b8;--slate-500:#64748b;
            --slate-600:#475569;--slate-700:#334155;--slate-800:#1e293b;--slate-900:#0f172a;
            --white:#ffffff;--radius:.75rem;
            --sidebar:240px;
        }
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--slate-100);color:var(--slate-800);min-height:100vh;display:flex}
        a{text-decoration:none;color:inherit}
        img{max-width:100%;display:block}

        /* ── SIDEBAR ── */
        .sidebar{
            width:var(--sidebar);flex-shrink:0;
            background:var(--slate-900);
            display:flex;flex-direction:column;
            position:fixed;top:0;left:0;height:100vh;
            overflow-y:auto;z-index:50;
            transition:transform .25s;
        }
        .sidebar-logo{
            padding:1.25rem 1.5rem;
            display:flex;align-items:center;gap:.6rem;
            font-weight:700;font-size:1.25rem;color:var(--white);
            border-bottom:1px solid rgba(255,255,255,.08);
        }
        .sidebar-logo .brand-word{color:var(--green-400)}
        .sidebar-logo em{font-style:normal;color:var(--white)}
        .sidebar-nav{flex:1;padding:1rem 0}
        .nav-section-label{
            padding:.5rem 1.5rem;
            font-size:.7rem;font-weight:700;letter-spacing:.1em;
            color:var(--slate-500);text-transform:uppercase;margin-top:.75rem;
        }
        .nav-item{
            display:flex;align-items:center;gap:.75rem;
            padding:.65rem 1.5rem;
            font-size:.875rem;font-weight:500;
            color:var(--slate-400);
            transition:all .15s;
            border-left:3px solid transparent;
        }
        .nav-item:hover{color:var(--white);background:rgba(255,255,255,.05)}
        .nav-item.active{color:var(--white);background:rgba(255,255,255,.08);border-left-color:var(--green-500)}
        .nav-item i{width:18px;text-align:center;font-size:.9rem;flex-shrink:0}
        .sidebar-footer{
            padding:1rem 1.5rem;
            border-top:1px solid rgba(255,255,255,.08);
            font-size:.8rem;color:var(--slate-500);
        }

        /* ── MAIN ── */
        .admin-main{
            margin-left:var(--sidebar);
            flex:1;display:flex;flex-direction:column;
            min-height:100vh;
        }

        /* ── TOPBAR ── */
        .topbar{
            background:var(--white);
            border-bottom:1px solid var(--slate-200);
            padding:.9rem 2rem;
            display:flex;align-items:center;justify-content:space-between;
            position:sticky;top:0;z-index:40;
            gap:1rem;
        }
        .topbar-title{font-size:1.1rem;font-weight:700;color:var(--slate-800)}
        .topbar-right{display:flex;align-items:center;gap:1rem}
        .lang-switcher{
            display:flex;align-items:center;gap:.55rem;
            font-size:.85rem;color:var(--slate-500);
        }
        .lang-toggle{
            position:relative;
            display:grid;
            grid-template-columns:repeat(2,2.4rem);
            padding:3px;
            border:1px solid var(--slate-200);
            border-radius:999px;
            background:var(--slate-100);
            box-shadow:inset 0 1px 2px rgba(15,23,42,.08);
        }
        .lang-toggle::before{
            content:"";
            position:absolute;
            top:3px;
            bottom:3px;
            left:3px;
            width:calc((100% - 6px) / 2);
            border-radius:999px;
            background:var(--green-600);
            box-shadow:0 2px 6px rgba(21,128,61,.25);
            transition:transform .25s cubic-bezier(.2,.8,.2,1),background-color .2s ease;
            pointer-events:none;
        }
        .lang-toggle[data-locale="en"]::before{transform:translateX(100%)}
        .lang-option{
            position:relative;
            z-index:1;
            display:flex;
            align-items:center;
            justify-content:center;
            min-height:1.65rem;
            border-radius:999px;
            font-size:.72rem;
            font-weight:700;
            color:var(--slate-600);
            transition:color .2s ease,transform .2s ease;
        }
        .lang-option.active{color:var(--white)}
        .lang-option:not(.active):hover{color:var(--green-700);transform:scale(1.08)}
        .lang-toggle:has(.lang-option--id:hover,.lang-option--id:focus-visible)::before{transform:translateX(0)}
        .lang-toggle:has(.lang-option--en:hover,.lang-option--en:focus-visible)::before{transform:translateX(100%)}
        .lang-option:focus-visible{outline:2px solid var(--green-700);outline-offset:3px}
        .admin-avatar{
            width:36px;height:36px;border-radius:50%;
            background:var(--green-600);color:white;
            display:flex;align-items:center;justify-content:center;
            font-weight:700;font-size:.875rem;object-fit:cover;flex-shrink:0;
        }
        .topbar-user{font-size:.875rem;color:var(--slate-600);font-weight:500}
        .topbar-toggle{display:none;background:none;border:none;cursor:pointer;padding:.25rem;color:var(--slate-700)}

        /* ── CONTENT ── */
        .admin-content{padding:2rem;flex:1}
        .page-title{font-size:1.35rem;font-weight:700;color:var(--slate-800);margin-bottom:1.5rem}

        /* ── CARDS / WIDGETS ── */
        .stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.25rem;margin-bottom:2rem}
        .stat-card{
            background:var(--white);border-radius:var(--radius);
            padding:1.5rem;display:flex;align-items:center;gap:1rem;
            border:1px solid var(--slate-200);
        }
        .stat-icon{
            width:48px;height:48px;border-radius:.75rem;
            display:flex;align-items:center;justify-content:center;
            font-size:1.25rem;flex-shrink:0;
        }
        .stat-value{font-size:1.75rem;font-weight:700;color:var(--slate-900);line-height:1}
        .stat-label{font-size:.8rem;color:var(--slate-500);margin-top:.3rem}

        /* ── TABLE ── */
        .table-card{background:var(--white);border-radius:var(--radius);border:1px solid var(--slate-200);overflow:hidden}
        .table-header{
            display:flex;align-items:center;justify-content:space-between;
            padding:1.25rem 1.5rem;border-bottom:1px solid var(--slate-200);gap:1rem;flex-wrap:wrap;
        }
        .table-header h3{font-size:1rem;font-weight:700;color:var(--slate-800)}
        table{width:100%;border-collapse:collapse}
        th{padding:.75rem 1rem;text-align:left;font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--slate-500);background:var(--slate-50);border-bottom:1px solid var(--slate-200)}
        td{padding:.85rem 1rem;font-size:.875rem;color:var(--slate-700);border-bottom:1px solid var(--slate-100);vertical-align:middle}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:var(--slate-50)}
        .td-actions{display:flex;align-items:center;gap:.4rem;flex-wrap:nowrap;white-space:nowrap}
        .td-actions form{flex-shrink:0}

        /* ── FORM ── */
        .form-card{background:var(--white);border-radius:var(--radius);border:1px solid var(--slate-200);padding:2rem}
        .form-group{margin-bottom:1.25rem}
        .form-label{display:block;font-size:.875rem;font-weight:600;color:var(--slate-700);margin-bottom:.4rem}
        .form-hint{font-size:.78rem;color:var(--slate-400);margin-top:.3rem}
        .form-control{
            width:100%;padding:.65rem .9rem;
            border:1.5px solid var(--slate-200);border-radius:.55rem;
            font-size:.9rem;font-family:inherit;outline:none;
            transition:border .15s;background:var(--white);color:var(--slate-800);
        }
        .form-control:focus{border-color:var(--green-500)}
        textarea.form-control{resize:vertical;min-height:140px}
        select.form-control{cursor:pointer}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:1.25rem}
        .form-check{display:flex;align-items:center;gap:.5rem;cursor:pointer;font-size:.875rem;color:var(--slate-700)}
        .form-check input{accent-color:var(--green-600);width:16px;height:16px}
        .form-actions{display:flex;align-items:center;gap:.75rem;margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--slate-200)}

        /* ── BUTTONS ── */
        .btn{display:inline-flex;align-items:center;gap:.4rem;padding:.5rem 1.1rem;border-radius:.55rem;font-size:.875rem;font-weight:600;transition:all .15s;cursor:pointer;border:none;font-family:inherit}
        .btn-primary{background:var(--green-600);color:var(--white)}
        .btn-primary:hover{background:var(--green-700)}
        .btn-secondary{background:var(--slate-600);color:var(--white)}
        .btn-secondary:hover{background:var(--slate-700)}
        .btn-outline{background:transparent;color:var(--slate-700);border:1.5px solid var(--slate-300)}
        .btn-outline:hover{background:var(--slate-50)}
        .btn-danger{background:#dc2626;color:var(--white)}
        .btn-danger:hover{background:#b91c1c}
        .btn-warning{background:#d97706;color:var(--white)}
        .btn-warning:hover{background:#b45309}
        .btn-success{background:var(--green-600);color:var(--white)}
        .btn-sm{padding:.35rem .75rem;font-size:.8rem}
        .btn-xs{padding:.25rem .55rem;font-size:.75rem}

        /* ── BADGES ── */
        .badge{display:inline-flex;align-items:center;gap:.3rem;padding:.25rem .65rem;border-radius:999px;font-size:.75rem;font-weight:600}
        .badge-green{background:var(--green-100);color:var(--green-700)}
        .badge-gray{background:var(--slate-100);color:var(--slate-600)}
        .badge-red{background:#fee2e2;color:#991b1b}

        /* ── ALERTS ── */
        .alert{padding:.85rem 1.1rem;border-radius:.6rem;font-size:.875rem;margin-bottom:1.25rem;display:flex;align-items:flex-start;gap:.6rem}
        .alert-success{background:var(--green-50);color:#166534;border:1px solid var(--green-200)}
        .alert-error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}

        /* ── THUMBNAIL PREVIEW ── */
        .thumb-preview{width:80px;height:60px;border-radius:.4rem;object-fit:cover;border:1px solid var(--slate-200)}

        /* ── PAGINATION ── */
        .pagination-wrap{padding:1rem 1.5rem;border-top:1px solid var(--slate-200);display:flex;justify-content:flex-end}

        /* ── MOBILE ── */
        @media(max-width:1024px){.stat-grid{grid-template-columns:repeat(2,1fr)}}
        @media(max-width:768px){
            .sidebar{transform:translateX(-100%)}
            .sidebar.open{transform:translateX(0)}
            .admin-main{margin-left:0}
            .topbar-toggle{display:block}
            .stat-grid{grid-template-columns:1fr 1fr}
            .form-row{grid-template-columns:1fr}
            .admin-content{padding:1.25rem}
        }
        @media(max-width:480px){.stat-grid{grid-template-columns:1fr}}
        @media(prefers-reduced-motion:reduce){
            .lang-toggle::before,.lang-option{transition-duration:.01ms!important}
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar" id="adminSidebar">
    <div class="sidebar-logo">
        <i class="fas fa-leaf" style="color:var(--green-400)"></i>
        <span class="brand-word">SEHAT<em>IN</em></span>
        <span style="font-size:.7rem;background:rgba(255,255,255,.12);padding:.2rem .5rem;border-radius:.3rem;margin-left:auto;color:var(--slate-400)">Admin</span>
    </div>

    <nav class="sidebar-nav">
        <p class="nav-section-label">Utama</p>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> {{ __('admin.dashboard') }}
        </a>

        <p class="nav-section-label">Konten</p>
        <a href="{{ route('admin.artikel.index') }}" class="nav-item {{ request()->routeIs('admin.artikel.*') ? 'active' : '' }}">
            <i class="fas fa-newspaper"></i> {{ __('admin.articles') }}
        </a>
        <a href="{{ route('admin.kategori.index') }}" class="nav-item {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
            <i class="fas fa-tags"></i> {{ __('admin.categories') }}
        </a>
        <a href="{{ route('admin.layanan.index') }}" class="nav-item {{ request()->routeIs('admin.layanan.*') ? 'active' : '' }}">
            <i class="fas fa-stethoscope"></i> {{ __('admin.services') }}
        </a>
        <a href="{{ route('admin.faq.index') }}" class="nav-item {{ request()->routeIs('admin.faq.*') ? 'active' : '' }}">
            <i class="fas fa-question-circle"></i> {{ __('admin.faqs') }}
        </a>
        <a href="{{ route('admin.halaman.index') }}" class="nav-item {{ request()->routeIs('admin.halaman.*') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i> {{ __('admin.pages') }}
        </a>
        <a href="{{ route('admin.obat.index') }}" class="nav-item {{ request()->routeIs('admin.obat.*') ? 'active' : '' }}">
            <i class="fas fa-pills"></i> Info Obat
        </a>
        <a href="{{ route('admin.penyakit.index') }}" class="nav-item {{ request()->routeIs('admin.penyakit.*') ? 'active' : '' }}">
            <i class="fas fa-virus"></i> Info Penyakit
        </a>
        <a href="{{ route('admin.panduan.index') }}" class="nav-item {{ request()->routeIs('admin.panduan.*') ? 'active' : '' }}">
            <i class="fas fa-book-medical"></i> Panduan Kesehatan
        </a>

        <p class="nav-section-label">Lainnya</p>
        <a href="{{ route('admin.profile.index') }}" class="nav-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
            <i class="fas fa-user"></i> Profil Saya
        </a>
        <a href="{{ route('home') }}" target="_blank" class="nav-item">
            <i class="fas fa-external-link-alt"></i> Lihat Website
        </a>
    </nav>

    <div class="sidebar-footer">
        <p style="color:var(--slate-400);font-size:.78rem">Login sebagai</p>
        <p style="color:var(--white);font-weight:600;font-size:.875rem;margin-top:.2rem">{{ auth()->user()->name }}</p>
        <form action="{{ route('logout') }}" method="POST" style="margin-top:.75rem">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger" style="width:100%;justify-content:center">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </button>
        </form>
    </div>
</aside>

{{-- MAIN --}}
<div class="admin-main">
    <header class="topbar">
        <div style="display:flex;align-items:center;gap:1rem">
            <button class="topbar-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
        </div>
        <div class="topbar-right">
            <div class="lang-switcher" role="group" aria-label="{{ __('app.language') }}">
                <i class="fas fa-globe"></i>
                <div class="lang-toggle" data-locale="{{ app()->getLocale() }}">
                    <a href="{{ route('lang.switch', 'id') }}"
                       class="lang-option lang-option--id {{ app()->getLocale() === 'id' ? 'active' : '' }}"
                       aria-current="{{ app()->getLocale() === 'id' ? 'true' : 'false' }}">ID</a>
                    <a href="{{ route('lang.switch', 'en') }}"
                       class="lang-option lang-option--en {{ app()->getLocale() === 'en' ? 'active' : '' }}"
                       aria-current="{{ app()->getLocale() === 'en' ? 'true' : 'false' }}">EN</a>
                </div>
            </div>
            @if(auth()->user()->avatar)
                <img
                    class="admin-avatar"
                    src="{{ \Illuminate\Support\Str::startsWith(auth()->user()->avatar, ['http://', 'https://']) ? auth()->user()->avatar : asset('storage/'.auth()->user()->avatar) }}"
                    alt="Avatar {{ auth()->user()->name }}"
                >
            @else
                <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            @endif
            <span class="topbar-user">{{ auth()->user()->name }}</span>
        </div>
    </header>

    <main class="admin-content">
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</div>

<script>
    const toggle  = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('adminSidebar');
    if(toggle) toggle.addEventListener('click', () => sidebar.classList.toggle('open'));

    // Delete confirmation
    document.querySelectorAll('.btn-delete-confirm').forEach(btn => {
        btn.addEventListener('click', function(e){
            if(!confirm('{{ __("admin.confirm_delete") }}')) e.preventDefault();
        });
    });
</script>
@stack('scripts')
</body>
</html>
