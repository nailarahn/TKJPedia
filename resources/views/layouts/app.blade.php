<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mappy Path') - Platform Belajar IT</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Base Styles -->
    <style>
        :root {
            --primary: #372466;
            --primary-light: #4e35a0;
            --primary-dark: #251848;
            --primary-ultra: #1a1033;
            --accent: #7c5cbf;
            --accent-light: #a78bd4;
            --accent-glow: rgba(55, 36, 102, 0.3);
            --white: #ffffff;
            --gray-50: #f8f7ff;
            --gray-100: #f0eeff;
            --gray-200: #e4e0f5;
            --gray-300: #c8c0e8;
            --gray-400: #9b8ec4;
            --gray-500: #6d5fa0;
            --gray-600: #4a3d7a;
            --gray-700: #332a5c;
            --gray-800: #201a3e;
            --gray-900: #120f26;
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --sidebar-width: 260px;
            --font: 'Poppins', sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font);
            background: var(--gray-50);
            color: var(--gray-800);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--gray-100); }
        ::-webkit-scrollbar-thumb { background: var(--accent); border-radius: 3px; }

        /* Utility classes */
        .text-primary { color: var(--primary) !important; }
        .text-accent { color: var(--accent) !important; }
        .text-white { color: var(--white) !important; }
        .text-muted { color: var(--gray-400) !important; }
        .bg-primary { background: var(--primary) !important; }
        .d-flex { display: flex; }
        .align-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-1 { gap: 0.5rem; }
        .gap-2 { gap: 1rem; }
        .gap-3 { gap: 1.5rem; }
        .w-100 { width: 100%; }
        .mt-1 { margin-top: 0.5rem; }
        .mt-2 { margin-top: 1rem; }
        .mt-3 { margin-top: 1.5rem; }
        .mb-1 { margin-bottom: 0.5rem; }
        .mb-2 { margin-bottom: 1rem; }
        .mb-3 { margin-bottom: 1.5rem; }
        .p-3 { padding: 1.5rem; }
        .rounded { border-radius: 12px; }
        .fw-600 { font-weight: 600; }
        .fw-700 { font-weight: 700; }
        .fs-sm { font-size: 0.85rem; }
        .fs-xs { font-size: 0.75rem; }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.65rem 1.5rem;
            border-radius: 10px;
            font-family: var(--font);
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.25s ease;
            text-decoration: none;
            white-space: nowrap;
        }
        .btn-primary {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
        }
        .btn-primary:hover {
            background: var(--primary-light);
            border-color: var(--primary-light);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px var(--accent-glow);
        }
        .btn-outline {
            background: transparent;
            color: var(--primary);
            border-color: var(--primary);
        }
        .btn-outline:hover {
            background: var(--primary);
            color: var(--white);
        }
        .btn-lg { padding: 0.85rem 2rem; font-size: 1rem; border-radius: 12px; }
        .btn-sm { padding: 0.45rem 1rem; font-size: 0.8rem; border-radius: 8px; }

        /* Cards */
        .card {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--gray-200);
            overflow: hidden;
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }
        .card:hover { box-shadow: 0 8px 30px rgba(55, 36, 102, 0.1); }
        .card-body { padding: 1.5rem; }

        /* Progress bar */
        .progress-bar {
            width: 100%;
            height: 8px;
            background: var(--gray-200);
            border-radius: 4px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--accent-light));
            border-radius: 4px;
            transition: width 0.8s ease;
        }

        /* Alerts */
        .alert {
            padding: 0.85rem 1.25rem;
            border-radius: 10px;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
        }
        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }
        .alert-success {
            background: #f0fdf4;
            color: #16a34a;
            border-color: #bbf7d0;
        }

        @yield('extra-styles')
    </style>

    @stack('head')
</head>
<body>
    @yield('content')

    @stack('scripts')
</body>
</html>
