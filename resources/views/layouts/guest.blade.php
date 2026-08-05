<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#3b82f6">

        <title>{{ isset($title) ? $title . ' - ' . config('app.name', 'Klinik Pratama UM') : config('app.name', 'Klinik Pratama UM') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logo-kecil.png') }}">
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-primary-50 via-white to-accent-50">
            <!-- Background decoration -->
            <div class="fixed inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary-200/30 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-accent-200/30 rounded-full blur-3xl"></div>
            </div>

            <div class="relative z-10">
                <a href="/" class="flex items-center space-x-3 mb-2">
                    <img src="{{ asset('images/logo-kecil.png') }}" alt="Logo UM" class="h-12 w-auto" onerror="this.style.display='none'">
                    <div>
                        <h1 class="text-base sm:text-lg font-bold bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent">KLINIK PRATAMA</h1>
                        <p class="text-xs font-semibold text-gray-500">UNIVERSITAS NEGERI MALANG</p>
                    </div>
                </a>
            </div>

            <div class="relative z-10 w-full sm:max-w-md mt-6 px-6 py-8 bg-white/80 backdrop-blur-xl shadow-xl shadow-primary-100/50 border border-white/50 overflow-hidden sm:rounded-2xl">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="relative z-10 mt-8 text-center text-xs text-gray-400">
                <p>&copy; {{ date('Y') }} Klinik Pratama Universitas Negeri Malang</p>
            </div>
        </div>
    </body>
</html>
