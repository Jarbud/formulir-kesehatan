<x-app-layout>
    <x-slot:title>
        Riwayat Pemeriksaan
    </x-slot:title>

    <x-slot:header>
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-primary-100 rounded-xl text-primary-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h2 class="font-bold text-xl sm:text-2xl text-gray-800 leading-tight">
                {{ __('Riwayat Pemeriksaan Kesehatan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-5 sm:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Daftar Riwayat Formulir Anda</h3>
                        @if(!$riwayats->isEmpty())
                            <span class="text-xs font-bold text-primary-600 bg-primary-50 px-3 py-1 rounded-full">{{ $riwayats->count() }} Data</span>
                        @endif
                    </div>
                    
                    @if($riwayats->isEmpty())
                        <div class="text-center py-16 bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl border-2 border-dashed border-gray-200">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white shadow-lg mb-6">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="text-gray-900 font-bold text-xl mb-2">Belum Ada Riwayat</h3>
                            <p class="text-gray-500 max-w-md mx-auto mb-6">Anda belum pernah mengisi formulir pemeriksaan kesehatan. Mulai sekarang untuk mendapatkan hasil pemeriksaan digital.</p>
                            <a href="{{ route('formulir') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white rounded-xl font-bold hover:bg-primary-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Isi Formulir Sekarang
                            </a>
                        </div>
                    @else
                        <!-- Desktop Table -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-y-2 border-gray-200">
                                        <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span>Tanggal</span>
                                            </div>
                                        </th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                <span>Nama</span>
                                            </div>
                                        </th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                                                <span>NIM</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($riwayats as $riwayat)
                                        <tr class="hover:bg-gray-50 hover:shadow-sm transition-all duration-200">
                                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    <span>{{ $riwayat->created_at->format('d M Y, H:i') }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-700 font-semibold">{{ $riwayat->name }}</td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-primary-50 text-primary-700 border border-primary-200">{{ $riwayat->nim }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card Layout -->
                        <div class="md:hidden space-y-3">
                            @foreach($riwayats as $riwayat)
                                <div class="bg-gray-50 rounded-xl border border-gray-200 p-4 hover:shadow-md transition-all duration-200">
                                    <div class="flex items-center justify-between mb-3 pb-3 border-b border-gray-200">
                                        <div class="flex items-center space-x-2 text-gray-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <span class="text-xs font-medium">{{ $riwayat->created_at->format('d M Y') }}</span>
                                        </div>
                                        <span class="text-xs text-gray-400">{{ $riwayat->created_at->format('H:i') }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mb-0.5">Nama</p>
                                        <p class="text-sm font-bold text-gray-900">{{ $riwayat->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mb-0.5">NIM</p>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-primary-50 text-primary-700 border border-primary-200">{{ $riwayat->nim }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
