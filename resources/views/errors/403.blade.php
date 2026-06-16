<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Akses Ditolak | HawariFarm</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .centered {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 80vh;
            text-align: center;
        }
        .btn {
            background: linear-gradient(135deg, #10b981, #06b6d4);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            margin-top: 1.5rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-emerald-50 to-teal-100">
    <div class="centered">
        <h1 class="text-6xl font-extrabold text-emerald-800 mb-4">403</h1>
        <p class="text-xl text-gray-700 mb-2">Akses ditolak. Anda tidak memiliki izin untuk melihat halaman ini.</p>
        <a href="{{ url('/dashboard') }}" class="btn">Kembali ke Dashboard</a>
    </div>
</body>
</html>
