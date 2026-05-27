<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Program Studi: ') }} {{ $fakultas }}
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
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Program Studi di {{ $fakultas }}</h3>
                    
                    <div class="overflow-x-auto">
                        <table id="prodiTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-y border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    <th class="px-6 py-4">No</th>
                                    <th class="px-6 py-4">Program Studi</th>
                                    <th class="px-6 py-4 text-center">Total Mahasiswa</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($prodis as $item)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 font-semibold">
                                            {{ $item->prodi }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700 text-center">
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                {{ $item->total_mahasiswa }} Mahasiswa
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('admin.prodi.mahasiswa', ['fakultas' => $fakultas, 'prodi' => $item->prodi]) }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 rounded-md text-xs font-bold transition">
                                                Lihat Mahasiswa
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                            Belum ada data program studi.
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
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                if (document.getElementById("prodiTable") && typeof simpleDatatables.DataTable !== 'undefined') {
                    new simpleDatatables.DataTable("#prodiTable", {
                        searchable: true,
                        sortable: true,
                        perPage: 10
                    });
                }
            });
        </script>
    </div>
</x-app-layout>
