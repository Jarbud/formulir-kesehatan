<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Pemeriksaan Kesehatan - Universitas Negeri Malang</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-kecil.png') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="antialiased bg-gray-50 text-gray-900 font-['Figtree']">

    <!-- Header / Navbar -->
    <header class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-3">
                    <!-- Ganti logo.png dengan asset Anda -->
                    <img src="{{ asset('images/logo-kecil.png') }}" alt="Logo UM" class="h-12 w-auto" onerror="this.src='https://upload.wikimedia.org/wikipedia/id/thumb/7/7e/Logo_Universitas_Negeri_Malang.png/200px-Logo_Universitas_Negeri_Malang.png'">
                    <div>
                        <h1 class="text-blue-900 font-bold leading-none text-base md:text-lg">KLINIK PRATAMA</h1>
                        <p class="text-blue-700 text-[10px] md:text-xs font-semibold tracking-wider hidden sm:block">UNIVERSITAS NEGERI MALANG</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="flex items-center">
                    @if (Route::has('login'))
                        <div class="flex items-center space-x-3 md:space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="font-semibold text-blue-600 hover:text-blue-800 transition text-sm md:text-base">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-blue-600 transition text-sm md:text-base">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-blue-900 text-white px-4 py-2 md:px-5 md:py-2 rounded-full font-semibold hover:bg-blue-800 transition shadow-md shadow-blue-200 text-xs md:text-base whitespace-nowrap">
                                        <span class="hidden sm:inline">Registrasi Mahasiswa</span>
                                        <span class="sm:hidden">Daftar</span>
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <main>
        <section class="relative overflow-hidden pt-16 pb-20 lg:pt-24 lg:pb-32 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="lg:grid lg:grid-cols-2 lg:gap-12 items-center">
                    <div class="mb-12 lg:mb-0">
                        <span class="inline-block px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 text-sm font-bold tracking-wide uppercase mb-6">
                            Layanan Kesehatan Mahasiswa
                        </span>
                        <h2 class="text-4xl sm:text-5xl font-extrabold text-gray-900 leading-[1.1] mb-6">
                            Portal Hasil Pemeriksaan <br>
                            <span class="text-blue-600">Kesehatan Mahasiswa Baru</span>
                        </h2>
                        <p class="text-lg text-gray-600 mb-10 leading-relaxed">
                            Akses hasil pemeriksaan kesehatan Anda secara digital. Cek status kelayakan PKKMB, rekam medis fisik, dan cetak formulir resmi langsung dari dashboard Anda.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                            <a href="{{ route('login') }}" class="flex items-center justify-center space-x-2 bg-blue-900 text-white px-8 py-4 rounded-xl font-bold hover:bg-blue-800 transition-all transform hover:-translate-y-1 shadow-xl shadow-blue-200">
                                <i data-lucide="log-in" class="w-5 h-5"></i>
                                <span>Lihat Hasil Saya</span>
                            </a>
                            <a href="#cara-kerja" class="flex items-center justify-center space-x-2 bg-white border-2 border-gray-200 text-gray-700 px-8 py-4 rounded-xl font-bold hover:border-blue-600 hover:text-blue-600 transition-all">
                                <span>Panduan Alur</span>
                            </a>
                        </div>
                    </div>

                    <!-- Visual Representation -->
                    <div class="relative">
                        <div class="absolute -inset-4 bg-gradient-to-tr from-blue-100 to-green-50 rounded-3xl -z-10 transform rotate-3"></div>
                        <div class="bg-white p-4 rounded-2xl shadow-2xl border border-gray-100">
                            <!-- Mockup Formulir sesuai gambar yang Anda berikan -->
                            <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 bg-gray-50">
                                <div class="flex justify-between items-start mb-6">
                                    <div class="flex space-x-2">
                                        <div class="w-8 h-8 bg-blue-900 rounded-full"></div>
                                        <div class="w-8 h-8 bg-green-600 rounded-full"></div>
                                    </div>
                                    <span class="text-[10px] font-bold text-gray-400">FORM-UM-2025</span>
                                </div>
                                <div class="space-y-3">
                                    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                    <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                                    <div class="pt-4 space-y-2">
                                        <div class="flex justify-between">
                                            <div class="h-3 bg-gray-200 rounded w-1/4"></div>
                                            <div class="h-3 bg-blue-200 rounded w-1/4"></div>
                                        </div>
                                        <div class="flex justify-between">
                                            <div class="h-3 bg-gray-200 rounded w-1/4"></div>
                                            <div class="h-3 bg-blue-200 rounded w-1/4"></div>
                                        </div>
                                    </div>
                                    <div class="mt-6 p-4 bg-white rounded-lg shadow-sm border border-blue-100 text-center">
                                        <p class="text-[10px] font-bold text-blue-600 mb-1 uppercase tracking-tighter">Kesimpulan</p>
                                        <p class="text-sm font-black text-gray-800 uppercase italic">LAYAK MENGIKUTI PKKMB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Floating Card -->
                        <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-lg shadow-xl border border-gray-100 hidden sm:block">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <i data-lucide="check-circle" class="text-green-600 w-6 h-6"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase">Status Verifikasi</p>
                                    <p class="text-sm font-bold">Terverifikasi Dokter</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Cara Kerja Section -->
        <section id="cara-kerja" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-gray-900">Alur Pemeriksaan Kesehatan</h2>
                    <p class="text-gray-600 mt-4">Langkah mudah mendapatkan surat keterangan sehat digital</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8 text-center">
                    <!-- Step 1 -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i data-lucide="user-plus"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Registrasi</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Lakukan pendaftaran akun menggunakan NIM resmi Anda dan lengkapi data profil mahasiswa.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 relative">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i data-lucide="stethoscope"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Pemeriksaan</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Datang ke Klinik Pratama UM untuk dilakukan pemeriksaan fisik oleh tim medis dan dokter.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i data-lucide="file-text"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Cetak Hasil</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Login ke dashboard untuk melihat hasil dan download PDF formulir kesehatan resmi Anda.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo UM" class="h-10 w-auto mx-auto mb-6 grayscale opacity-50" onerror="this.src='https://upload.wikimedia.org/wikipedia/id/thumb/7/7e/Logo_Universitas_Negeri_Malang.png/200px-Logo_Universitas_Negeri_Malang.png'">
            <p class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} Klinik Pratama Universitas Negeri Malang. <br>
                Jl. Semarang 5, Malang 65145.
            </p>
        </div>
    </footer>

    <script>
        // Inisialisasi Lucide Icons
        lucide.createIcons();
    </script>
</body>
</html>