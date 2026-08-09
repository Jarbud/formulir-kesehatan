<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Rangkuman Pemeriksaan Kinerja') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('info'))
                <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('info') }}</span>
                </div>
            @endif

            <!-- FORM FILTER -->
            <div class="bg-white rounded-2xl shadow-xl shadow-slate-100 border border-slate-200 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-indigo-50 to-emerald-50 px-6 py-4 border-b border-slate-200">
                    <h3 class="text-sm font-bold text-slate-800">Filter Data Rangkuman</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Tentukan kriteria data yang ingin ditampilkan atau diunduh</p>
                </div>

                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.rangkuman') }}" method="GET">
                        {{-- Filter Akademik --}}
                        <div class="mb-6">
                            <div class="flex items-center space-x-2 mb-4">
                                <span class="p-1.5 bg-indigo-50 text-indigo-600 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </span>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Filter Akademik & Waktu</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                <div>
                                    <label for="fakultas" class="block text-xs font-semibold text-slate-700 mb-2">Fakultas (Opsional)</label>
                                    <select id="fakultas" name="fakultas" class="block w-full border-slate-200 rounded-xl shadow-sm bg-slate-50/50 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm transition py-2.5">
                                        <option value="">Semua Fakultas</option>
                                        @foreach($faculties as $faculty)
                                            <option value="{{ $faculty->name }}" {{ request('fakultas') == $faculty->name ? 'selected' : '' }}>{{ $faculty->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="prodi" class="block text-xs font-semibold text-slate-700 mb-2">Program Studi (Opsional)</label>
                                    <select id="prodi" name="prodi" class="block w-full border-slate-200 rounded-xl shadow-sm bg-slate-50/50 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm transition py-2.5">
                                        <option value="">Semua Program Studi</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="filter_waktu" class="block text-xs font-semibold text-slate-700 mb-2">Periode Waktu</label>
                                    <select id="filter_waktu" name="filter_waktu" class="block w-full border-slate-200 rounded-xl shadow-sm bg-slate-50/50 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm transition py-2.5" onchange="toggleWaktuInputs()">
                                        <option value="semua" {{ request('filter_waktu', 'semua') == 'semua' ? 'selected' : '' }}>Semua Waktu</option>
                                        <option value="harian" {{ request('filter_waktu') == 'harian' ? 'selected' : '' }}>Harian</option>
                                        <option value="bulanan" {{ request('filter_waktu') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                                        <option value="tahunan" {{ request('filter_waktu') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                                    </select>
                                </div>

                                <div id="input_tanggal" class="{{ request('filter_waktu') != 'harian' ? 'hidden' : '' }}">
                                    <label for="tanggal" class="block text-xs font-semibold text-slate-600 mb-1.5">Pilih Tanggal</label>
                                    <input type="date" id="tanggal" name="tanggal" value="{{ request('tanggal') }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm py-2">
                                </div>

                                <div id="input_bulan" class="{{ request('filter_waktu') != 'bulanan' ? 'hidden' : '' }}">
                                    <label for="bulan" class="block text-xs font-semibold text-slate-600 mb-1.5">Pilih Bulan</label>
                                    <select id="bulan" name="bulan" class="block w-full border-slate-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm py-2">
                                        <option value="">Pilih Bulan</option>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ sprintf('%02d', $i) }}" {{ request('bulan') == sprintf('%02d', $i) ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div id="input_tahun" class="{{ !in_array(request('filter_waktu'), ['bulanan', 'tahunan']) ? 'hidden' : '' }}">
                                    <label for="tahun" class="block text-xs font-semibold text-slate-600 mb-1.5">Pilih Tahun</label>
                                    <input type="number" id="tahun" name="tahun" min="2020" max="{{ date('Y') }}" value="{{ request('tahun', date('Y')) }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm py-2">
                                </div>
                            </div>
                        </div>

                        {{-- Filter Role --}}
                        <div class="mb-6 border-t border-slate-100 pt-6">
                            <div class="flex items-center space-x-2 mb-4">
                                <span class="p-1.5 bg-emerald-50 text-emerald-600 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </span>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Filter Role Petugas</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="role" class="block text-xs font-semibold text-slate-700 mb-2">Role Petugas</label>
                                    <select id="role" name="role" class="block w-full border-slate-200 rounded-xl shadow-sm bg-slate-50/50 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm transition py-2.5">
                                        <option value="semua" {{ request('role', 'semua') == 'semua' ? 'selected' : '' }}>Semua Role</option>
                                        <option value="perawat" {{ request('role') == 'perawat' ? 'selected' : '' }}>Perawat</option>
                                        <option value="dokter" {{ request('role') == 'dokter' ? 'selected' : '' }}>Dokter</option>
                                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6 border-t pt-6 border-slate-100">
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl hover:from-indigo-700 hover:to-indigo-800 font-bold shadow-md shadow-indigo-600/10 hover:shadow-lg hover:shadow-indigo-600/20 transition-all duration-200 active:scale-[0.98]">
                                <svg class="w-5 h-5 mr-2 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                Tampilkan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- RINGKASAN (muncul jika sudah filter) -->
            @if(request()->hasAny(['fakultas', 'prodi', 'filter_waktu', 'role']))
            <div class="bg-white rounded-2xl shadow-xl shadow-slate-100 border border-slate-200 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-sm font-bold text-slate-800">Ringkasan Data</h3>
                </div>
                <div class="p-6">
                    <div class="text-center p-4 bg-slate-50 rounded-xl border border-slate-200 max-w-xs mx-auto">
                        <div class="text-2xl font-bold text-slate-800">{{ $total }}</div>
                        <div class="text-xs font-semibold text-slate-500 mt-1 uppercase tracking-wider">Total Data</div>
                    </div>
                </div>
            </div>

            <!-- AKSI EXPORT -->
            <div class="bg-white rounded-2xl shadow-xl shadow-slate-100 border border-slate-200 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-slate-200">
                    <h3 class="text-sm font-bold text-slate-800">Export Data</h3>
                </div>
                <div class="p-6">

                    <!-- Export PDF per Batch -->
                    <div class="mb-6">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Export PDF per Batch</h4>
                        <form action="{{ route('admin.rangkuman.export_pdf') }}" method="POST" class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                            @csrf
                            <input type="hidden" name="fakultas" value="{{ request('fakultas') }}">
                            <input type="hidden" name="prodi" value="{{ request('prodi') }}">
                            <input type="hidden" name="filter_waktu" value="{{ request('filter_waktu') }}">
                            <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                            <input type="hidden" name="bulan" value="{{ request('bulan') }}">
                            <input type="hidden" name="tahun" value="{{ request('tahun') }}">

                            <div class="flex items-center gap-2">
                                <label for="role_export_pdf" class="text-xs font-semibold text-slate-600">Role:</label>
                                <select name="role" id="role_export_pdf" class="border-slate-200 rounded-lg text-sm py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                                    <option value="semua">Semua Role</option>
                                    <option value="perawat">Perawat</option>
                                    <option value="dokter">Dokter</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>

                            <div class="flex items-center gap-2">
                                <label for="batch" class="text-xs font-semibold text-slate-600">Jumlah per batch:</label>
                                <select name="batch" id="batch" class="border-slate-200 rounded-lg text-sm py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                                    <option value="25">25 data</option>
                                    <option value="50">50 data</option>
                                    <option value="75">75 data</option>
                                    <option value="100">100 data</option>
                                </select>
                            </div>

                            <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 font-bold shadow-md shadow-blue-600/10 hover:shadow-lg hover:shadow-blue-600/20 transition-all duration-200 active:scale-[0.98]">
                                <svg class="w-4 h-4 mr-2 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Export PDF (Formulir)
                            </button>
                        </form>
                    </div>

                    <!-- Export CSV -->
                    <div class="border-t border-slate-100 pt-6">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Export CSV / Excel</h4>
                        <form action="{{ route('admin.rangkuman.export_excel') }}" method="POST" class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                            @csrf
                            <input type="hidden" name="fakultas" value="{{ request('fakultas') }}">
                            <input type="hidden" name="prodi" value="{{ request('prodi') }}">
                            <input type="hidden" name="filter_waktu" value="{{ request('filter_waktu') }}">
                            <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                            <input type="hidden" name="bulan" value="{{ request('bulan') }}">
                            <input type="hidden" name="tahun" value="{{ request('tahun') }}">

                            <div class="flex items-center gap-2">
                                <label for="role_export_csv" class="text-xs font-semibold text-slate-600">Role:</label>
                                <select name="role" id="role_export_csv" class="border-slate-200 rounded-lg text-sm py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                                    <option value="semua">Semua Role</option>
                                    <option value="perawat">Perawat</option>
                                    <option value="dokter">Dokter</option>
                                </select>
                            </div>

                            <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl hover:from-emerald-700 hover:to-teal-700 font-bold shadow-md shadow-emerald-600/10 hover:shadow-lg hover:shadow-emerald-600/20 transition-all duration-200 active:scale-[0.98]">
                                <svg class="w-4 h-4 mr-2 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Unduh Laporan Excel (CSV)
                            </button>
                        </form>
                    </div>

                </div>
            </div>
            @endif

            <!-- TABEL PERAWAT + DOKTER -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Tabel Kinerja Perawat -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-indigo-50 px-6 py-4 border-b border-indigo-100 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-indigo-900">Total Pemeriksaan: Perawat</h3>
                        <span class="bg-white border border-indigo-200 text-[10px] font-bold text-indigo-600 rounded-full px-2.5 py-1">Telah di-ACC</span>
                    </div>
                    <div class="p-6">
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

    <!-- CSS & JS untuk fitur Search, Sort, dan Filter (Simple DataTables) -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3/dist/style.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
    <style>
        .dataTable-input, .dataTable-selector {
            border: 1px solid #e5e7eb !important;
            border-radius: 0.375rem !important;
            padding: 0.375rem 0.75rem !important;
            font-size: 0.875rem !important;
            outline: none !important;
        }
        .datatable-selector {
            width: 75px !important;
            padding-right: 1.75rem !important;
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
        const faculties = @json($faculties);

        document.addEventListener("DOMContentLoaded", function() {
            if (document.getElementById("perawatTable") && typeof simpleDatatables.DataTable !== 'undefined') {
                new simpleDatatables.DataTable("#perawatTable", {
                    searchable: true,
                    sortable: true,
                    perPage: 10,
                    labels: {
                        placeholder: "Cari perawat...",
                        perPage: "data per halaman",
                        noRows: "Tidak ada data yang ditemukan",
                        info: "Menampilkan {start} sampai {end} dari {rows} data",
                    }
                });
            }
            if (document.getElementById("dokterTable") && typeof simpleDatatables.DataTable !== 'undefined') {
                new simpleDatatables.DataTable("#dokterTable", {
                    searchable: true,
                    sortable: true,
                    perPage: 10,
                    labels: {
                        placeholder: "Cari dokter...",
                        perPage: "data per halaman",
                        noRows: "Tidak ada data yang ditemukan",
                        info: "Menampilkan {start} sampai {end} dari {rows} data",
                    }
                });
            }
        });

        // Prodi cascade
        document.getElementById('fakultas').addEventListener('change', function() {
            const selectedFacultyName = this.value;
            const prodiSelect = document.getElementById('prodi');
            prodiSelect.innerHTML = '<option value="">Semua Program Studi</option>';
            if (selectedFacultyName) {
                const faculty = faculties.find(f => f.name === selectedFacultyName);
                const prodis = faculty ? (faculty.program_studis || faculty.programStudis) : null;
                if (prodis) {
                    prodis.forEach(prodi => {
                        const option = document.createElement('option');
                        option.value = prodi.name;
                        option.textContent = prodi.name;
                        prodiSelect.appendChild(option);
                    });
                }
            }
        });

        function toggleWaktuInputs() {
            const filterWaktu = document.getElementById('filter_waktu').value;
            document.getElementById('input_tanggal').classList.toggle('hidden', filterWaktu !== 'harian');
            document.getElementById('input_bulan').classList.toggle('hidden', filterWaktu !== 'bulanan');
            document.getElementById('input_tahun').classList.toggle('hidden', filterWaktu !== 'bulanan' && filterWaktu !== 'tahunan');
        }
    </script>
</x-app-layout>
