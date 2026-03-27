<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Biblioges') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: #2a2f3a;
            position: relative;
            overflow-x: hidden;
        }

        .bg-pattern {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 0;
            opacity: 0.07;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120'%3E%3Crect x='10' y='20' width='22' height='32' rx='2' fill='%23fff'/%3E%3Crect x='12' y='22' width='4' height='28' fill='%23ccc'/%3E%3Crect x='36' y='14' width='18' height='38' rx='2' fill='%23fff'/%3E%3Crect x='38' y='16' width='3' height='34' fill='%23ccc'/%3E%3Crect x='58' y='22' width='24' height='30' rx='2' fill='%23fff'/%3E%3Crect x='60' y='24' width='4' height='26' fill='%23ccc'/%3E%3Crect x='86' y='18' width='16' height='34' rx='2' fill='%23fff'/%3E%3Cpath d='M5 55 Q60 45 115 55' stroke='%23fff' stroke-width='1.5' fill='none'/%3E%3Cpath d='M5 58 Q60 68 115 58' stroke='%23fff' stroke-width='1.5' fill='none'/%3E%3C/svg%3E");
            background-size: 180px 180px;
        }

        .bg-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 1;
            background: linear-gradient(135deg,
                rgba(15,31,46,0.92) 0%,
                rgba(30,50,70,0.85) 50%,
                rgba(15,31,46,0.92) 100%);
        }

        .bg-circle-1 {
            position: fixed;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 70%);
            top: -100px; left: -100px;
            z-index: 1;
        }

        .bg-circle-2 {
            position: fixed;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(201,168,76,0.06) 0%, transparent 70%);
            bottom: -80px; right: -80px;
            z-index: 1;
        }

        .login-wrapper {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 24px;
        }

        .login-logo-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 28px;
        }

        .login-logo-img {
            width: 90px; height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            background: white;
            border-radius: 12px;
            padding: 8px;
        }

        .login-logo-img img {
            width: 100%; height: 100%;
            object-fit: contain;
        }

        .login-logo-title {
            font-family: 'Cormorant', serif;
            font-size: 2rem;
            font-weight: 700;
            color: #c9a84c;
            letter-spacing: 6px;
        }

        .login-logo-line {
            width: 60px;
            height: 1px;
            background: linear-gradient(90deg, transparent, #c9a84c, transparent);
            margin: 8px auto;
        }

        .login-logo-sub {
            font-size: 0.65rem;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 3.5px;
            margin-top: 4px;
        }

        .login-card {
            background: rgba(255,255,255,0.97);
            border-radius: 16px;
            box-shadow: 0 24px 64px rgba(0,0,0,0.3), 0 4px 16px rgba(0,0,0,0.2);
            padding: 36px;
            width: 100%;
            max-width: 420px;
            border: 1px solid rgba(201,168,76,0.2);
        }

        .login-footer {
            margin-top: 20px;
            font-size: 0.7rem;
            color: rgba(255,255,255,0.2);
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

    <div class="bg-pattern"></div>
    <div class="bg-overlay"></div>
    <div class="bg-circle-1"></div>
    <div class="bg-circle-2"></div>

    <div class="login-wrapper">

        <div class="login-logo-wrap">
            <div class="login-logo-img">
                <img src="{{ asset('images/logo.svg.svg') }}" alt="Biblioges">
            </div>
            <div class="login-logo-title">BIBLIOGES</div>
            <div class="login-logo-line"></div>
            <div class="login-logo-sub">Bibliotheque Universitaire</div>
        </div>

        <div class="login-card">
            {{ $slot }}
        </div>

        <div class="login-footer">2026 Biblioges</div>
    </div>

</body>
</html>