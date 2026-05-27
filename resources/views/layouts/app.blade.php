<!DOCTYPE html>
<<<<<<< HEAD
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Our Stock') — Sistem Manajemen Gudang</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        mono: ['DM Mono', 'monospace'],
                    },
                    colors: {
                        emerald: {
                            25:  '#f0fdf6',
                            50:  '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
                        },
                        forest: {
                            DEFAULT: '#0a3d2e',
                            light:   '#0d4f3c',
                            dark:    '#062218',
                        },
                    },
                    boxShadow: {
                        'soft':    '0 2px 15px -3px rgba(0,0,0,.07), 0 10px 20px -2px rgba(0,0,0,.04)',
                        'card':    '0 1px 3px rgba(0,0,0,.06), 0 20px 40px -10px rgba(0,0,0,.08)',
                        'green':   '0 8px 30px rgba(5,150,105,.25)',
                        'green-sm':'0 4px 15px rgba(5,150,105,.2)',
                    },
                    borderRadius: {
                        '2xl': '1rem',
                        '3xl': '1.5rem',
                    },
                    animation: {
                        'fade-up':   'fadeUp .5s ease forwards',
                        'fade-in':   'fadeIn .4s ease forwards',
                        'slide-in':  'slideIn .4s ease forwards',
                        'pulse-slow':'pulse 3s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeUp:  { from:{opacity:'0',transform:'translateY(16px)'}, to:{opacity:'1',transform:'translateY(0)'} },
                        fadeIn:  { from:{opacity:'0'}, to:{opacity:'1'} },
                        slideIn: { from:{opacity:'0',transform:'translateX(-16px)'}, to:{opacity:'1',transform:'translateX(0)'} },
                    },
                }
            }
        }
    </script>

    <style>
        * { box-sizing: border-box; }

        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        ::-webkit-scrollbar       { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #a7f3d0; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #059669; }

        .input-field {
            width: 100%;
            padding: .625rem 1rem;
            border: 1.5px solid #e2e8f0;
            border-radius: .75rem;
            font-size: .9rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        .input-field::placeholder { color: #94a3b8; }
        .input-field:focus {
            border-color: #059669;
            box-shadow: 0 0 0 3px rgba(5,150,105,.12);
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            padding: .75rem 1.5rem;
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: #fff;
            font-weight: 600;
            font-size: .9rem;
            border-radius: .75rem;
            border: none;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s, filter .2s;
            box-shadow: 0 4px 15px rgba(5,150,105,.3);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(5,150,105,.4);
            filter: brightness(1.05);
        }
        .btn-primary:active { transform: translateY(0); }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            padding: .625rem 1.25rem;
            background: #f0fdf6;
            color: #059669;
            font-weight: 600;
            font-size: .875rem;
            border-radius: .75rem;
            border: 1.5px solid #a7f3d0;
            cursor: pointer;
            transition: all .2s;
        }
        .btn-secondary:hover { background: #d1fae5; border-color: #059669; }

        .card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 20px 40px -10px rgba(0,0,0,.08);
            border: 1px solid rgba(255,255,255,.8);
        }

        /* Toggle Switch */
        .toggle-wrap input[type=checkbox] { display: none; }
        .toggle-wrap input:checked ~ .toggle-track { background: #059669; }
        .toggle-wrap input:checked ~ .toggle-track .toggle-thumb { transform: translateX(22px); }
        .toggle-track {
            width: 46px; height: 24px;
            background: #e2e8f0;
            border-radius: 99px;
            position: relative;
            cursor: pointer;
            transition: background .25s;
        }
        .toggle-thumb {
            position: absolute;
            top: 3px; left: 3px;
            width: 18px; height: 18px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 1px 4px rgba(0,0,0,.18);
            transition: transform .25s cubic-bezier(.34,1.56,.64,1);
        }

        /* Sidebar active */
        .nav-item { transition: all .2s; border-radius: .75rem; }
        .nav-item:hover  { background: rgba(255,255,255,.08); }
        .nav-item.active { background: rgba(255,255,255,.15); box-shadow: inset 0 0 0 1px rgba(255,255,255,.1); }

        /* Stat cards shimmer border */
        .stat-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 1.25rem;
            padding: 1px;
            background: linear-gradient(135deg, rgba(167,243,208,.6), rgba(229,231,235,.3));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); transition: transform .3s; }
            #sidebar.open { transform: translateX(0); }
        }
    </style>

    @stack('styles')
</head>
<body class="bg-slate-50 antialiased">
    @yield('content')

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
=======
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
</html>
