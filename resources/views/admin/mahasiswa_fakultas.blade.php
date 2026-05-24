<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Mahasiswa: ') }} {{ $fakultas }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 shadow-sm text-gray-700 text-sm font-bold rounded-md transition">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Mahasiswa dari {{ $fakultas }}</h3>
                    
                    <div class="overflow-x-auto">
                        <table id="mahasiswaTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-y border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    <th class="px-6 py-4">No</th>
                                    <th class="px-6 py-4">NIM</th>
                                    <th class="px-6 py-4">Nama Lengkap</th>
                                    <th class="px-6 py-4">Program Studi</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($pemeriksaans as $item)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $item->nim }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $item->name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $item->prodi }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('admin.mahasiswa.detail', $item->user_id) }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 rounded-md text-xs font-bold transition">
                                                Detail Mahasiswa
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                            Belum ada data mahasiswa untuk fakultas ini.
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
            .dataTable-input, .dataTable-selector {
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
            .dataTable-input:focus, .dataTable-selector:focus {
                border-color: #3b82f6 !important;
                box-shadow: 0 0 0 1px #3b82f6 !important;
            }
            .dataTable-pagination a {
                border-radius: 0.375rem !important;
            }
            .dataTable-pagination .active a, .dataTable-pagination .active a:hover {
                background-color: #3b82f6 !important;
                color: white !important;
            }
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                if (document.getElementById("mahasiswaTable") && typeof simpleDatatables.DataTable !== 'undefined') {
                    new simpleDatatables.DataTable("#mahasiswaTable", {
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
