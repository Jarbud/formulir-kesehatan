<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Daftar Fakultas (Pengajuan Pemeriksaan)</h3>
                        <a href="{{ route('admin.export.excel.all') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white hover:bg-green-700 border border-transparent rounded-md text-sm font-bold transition shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Export Semua Data
                        </a>
                    </div>

                    <div class="mb-4">
                        <input type="text" id="searchFakultasInput" placeholder="Cari data..." class="w-full sm:w-64 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $item->fakultas }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700 text-center">
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                {{ $item->total_mahasiswa }} Mahasiswa
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('admin.fakultas.prodi', ['fakultas' => $item->fakultas]) }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 rounded-md text-xs font-bold transition">
                                                Lihat Program Studi
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
    </div>

@push('scripts')
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
        initTableSearch('fakultasTable', 'searchFakultasInput');
    });
</script>
@endpush
</x-app-layout>
