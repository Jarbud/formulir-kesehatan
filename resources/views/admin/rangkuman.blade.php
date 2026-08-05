<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Rangkuman Pemeriksaan Kinerja') }}
            </h2>
            <a href="{{ route('admin.rangkuman.export_all') }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg shadow-sm border border-transparent transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Export Semua Kinerja
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Tabel Kinerja Perawat -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-indigo-50 px-6 py-4 border-b border-indigo-100 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-indigo-900">Total Pemeriksaan: Perawat</h3>
                        <span class="bg-white border border-indigo-200 text-[10px] font-bold text-indigo-600 rounded-full px-2.5 py-1">Telah di-ACC</span>
                    </div>
                    <div class="p-6">
                        <input type="text" id="searchPerawatInput" placeholder="Cari perawat..." class="w-full mb-3 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <table id="perawatTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-y border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    <th class="px-4 py-3 w-[10%]">No</th>
                                    <th class="px-4 py-3">Nama Perawat</th>
                                    <th class="px-4 py-3 text-center w-[25%]">Total Pasien</th>
                                    <th class="px-4 py-3 text-center w-[20%]">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($perawatSummary as $perawat)
                                    <tr class="hover:bg-slate-50/70 transition">
                                        <td class="px-4 py-3 text-sm text-slate-900 font-medium">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-slate-700 font-semibold">
                                            {{ $perawat->name }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-center">
                                            <span class="bg-indigo-100 text-indigo-800 text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap">
                                                {{ $perawat->total }} Data
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-center">
                                            <a href="{{ route('admin.rangkuman.export', ['role' => 'perawat', 'id' => $perawat->id]) }}" class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-700 hover:bg-green-100 border border-green-200 rounded-md text-xs font-bold transition">
                                                Export Excel
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada data perawat yang memeriksa</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tabel Kinerja Dokter -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-emerald-50 px-6 py-4 border-b border-emerald-100 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-emerald-900">Total Pemeriksaan: Dokter</h3>
                        <span class="bg-white border border-emerald-200 text-[10px] font-bold text-emerald-600 rounded-full px-2.5 py-1">Telah di-ACC</span>
                    </div>
                    <div class="p-6">
                        <input type="text" id="searchDokterInput" placeholder="Cari dokter..." class="w-full mb-3 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <table id="dokterTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-y border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    <th class="px-4 py-3 w-[10%]">No</th>
                                    <th class="px-4 py-3">Nama Dokter</th>
                                    <th class="px-4 py-3 text-center w-[25%]">Total Pasien</th>
                                    <th class="px-4 py-3 text-center w-[20%]">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($dokterSummary as $dokter)
                                    <tr class="hover:bg-slate-50/70 transition">
                                        <td class="px-4 py-3 text-sm text-slate-900 font-medium">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-slate-700 font-semibold">
                                            {{ $dokter->name }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-center">
                                            <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap">
                                                {{ $dokter->total }} Data
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-center">
                                            <a href="{{ route('admin.rangkuman.export', ['role' => 'dokter', 'id' => $dokter->id]) }}" class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-700 hover:bg-green-100 border border-green-200 rounded-md text-xs font-bold transition">
                                                Export Excel
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada data dokter yang memeriksa</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Search & Filter vanilla JS -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function initTableSearch(tableId, inputId) {
                const input = document.getElementById(inputId);
                const table = document.getElementById(tableId);
                if (!input || !table) return;
                input.addEventListener('input', function() {
                    const filter = this.value.toLowerCase();
                    table.querySelectorAll('tbody tr').forEach(row => {
                        row.style.display = row.textContent.toLowerCase().includes(filter) ? '' : 'none';
                    });
                });
            }
            initTableSearch('perawatTable', 'searchPerawatInput');
            initTableSearch('dokterTable', 'searchDokterInput');
        });
    </script>
</x-app-layout>
