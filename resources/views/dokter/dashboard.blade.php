<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dokter Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Daftar Fakultas (Pengajuan Pemeriksaan)</h3>
                        <a href="{{ route('dokter.export.excel.all') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white hover:bg-green-700 border border-transparent rounded-md text-sm font-bold transition shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Export Semua Data
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table id="fakultasTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-y border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    <th class="px-6 py-4">No</th>
                                    <th class="px-6 py-4">Fakultas</th>
                                    <th class="px-6 py-4 text-center">Total Mahasiswa</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($fakultas as $item)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 font-semibold">
                                            {{ $item->fakultas }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700 text-center">
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                {{ $item->total_mahasiswa }} Mahasiswa
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('dokter.fakultas.mahasiswa', ['fakultas' => $item->fakultas]) }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 rounded-md text-xs font-bold transition">
                                                Lihat Mahasiswa
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                            Belum ada data pengajuan formulir dari fakultas manapun.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- CSS & JS untuk fitur Search, Sort, dan Filter (Simple DataTables) -->
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3/dist/style.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
        <style>
            /* Custom CSS untuk merapikan Simple DataTables dengan Tailwind */
            .datatable-input, .datatable-selector {
                border: 1px solid #e5e7eb !important;
                border-radius: 0.375rem !important;
                padding: 0.375rem 0.75rem !important;
                font-size: 0.875rem !important;
                outline: none !important;
            }
            .datatable-selector {
                width: 75px !important;
                padding-right: 1.75rem !important; /* Ruang khusus agar angka tidak menabrak panah */
            }
            .datatable-input:focus, .dataTable-selector:focus {
                border-color: #3b82f6 !important;
                box-shadow: 0 0 0 1px #3b82f6 !important;
            }
            .datatable-pagination a {
                border-radius: 0.375rem !important;
            }
            .datatable-pagination .active a, .datatable-pagination .active a:hover {
                background-color: #3b82f6 !important;
                color: white !important;
            }
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                if (document.getElementById("fakultasTable") && typeof simpleDatatables.DataTable !== 'undefined') {
                    new simpleDatatables.DataTable("#fakultasTable", {
                        searchable: true,
                        sortable: true,
                        perPage: 10,
                        labels: {
                            placeholder: "Cari data...",
                            perPage: "data per halaman",
                            noRows: "Tidak ada data yang ditemukan",
                            info: "Menampilkan {start} sampai {end} dari {rows} data",
                        }
                    });
                }
            });
        </script>
    </div>
</x-app-layout>