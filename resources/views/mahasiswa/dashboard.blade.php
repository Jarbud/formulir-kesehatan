<x-app-layout>
    <x-slot:title>
        Dashboard Mahasiswa
    </x-slot:title>

    <x-slot:header>
        <h2 class="font-bold text-xl sm:text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
            <div x-data="fadeIn" class="p-4 sm:p-5 rounded-xl bg-green-50 border-l-4 border-green-500 shadow-md">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm sm:text-base text-green-700 font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Hero Section dengan Gradient -->
            <div x-data="fadeIn" class="relative overflow-hidden bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 rounded-2xl shadow-xl p-6 sm:p-8 text-white">
                <div class="relative z-10">
                    <div class="flex items-center space-x-3 sm:space-x-4 mb-4">
                        <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-primary-100 text-xs sm:text-sm font-medium">Selamat Datang Kembali</p>
                            <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold">{{ Auth::user()->name }}</h3>
                        </div>
                    </div>
                    <p class="text-primary-50 text-sm sm:text-base leading-relaxed max-w-2xl">
                        Dashboard pemeriksaan kesehatan Anda. Pantau status kesehatan dan akses formulir dengan mudah untuk keperluan PKKMB.
                    </p>
                </div>
                
                <!-- Decorative elements -->
                <div class="absolute -right-10 -bottom-10 w-32 h-32 sm:w-48 sm:h-48 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -top-10 -left-10 w-24 h-24 sm:w-32 sm:h-32 bg-accent-400/20 rounded-full blur-2xl"></div>
            </div>

            <!-- Quick Action Cards -->
            <div x-data="stagger(100)" class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <!-- Isi Formulir Card -->
                <a href="{{ route('formulir') }}" class="group relative overflow-hidden bg-white rounded-2xl shadow-md hover:shadow-xl border border-gray-100 p-6 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-start justify-between mb-4">
                        <div class="p-3 bg-primary-50 text-primary-600 rounded-xl group-hover:bg-primary-100 transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-primary-600 bg-primary-50 px-3 py-1 rounded-full">Action</span>
                    </div>
                    <h4 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Isi Formulir Kesehatan</h4>
                    <p class="text-gray-600 text-sm mb-4">Lengkapi data kesehatan untuk pemeriksaan PKKMB tahun ini</p>
                    <div class="flex items-center text-primary-600 font-semibold text-sm group-hover:translate-x-2 transition-transform">
                        Mulai Sekarang 
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </a>
                
                <!-- Lihat Riwayat Card -->
                <a href="{{ route('riwayat') }}" class="group relative overflow-hidden bg-white rounded-2xl shadow-md hover:shadow-xl border border-gray-100 p-6 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-start justify-between mb-4">
                        <div class="p-3 bg-accent-50 text-accent-600 rounded-xl group-hover:bg-accent-100 transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-accent-600 bg-accent-50 px-3 py-1 rounded-full">Info</span>
                    </div>
                    <h4 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Lihat Riwayat</h4>
                    <p class="text-gray-600 text-sm mb-4">Akses riwayat pemeriksaan kesehatan Anda sebelumnya</p>
                    <div class="flex items-center text-accent-600 font-semibold text-sm group-hover:translate-x-2 transition-transform">
                        Lihat Detail 
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </a>
            </div>

            <!-- Info Section -->
            <div x-data="slideUp" class="bg-gradient-to-r from-blue-50 to-accent-50 rounded-2xl border border-blue-100 p-6 sm:p-8">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-lg font-bold text-gray-900 mb-2">Informasi Penting</h4>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-accent-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Pastikan data yang Anda masukkan akurat dan sesuai kondisi kesehatan terkini</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-accent-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Setelah mengisi formulir, data akan diverifikasi oleh perawat dan dokter</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-accent-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Hasil pemeriksaan dapat diunduh dalam format PDF setelah selesai</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</x-app-layout>