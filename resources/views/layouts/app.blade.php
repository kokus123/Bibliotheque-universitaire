<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.svg.svg') }}">
    <title>@yield('title', 'Bibliotheque Universitaire')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        /* LIGHT MODE */
        :root, [data-theme="light"] {
            --navy:        #0f1f2e;
            --navy-mid:    #162840;
            --navy-light:  #1e3a54;
            --gold:        #c9a84c;
            --gold-light:  #e2c47a;
            --gold-pale:   #f5ecd4;
            --cream:       #faf8f4;
            --white:       #ffffff;
            --text:        #1a1a2e;
            --text-muted:  #64748b;
            --border:      #e8e4dc;
            --shadow-sm:   0 1px 3px rgba(15,31,46,.06), 0 1px 2px rgba(15,31,46,.04);
            --shadow-md:   0 4px 16px rgba(15,31,46,.08), 0 2px 6px rgba(15,31,46,.05);
            --shadow-lg:   0 12px 40px rgba(15,31,46,.12), 0 4px 12px rgba(15,31,46,.07);
            --radius:      10px;
            --sidebar-w:   268px;
            --success:     #16a34a;
            --danger:      #dc2626;
            --warning:     #d97706;
            --info:        #2563eb;
        }

        /* DARK MODE */
        [data-theme="dark"] {
            --navy:        #0a0f1a;
            --navy-mid:    #0f1620;
            --navy-light:  #162030;
            --gold:        #c9a84c;
            --gold-light:  #e2c47a;
            --gold-pale:   #2a2010;
            --cream:       #0f1420;
            --white:       #161e2e;
            --text:        #e2e8f0;
            --text-muted:  #94a3b8;
            --border:      #1e2d42;
            --shadow-sm:   0 1px 3px rgba(0,0,0,.2);
            --shadow-md:   0 4px 16px rgba(0,0,0,.25);
            --shadow-lg:   0 12px 40px rgba(0,0,0,.35);
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--cream);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            font-size: 15px;
            -webkit-font-smoothing: antialiased;
            transition: background 0.3s ease, color 0.3s ease;
        }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--navy);
            min-height: 100vh;
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 200;
            border-right: 1px solid rgba(201,168,76,.12);
            transition: background 0.3s ease;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--gold), var(--gold-light), var(--gold));
        }

        .sidebar-logo {
            padding: 28px 24px 22px;
            border-bottom: 1px solid rgba(255,255,255,.06);
            text-align: center;
        }

        .logo-img-wrap {
            width: 72px; height: 72px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px auto;
        }

        .logo-img-wrap img {
            width: 100%; height: 100%;
            object-fit: contain;
        }

        .sidebar-logo-title {
            font-family: 'Cormorant', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gold);
            letter-spacing: 4px;
            line-height: 1.2;
        }

        .sidebar-logo p {
            font-size: 0.65rem;
            color: rgba(255,255,255,.3);
            text-transform: uppercase;
            letter-spacing: 2.5px;
            margin-top: 3px;
            font-weight: 500;
        }

        .sidebar-nav { flex: 1; padding: 16px 0; overflow-y: auto; }
        .sidebar-nav::-webkit-scrollbar { width: 3px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 2px; }

        .nav-group { padding: 0 14px; margin-bottom: 4px; }

        .nav-group-label {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(255,255,255,.2);
            padding: 14px 10px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 9px 12px;
            border-radius: 8px;
            color: rgba(255,255,255,.55);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 400;
            transition: all 0.18s ease;
            margin-bottom: 1px;
            position: relative;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .nav-item i { font-size: 1rem; width: 18px; text-align: center; flex-shrink: 0; }
        .nav-item:hover { background: rgba(255,255,255,.06); color: rgba(255,255,255,.85); }

        .nav-item.active {
            background: linear-gradient(135deg, rgba(201,168,76,.18), rgba(201,168,76,.08));
            color: var(--gold-light);
            font-weight: 500;
            border: 1px solid rgba(201,168,76,.2);
        }

        .nav-item.active i { color: var(--gold); }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0; top: 50%;
            transform: translateY(-50%);
            width: 3px; height: 60%;
            background: var(--gold);
            border-radius: 0 3px 3px 0;
        }

        .sidebar-divider { height: 1px; background: rgba(255,255,255,.06); margin: 8px 14px; }

        .sidebar-footer { padding: 14px; border-top: 1px solid rgba(255,255,255,.06); }

        .user-block {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.06);
            transition: background 0.2s;
        }

        .user-block:hover { background: rgba(255,255,255,.07); }

        .user-avatar {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--navy);
            font-family: 'Cormorant', serif;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .user-info { flex: 1; min-width: 0; }

        .user-name {
            font-size: 0.83rem;
            font-weight: 600;
            color: rgba(255,255,255,.9);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role { font-size: 0.68rem; color: var(--gold); text-transform: capitalize; margin-top: 1px; }

        .logout-form { margin: 0; }

        .logout-btn {
            background: none;
            border: none;
            color: rgba(255,255,255,.3);
            cursor: pointer;
            font-size: 0.95rem;
            padding: 6px;
            border-radius: 6px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
        }

        .logout-btn:hover { color: #fff; background: rgba(220,38,38,.2); }

        /* MAIN */
        .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

        .topbar {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 0 36px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-sm);
            transition: background 0.3s ease, border-color 0.3s ease;
        }

        .topbar-left { display: flex; align-items: center; gap: 12px; }

        .topbar-title {
            font-family: 'Cormorant', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text);
            letter-spacing: 0.2px;
        }

        .topbar-badge {
            font-size: 0.7rem;
            background: var(--gold-pale);
            color: var(--gold);
            border: 1px solid rgba(201,168,76,.3);
            padding: 2px 8px;
            border-radius: 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .topbar-actions { display: flex; gap: 8px; align-items: center; }

        /* Bouton dark mode */
        .theme-btn {
            width: 36px; height: 36px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .theme-btn:hover { background: var(--gold-pale); color: var(--gold); border-color: var(--gold); }

        .content { padding: 32px 36px; flex: 1; }

        /* COMPONENTS */
        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
            transition: box-shadow 0.2s, background 0.3s ease, border-color 0.3s ease;
        }

        .card:hover { box-shadow: var(--shadow-md); }

        .card-title {
            font-family: 'Cormorant', serif;
            font-size: 1.15rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 18px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 20px;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.18s ease;
            white-space: nowrap;
        }

        .btn-primary { background: var(--navy); color: #fff; box-shadow: 0 2px 8px rgba(15,31,46,.2); }
        .btn-primary:hover { background: var(--navy-light); transform: translateY(-1px); }
        .btn-accent { background: linear-gradient(135deg, var(--gold), var(--gold-light)); color: var(--navy); font-weight: 600; }
        .btn-accent:hover { box-shadow: 0 4px 16px rgba(201,168,76,.4); transform: translateY(-1px); }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-danger:hover { background: #b91c1c; transform: translateY(-1px); }
        .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text-muted); }
        .btn-outline:hover { border-color: var(--gold); color: var(--text); }
        .btn-sm { padding: 6px 14px; font-size: 0.8rem; border-radius: 6px; }
        .btn-xs { padding: 4px 10px; font-size: 0.75rem; border-radius: 5px; }

        .table-wrap { overflow-x: auto; border-radius: var(--radius); border: 1px solid var(--border); transition: border-color 0.3s; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: var(--navy); }
        thead th { color: rgba(255,255,255,.85); font-weight: 500; padding: 13px 18px; text-align: left; font-size: 0.78rem; letter-spacing: 0.8px; text-transform: uppercase; white-space: nowrap; }
        tbody tr { border-bottom: 1px solid var(--border); transition: background 0.15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: rgba(201,168,76,.04); }
        tbody td { padding: 13px 18px; font-size: 0.875rem; vertical-align: middle; color: var(--text); }

        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 600; letter-spacing: 0.3px; text-transform: capitalize; }
        .badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; flex-shrink: 0; }
        .badge-success { background: #dcfce7; color: #15803d; }
        .badge-danger  { background: #fee2e2; color: #b91c1c; }
        .badge-warning { background: #fef3c7; color: #b45309; }
        .badge-info    { background: #dbeafe; color: #1d4ed8; }
        .badge-muted   { background: #f1f5f9; color: #475569; }

        [data-theme="dark"] .badge-success { background: #14532d; color: #86efac; }
        [data-theme="dark"] .badge-danger  { background: #7f1d1d; color: #fca5a5; }
        [data-theme="dark"] .badge-warning { background: #78350f; color: #fcd34d; }
        [data-theme="dark"] .badge-info    { background: #1e3a8a; color: #93c5fd; }
        [data-theme="dark"] .badge-muted   { background: #1e293b; color: #94a3b8; }

        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 0.82rem; font-weight: 500; margin-bottom: 7px; color: var(--text); }
        .form-label span { color: var(--danger); margin-left: 2px; }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            background: var(--white);
            color: var(--text);
            transition: border-color 0.18s, box-shadow 0.18s, background 0.3s;
        }

        .form-control:focus { outline: none; border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,168,76,.15); }
        .form-control::placeholder { color: #b0b8c4; }
        .form-control.is-invalid { border-color: var(--danger); }
        .invalid-feedback { color: var(--danger); font-size: 0.78rem; margin-top: 5px; display: block; }

        .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; }

        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 28px; }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px 22px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: var(--shadow-sm);
            transition: box-shadow 0.2s, transform 0.2s, background 0.3s;
        }

        .stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
        .stat-icon { width: 46px; height: 46px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
        .stat-icon-green  { background: #dcfce7; color: #16a34a; }
        .stat-icon-gold   { background: #fef3c7; color: #b45309; }
        .stat-icon-red    { background: #fee2e2; color: #dc2626; }
        .stat-icon-blue   { background: #dbeafe; color: #2563eb; }
        .stat-value { font-family: 'Cormorant', serif; font-size: 2rem; font-weight: 700; color: var(--text); line-height: 1; }
        .stat-label { font-size: 0.78rem; color: var(--text-muted); margin-top: 3px; }

        .pagination { display: flex; gap: 4px; align-items: center; justify-content: center; margin-top: 28px; }
        .pagination a, .pagination span { padding: 7px 13px; border-radius: 7px; font-size: 0.82rem; text-decoration: none; color: var(--text-muted); border: 1px solid var(--border); transition: all 0.18s; font-weight: 500; }
        .pagination a:hover { background: var(--navy); color: #fff; border-color: var(--navy); }
        .pagination .active span { background: var(--navy); color: #fff; border-color: var(--navy); }

        /* TOASTS */
        #toast-container { position: fixed; bottom: 28px; right: 28px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; min-width: 340px; max-width: 400px; }
        .toast-card { background: var(--white); border-radius: 12px; box-shadow: var(--shadow-lg); overflow: hidden; display: flex; align-items: stretch; opacity: 0; transform: translateX(30px) scale(0.97); transition: opacity 0.3s ease, transform 0.3s ease; border: 1px solid var(--border); }
        .toast-card.show { opacity: 1; transform: translateX(0) scale(1); }
        .toast-strip { width: 5px; flex-shrink: 0; }
        .toast-icon-wrap { padding: 17px 4px 16px 14px; display: flex; align-items: flex-start; }
        .toast-icon-wrap i { font-size: 1.1rem; }
        .toast-body { flex: 1; padding: 14px 10px 12px 10px; }
        .toast-title { font-weight: 600; font-size: 0.82rem; margin-bottom: 3px; }
        .toast-message { font-size: 0.85rem; color: var(--text-muted); line-height: 1.5; }
        .toast-progress { margin-top: 10px; height: 2px; border-radius: 1px; background: var(--border); overflow: hidden; }
        .toast-bar { height: 100%; width: 100%; border-radius: 1px; transition: width linear; }
        .toast-close { background: none; border: none; padding: 12px 14px 0 4px; font-size: 1rem; color: var(--text-muted); cursor: pointer; align-self: flex-start; transition: color 0.18s; }
        .toast-close:hover { color: var(--text); }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main { margin-left: 0; }
            .topbar { padding: 0 20px; }
            .content { padding: 20px; }
            .form-grid-2, .form-grid-3 { grid-template-columns: 1fr; }
            #toast-container { right: 12px; left: 12px; min-width: unset; }
        }
    </style>

    @stack('styles')
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-img-wrap">
            <img src="{{ asset('images/logo.svg.svg') }}" alt="Biblioges">
        </div>
        <h1 class="sidebar-logo-title">BIBLIOGES</h1>
        <p>Bibliotheque Universitaire</p>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-group">
            <div class="nav-group-label">Navigation</div>
            <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="bi bi-house"></i> Accueil
            </a>
            @auth
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid"></i> Tableau de bord
            </a>
            @endauth
        </div>

        <div class="sidebar-divider"></div>

        <div class="nav-group">
            <div class="nav-group-label">Catalogue</div>
            <a href="{{ route('books.index') }}" class="nav-item {{ request()->routeIs('books.*') ? 'active' : '' }}">
                <i class="bi bi-journals"></i> Livres
            </a>
            @auth
            <a href="{{ route('borrows.index') }}" class="nav-item {{ request()->routeIs('borrows.*') ? 'active' : '' }}">
                <i class="bi bi-arrow-left-right"></i> Emprunts
            </a>
            @endauth
        </div>

        @auth
        @if(auth()->user()->isBibliothecaire())
        <div class="sidebar-divider"></div>
        <div class="nav-group">
            <div class="nav-group-label">Administration</div>
            <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Utilisateurs
            </a>
            <form method="POST" action="{{ route('borrows.notifications-retard') }}" class="logout-form">
                @csrf
                <button type="submit" class="nav-item">
                    <i class="bi bi-bell"></i> Notifier retards
                </button>
            </form>
        </div>
        @endif
        @endauth
    </nav>

    @auth
    <div class="sidebar-footer">
        <div class="user-block">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ auth()->user()->role }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn" title="Deconnexion">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
    @endauth
</aside>

<main class="main">
    <div class="topbar">
        <div class="topbar-left">
            <div class="topbar-title">@yield('page-title', 'Bibliotheque')</div>
            @hasSection('page-badge')
                <span class="topbar-badge">@yield('page-badge')</span>
            @endif
        </div>
        <div class="topbar-actions">
            <button class="theme-btn" id="themeToggle" title="Mode sombre">
                <i class="bi bi-moon-stars" id="themeIcon"></i>
            </button>
            @yield('topbar-actions')
        </div>
    </div>

    <div class="content">
        @yield('content')
    </div>
</main>

<div id="toast-container">
    @php
        $toasts = [
            'success' => ['color' => '#16a34a', 'icon' => 'bi-check-circle-fill', 'title' => 'Succes'],
            'error'   => ['color' => '#dc2626', 'icon' => 'bi-x-circle-fill',     'title' => 'Erreur'],
            'warning' => ['color' => '#d97706', 'icon' => 'bi-exclamation-triangle-fill', 'title' => 'Attention'],
            'info'    => ['color' => '#2563eb', 'icon' => 'bi-info-circle-fill',   'title' => 'Information'],
        ];
    @endphp

    @foreach($toasts as $key => $cfg)
        @if(session($key))
        <div class="toast-card" data-delay="5000">
            <div class="toast-strip" style="background: {{ $cfg['color'] }};"></div>
            <div class="toast-icon-wrap">
                <i class="bi {{ $cfg['icon'] }}" style="color: {{ $cfg['color'] }};"></i>
            </div>
            <div class="toast-body">
                <div class="toast-title" style="color: {{ $cfg['color'] }};">{{ $cfg['title'] }}</div>
                <div class="toast-message">{{ session($key) }}</div>
                <div class="toast-progress">
                    <div class="toast-bar" style="background: {{ $cfg['color'] }};"></div>
                </div>
            </div>
            <button class="toast-close" onclick="closeToast(this.closest('.toast-card'))">
                <i class="bi bi-x"></i>
            </button>
        </div>
        @endif
    @endforeach
</div>

<script>
const html      = document.documentElement;
const themeBtn  = document.getElementById('themeToggle');
const themeIcon = document.getElementById('themeIcon');

function applyTheme(theme) {
    html.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
    if (theme === 'dark') {
        themeIcon.className = 'bi bi-sun';
        themeBtn.title = 'Mode clair';
    } else {
        themeIcon.className = 'bi bi-moon-stars';
        themeBtn.title = 'Mode sombre';
    }
}

applyTheme(localStorage.getItem('theme') || 'light');

themeBtn.addEventListener('click', function() {
    applyTheme(html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
});

function closeToast(el) {
    el.style.opacity = '0';
    el.style.transform = 'translateX(30px) scale(0.97)';
    setTimeout(() => el.remove(), 300);
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toast-card').forEach(function(toast) {
        const delay = parseInt(toast.dataset.delay) || 5000;
        const bar   = toast.querySelector('.toast-bar');
        requestAnimationFrame(() => { requestAnimationFrame(() => toast.classList.add('show')); });
        if (bar) { bar.style.transitionDuration = delay + 'ms'; setTimeout(() => { bar.style.width = '0%'; }, 60); }
        setTimeout(() => closeToast(toast), delay);
    });
});
</script>

@stack('scripts')
</body>
</html>