<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Mahasiswa: ') }} {{ $prodi }} ({{ $fakultas }})
            </h2>
            <a href="{{ route('admin.fakultas.prodi', ['fakultas' => $fakultas]) }}" class="px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 shadow-sm text-gray-700 text-sm font-bold rounded-md transition">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Mahasiswa Program Studi {{ $prodi }}</h3>
                    
                    <div class="mb-4">
                        <input type="text" id="searchMahasiswaInput" placeholder="Cari data..." class="w-full sm:w-64 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function initTableSearch(tableId, inputId) {
                    const input = document.getElementById(inputId);
                    const table = document.getElementById(tableId);
                    if (!input || !table) return;
                    input.addEventListener('input', function() {
                        const filter = this.value.toLowerCase();
                        const rows = table.querySelectorAll('tbody tr');
                        rows.forEach(row => {
                            const text = row.textContent.toLowerCase();
                            row.style.display = text.includes(filter) ? '' : 'none';
                        });
                    });
                }
                initTableSearch('mahasiswaTable', 'searchMahasiswaInput');
            });
        </script>
    </div>
</x-app-layout>
