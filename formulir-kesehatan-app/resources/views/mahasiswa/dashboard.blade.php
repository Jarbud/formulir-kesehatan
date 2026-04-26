<x-app-layout>
    <x-slot:title>
        Dashboard Mahasiswa
    </x-slot:title>

    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
            <div class="p-4 rounded-md bg-green-50 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Kartu Ucapan Selamat Datang & Status -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Selamat Datang, {{ Auth::user()->name }}!</h3>
                <p class="text-gray-600 mb-6">Di sini Anda bisa memantau status kesehatan dan mengisi formulir kesehatan secara berkala untuk keperluan kampus.</p>
                
                <!-- Alert Status (Contoh: Belum Mengisi) -->
                <!-- <div class="p-4 rounded-md bg-yellow-50 border-l-4 border-yellow-400">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700 font-medium">
                                Status: <span class="font-bold">Belum Mengisi Formulir Kesehatan Bulan Ini</span>
                            </p>
                        </div>
                    </div>
                </div> -->
            </div>

            <!-- Kartu Aksi / Menu -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h4 class="text-md font-semibold text-gray-900 mb-4">Aksi Cepat</h4>
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <a href="{{ route('formulir') }}" class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Isi Formulir Kesehatan
                    </a>
                    <a href="{{ route('riwayat') }}" class="inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        Lihat Riwayat
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>