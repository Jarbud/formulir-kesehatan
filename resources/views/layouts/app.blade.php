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
    <body class="font-sans antialiased">
        <!-- Skip to main content (Accessibility) -->
        <a href="#main-content" 
           class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:px-6 focus:py-3 focus:bg-primary-600 focus:text-white focus:rounded-lg focus:shadow-xl">
            Skip to main content
        </a>

        <div class="min-h-screen bg-gray-50">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main id="main-content">
                {{ $slot }}
            </main>
        </div>

        <!-- Toast Notification Container -->
        <div x-data="{ 
            show: false, 
            message: '', 
            type: 'success',
            showToast(msg, toastType = 'success') {
                this.message = msg;
                this.type = toastType;
                this.show = true;
                setTimeout(() => { this.show = false }, 3000);
            }
        }" 
        @toast.window="showToast($event.detail.message, $event.detail.type)"
        class="fixed top-4 right-4 z-50">
            <div x-show="show" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-x-full"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 translate-x-full"
                 :class="{
                     'bg-green-50 border-green-500 text-green-900': type === 'success',
                     'bg-red-50 border-red-500 text-red-900': type === 'error',
                     'bg-yellow-50 border-yellow-500 text-yellow-900': type === 'warning',
                     'bg-blue-50 border-blue-500 text-blue-900': type === 'info'
                 }"
                 class="flex items-center space-x-3 px-6 py-4 rounded-xl border-l-4 shadow-xl min-w-[320px] max-w-md">
                <div class="flex-shrink-0">
                    <svg x-show="type === 'success'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <svg x-show="type === 'error'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <svg x-show="type === 'warning'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <svg x-show="type === 'info'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="font-semibold text-sm flex-1" x-text="message"></p>
                <button @click="show = false" class="flex-shrink-0 ml-auto hover:opacity-75 transition-opacity">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </body>
</html>
